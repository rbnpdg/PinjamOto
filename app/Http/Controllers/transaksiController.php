<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\Mobil;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        $mobil = Mobil::where('status', 'Tersedia')->get();
        return view('transaksi-add', compact('users', 'mobil'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:user,id',
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Cek apakah user sudah punya transaksi aktif
        $aktif = Transaksi::where('user_id', $request->user_id)
                ->where('status', 'Berjalan')  // ganti dengan status transaksi aktif kamu
                ->exists();

        if ($aktif) {
            return redirect()->back()->withInput()->withErrors(['user_id' => 'User ini memiliki sewa aktif!']);
        }

        // Cek mobil sudah disewa aktif?
        $mobilAktif = Transaksi::where('mobil_id', $request->mobil_id)
                    ->where('status', 'Berjalan')
                    ->exists();

        if ($mobilAktif) {
            return redirect()->back()->withInput()->withErrors(['mobil_id' => 'Mobil sedang disewa!']);
        }
        
        // Ambil data mobil dan hitung lama sewa
        $mobil = Mobil::findOrFail($request->mobil_id);
        $mulai = Carbon::parse($request->tanggal_mulai);
        $selesai = Carbon::parse($request->tanggal_selesai);
        $lamaHari = $mulai->diffInDays($selesai) + 1; // termasuk hari pertama
        $total = $mobil->hargasewa * $lamaHari;

        Transaksi::create([
            'user_id' => $request->user_id,
            'mobil_id' => $request->mobil_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'Berjalan',
            'total_biaya' => $total,
        ]);

        $mobil->update(['status' => 'Disewa']);

        return redirect()->route('transaksi-show')->with('success', 'Transaksi berhasil ditambahkan');
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

        // Kembalikan status mobil ke 'Tersedia'
        $transaksi->mobil->update(['status' => 'Tersedia']);

        return redirect()->route('transaksi-show')->with('success', 'Transaksi dibatalkan.');
    }

    public function duitkuCallback(Request $request)
    {
        $payload = $request->all();

        // Validasi signature
        $expectedSignature = hash('sha256',
            $payload['merchantCode'] .
            $payload['amount'] .
            $payload['merchantOrderId'] .
            env('DUITKU_API_KEY')
        );

        if ($payload['signature'] !== $expectedSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Cari transaksi berdasarkan merchantOrderId
        $orderId = $payload['merchantOrderId'];
        $statusCode = $payload['statusCode'];

        $transaksi = Transaksi::where('id', $orderId)->first();
        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Update status transaksi dan mobil
        if ($statusCode == '00') {
            $transaksi->status = 'Berhasil';
            $transaksi->mobil->update(['status' => 'Disewa']);
        } elseif ($statusCode == '01') {
            $transaksi->status = 'Menunggu';
        } else {
            $transaksi->status = 'Gagal';
            $transaksi->mobil->update(['status' => 'Tersedia']);
        }

        $transaksi->save();

        return response()->json(['message' => 'OK']);
    }

    public function storeBayar(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mobil_id' => 'required|exists:mobils,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $mobil = Mobil::findOrFail($request->mobil_id);

        $selisihHari = now()->parse($request->tanggal_mulai)->diffInDays($request->tanggal_selesai) + 1;
        $totalBiaya = $mobil->harga_sewa * $selisihHari;

        $transaksi = Transaksi::create([
            'user_id' => $request->user_id,
            'mobil_id' => $mobil->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_biaya' => $totalBiaya,
            'status' => 'menunggu pembayaran',
            'tanggal_transaksi' => now(),
        ]);

        return redirect()->route('transaksi.bayar.duitku', ['id' => $transaksi->id]);
    }


    public function bayarDuitku($id)
    {
        $transaksi = Transaksi::with('user', 'mobil')->findOrFail($id);

        $merchantCode = config('services.duitku.merchant_code');
        $apiKey = config('services.duitku.api_key');
        $callbackUrl = config('services.duitku.callback_url');

        dd([
    'merchant_code' => $merchantCode,
    'api_key' => $apiKey,
    'callback_url' => $callbackUrl,
]);

        $paymentAmount = $transaksi->total_biaya;
        $merchantOrderId = 'INV' . $transaksi->id;
        $productDetails = "Sewa Mobil: " . $transaksi->mobil->nama;

        $signature = hash('sha256', $merchantCode . $merchantOrderId . $paymentAmount . $apiKey);

        $params = [
            'merchantCode' => $merchantCode,
            'paymentAmount' => $paymentAmount,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'email' => $transaksi->user->email ?? 'dummy@email.com',
            'customerVaName' => $transaksi->user->nama,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => url('/pesanan/sukses'),
            'signature' => $signature,
            'expiryPeriod' => 60,
        ];

        $url = config('services.duitku.env') === 'sandbox'
            ? 'https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry'
            : 'https://passport.duitku.com/webapi/api/merchant/v2/inquiry';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $params);

        if ($response->successful() && isset($response->json()['paymentUrl'])) {
            return redirect($response->json()['paymentUrl']);
        }

        return back()->with('error', 'Gagal membuat transaksi pembayaran dengan Duitku.');
    }


    public function bayar(Request $request)
    {
        $request->validate([
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $mobil = Mobil::findOrFail($request->mobil_id);
        $lamaHari = Carbon::parse($request->tanggal_mulai)->diffInDays(Carbon::parse($request->tanggal_selesai)) + 1;
        $totalBiaya = $mobil->hargasewa * $lamaHari;

        // Buat transaksi lokal dulu
        $transaksi = Transaksi::create([
            'user_id' => auth()->id(),
            'mobil_id' => $mobil->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_biaya' => $totalBiaya,
            'status' => 'Menunggu',
            'tanggal_transaksi' => now(),
        ]);

        // Buat merchantOrderId unik (gunakan ID transaksi lokal)
        $merchantOrderId = $transaksi->id;
        $transaksi->merchant_order_id = $merchantOrderId;
        $transaksi->save();

        // Kirim ke Duitku
        $merchantCode = env('DUITKU_MERCHANT_CODE');
        $apiKey = env('DUITKU_API_KEY');
        $callbackUrl = route('duitku.callback');
        $returnUrl = route('transaksi-show');

        $paymentAmount = $totalBiaya;
        $productDetails = 'Sewa Mobil ' . $mobil->nama;

        $signature = hash('sha256', $merchantCode . $merchantOrderId . $paymentAmount . $apiKey);

        $params = [
            'merchantCode' => $merchantCode,
            'paymentAmount' => $paymentAmount,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'email' => auth()->user()->email,
            'customerVaName' => auth()->user()->name,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'signature' => $signature,
            'expiryPeriod' => 60,
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post('https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry', $params);

        $result = $response->json();

        if (isset($result['paymentUrl'])) {
            return redirect($result['paymentUrl']);
        } else {
            return back()->with('error', 'Gagal memproses pembayaran');
        }
    }
}
