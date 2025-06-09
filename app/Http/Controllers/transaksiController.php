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

class transaksiController extends Controller
{
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

    public function reject($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'Dibatalkan';
        $transaksi->save();
        $transaksi->mobil->update(['status' => 'Tersedia']);
        return redirect()->route('transaksi-show')->with('success', 'Transaksi dibatalkan.');
    }
}
