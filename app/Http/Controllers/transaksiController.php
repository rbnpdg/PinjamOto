<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\Mobil;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;

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


}
