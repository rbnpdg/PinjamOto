<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Mobil;
use App\Models\User;
use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Midtrans\Notification;
use Midtrans\Config as MidtransConfig;

class transaksiController extends Controller
{
    public function __construct()
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;
    }

    public function handle(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashed != $request->signature_key) {
            return response(['message' => 'Invalid signature'], 403);
        }

        // Ambil ID transaksi dari order_id format: TRX-{id}-{timestamp}
        $order_id_parts = explode('-', $request->order_id);
        $transaksi_id = $order_id_parts[1];

        $transaksi = Transaksi::find($transaksi_id);
        if (!$transaksi) {
            return response(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $transactionStatus = $request->transaction_status;

        if ($transactionStatus === 'settlement') {
            $transaksi->status = 'Berjalan';
            $transaksi->status_payment = 'Dibayar';
        } elseif (in_array($transactionStatus, ['cancel', 'expire', 'deny'])) {
            $transaksi->status = 'Dibatalkan';
            $transaksi->status_payment = 'Ditolak';
        } elseif ($transactionStatus === 'pending') {
            $transaksi->status_payment = 'Menunggu Pembayaran';
        } else {
            $transaksi->status_payment = ucfirst($transactionStatus);
        }

        $transaksi->save();

        return response(['message' => 'Callback diterima'], 200);
    }

    public function show()
    {
        $transaksis = Transaksi::with(['user', 'mobil'])->latest()->get();
        return view('transaksi', compact('transaksis'));
    }

    public function tambah()
    {
        $users = User::where('role', 'Konsumen')->get();
        $mobils = Mobil::where('status', 'Tersedia')->get();
        return view('transaksi-add', compact('users', 'mobils'));
    }

    //store transaksi admin 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:user,id',
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'metode_pembayaran' => 'required|string'
        ]);

        $aktif = Transaksi::where('user_id', $request->user_id)
            ->where('status', 'Berjalan')->exists();

        if ($aktif) {
            return back()->withErrors(['user_id' => 'User ini memiliki sewa aktif!'])->withInput();
        }

        $mobilAktif = Transaksi::where('mobil_id', $request->mobil_id)
            ->where('status', 'Berjalan')->exists();

        if ($mobilAktif) {
            return back()->withErrors(['mobil_id' => 'Mobil sedang disewa!'])->withInput();
        }

        $mobil = Mobil::findOrFail($request->mobil_id);
        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);
        $lamaHari = $mulai->diffInDays($selesai) + 1;
        $total = $mobil->hargasewa * $lamaHari;

        $transaksi = Transaksi::create([
            'user_id' => $request->user_id,
            'mobil_id' => $request->mobil_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'Menunggu',
            'total_biaya' => $total,
            'tanggal_transaksi' => now(),
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        if (strtolower($request->metode_pembayaran) == 'duitku') {
            return redirect()->route('transaksi.bayar.duitku', ['id' => $transaksi->id]);
        }

        $mobil->status = 'Disewa';
        $mobil->save();

        return redirect()->route('transaksi-show')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function previewAdmin(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $mobil = Mobil::findOrFail($request->mobil_id);

        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;

        $start = new \DateTime($tanggal_mulai);
        $end = new \DateTime($tanggal_selesai);
        $selisih = $start->diff($end)->days;
        $total_biaya = $mobil->hargasewa * $selisih;
        $metode_pembayaran = $request->metode_pembayaran;

        return view('transaksi-admprev', compact(
            'user', 'mobil', 'tanggal_mulai', 'tanggal_selesai', 'total_biaya', 'metode_pembayaran'
        ));
    }


    public function preview(Request $request)
    {
        $request->validate([
            'mobil_id' => 'required|exists:mobil,id',
            'user_id' => 'required|exists:user,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $mobil = Mobil::findOrFail($request->mobil_id);

        // Hitung durasi sewa
        $start = new \Carbon\Carbon($request->tanggal_mulai);
        $end = new \Carbon\Carbon($request->tanggal_selesai);
        $days = $start->diffInDays($end) + 1;

        // Hitung total harga
        $totalHarga = $days * $mobil->hargasewa;

        return view('transaksi-preview', [
            'mobil' => $mobil,
            'user' => auth()->user(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi' => $days,
            'total' => $totalHarga,
        ]);
    }

    public function storeMidtrans(Request $request)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $user = auth()->user();
        $mobil = Mobil::findOrFail($request->mobil_id);

        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);
        $lamaHari = $mulai->diffInDays($selesai) + 1;
        $total = $mobil->hargasewa * $lamaHari;

        // Buat Transaksi (belum dibayar)
        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'mobil_id' => $mobil->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_biaya' => $total,
            'status' => 'Menunggu',
            'status_payment' => 'Menunggu',
            'tanggal_transaksi' => now(),
            'metode_pembayaran' => 'midtrans',
        ]);

        return redirect()->route('transaksi.bayar.midtrans', ['id' => $transaksi->id]);
    }

    public function bayarMidtrans(Request $request, $id)
    {
        $transaksi = Transaksi::with('user', 'mobil')->findOrFail($id);

        $params = [
            'transaction_details' => [
                'order_id' => 'TRX-' . $transaksi->id . '-' . time(),
                'gross_amount' => $transaksi->total_biaya,
            ],
            'customer_details' => [
                'first_name' => $transaksi->user->name,
                'email' => $transaksi->user->email,
            ],
            'item_details' => [
                [
                    'id' => $transaksi->mobil->id,
                    'price' => $transaksi->mobil->hargasewa,
                    'quantity' => \Carbon\Carbon::parse($transaksi->tanggal_mulai)->diffInDays($transaksi->tanggal_selesai) + 1,
                    'name' => 'Sewa Mobil ' . $transaksi->mobil->nama
                ]
            ],
            'callbacks' => [
                'finish' => route('mobil-katalog'),  // ⬅️ URL redirect setelah selesai bayar
            ]
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $tanggal_mulai = $transaksi->tanggal_mulai;
        $tanggal_selesai = $transaksi->tanggal_selesai;
        $durasi = now()->parse($tanggal_mulai)->diffInDays(now()->parse($tanggal_selesai)) + 1;

        return view('payment-midtrans', [
            'user' => $transaksi->user,
            'mobil' => $transaksi->mobil,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'durasi' => $durasi,
            'total' => $transaksi->total_biaya,
            'snapToken' => $snapToken,
        ]);
    }


    public function showPayment($metode, Request $request)
    {
        // Validasi metode
        $allowed = ['qris', 'gopay', 'bni', 'bca', 'cod'];
        if (!in_array($metode, $allowed)) {
            abort(404);
        }

        $user = User::findOrFail($request->user_id);
        $mobil = Mobil::findOrFail($request->mobil_id);

        return view('payment-' . $metode, [
            'metode' => strtoupper($metode),
            'user' => $user,
            'mobil' => $mobil,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_biaya' => $request->total_biaya
        ]);
    }
    
    public function konfirmasiBayar(Request $request)
    {
        // Validasi
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'total_biaya' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string|in:qris,gopay,bni,bca,cod',
        ]);

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'user_id' => $request->user_id,
            'mobil_id' => $request->mobil_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_biaya' => $request->total_biaya,
            'status' => 'Menunggu',
            'tanggal_transaksi' => now(),
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        $mobil = Mobil::find($request->mobil_id);
        if ($mobil) {
            $mobil->status = 'Disewa';
            $mobil->save();
        }

        return redirect()->route('mobil-katalog')->with('success', 'Transaksi Anda berhasi! Mohon tunggu validasi admin');
    }

    public function konfirmasiPembayaran($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Update status pembayaran dan status transaksi
        $transaksi->update([
            'status_payment' => 'Dibayar',
            'status' => 'Berjalan',
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dikonfirmasi dan status diubah menjadi Berjalan.');
    }

    public function tolakPembayaran($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Pastikan hanya menolak jika status_payment masih menunggu
        if ($transaksi->status_payment !== 'Menunggu') {
            return redirect()->back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        $transaksi->update([
            'status_payment' => 'Ditolak',
            'status' => 'Dibatalkan',
        ]);

        $mobil = Mobil::find($transaksi->mobil_id);

        if ($mobil) {
            $mobil->status = 'Tersedia';
            $mobil->save();
        }

        return redirect()->back()->with('success', 'Transaksi telah ditolak dan dibatalkan.');
    }

    public function finish($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'Selesai';
        $transaksi->save();
        $transaksi->mobil->update(['status' => 'Tersedia']);
        return redirect()->route('transaksi-show')->with('success', 'Transaksi berhasil diselesaikan.');
    }

    // public function reject($id)
    // {
    //     $transaksi = Transaksi::findOrFail($id);
    //     $transaksi->status = 'Dibatalkan';
    //     $transaksi->save();
        
    //     $mobil = Mobil::find($transaksi->mobil_id);

    //     if ($mobil) {
    //         $mobil->status = 'Tersedia';
    //         $mobil->save();
    //     }

    //     return redirect()->route('transaksi-show')->with('success', 'Transaksi dibatalkan.');
    // }
}
