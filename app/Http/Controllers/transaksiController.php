<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\Mobil;
use App\Models\User;

use Illuminate\Http\Request;

class transaksiController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'Konsumen')->get();
        $mobils = Mobil::where('status', 'Tersedia')->get(); // jika juga dipakai di blade
        $transaksi = Transaksi::with('user', 'mobil')->latest()->get();

        return view('transaksi', compact('transaksi', 'users', 'mobils'));
    }


    public function create()
    {
        $users = User::where('role', 'Konsumen')->get();
        $mobils = Mobil::where('status', 'Tersedia')->get();
        return view('transaksi.create', compact('users', 'mobils'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:Menunggu,Disetujui,Ditolak'
        ]);

        $mobil = Mobil::findOrFail($request->mobil_id);
        $selisihHari = \Carbon\Carbon::parse($request->tanggal_mulai)->diffInDays($request->tanggal_selesai);
        $totalHarga = $mobil->{"harga-sewa"} * $selisihHari;

        $transaksi = Transaksi::create([
            'user_id' => $request->user_id,
            'mobil_id' => $request->mobil_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'total_harga' => $totalHarga,
            'status' => $request->status
        ]);

        // Jika disetujui langsung, ubah status mobil
        if ($request->status === 'Disetujui') {
            $mobil->update(['status' => 'Disewa']);
        }

        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil ditambahkan');
    }


    public function approve($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        if ($transaksi->status !== 'Menunggu') {
            return redirect()->route('transaksi')->with('error', 'Transaksi tidak valid untuk disetujui.');
        }

        $transaksi->status = 'Disetujui';
        $transaksi->save();

        // Tandai mobil jadi "Disewa"
        $transaksi->mobil->update(['status' => 'Disewa']);

        return redirect()->route('transaksi')->with('success', 'Transaksi disetujui.');
    }

    public function reject($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== 'Menunggu') {
            return redirect()->route('transaksi')->with('error', 'Transaksi tidak valid untuk ditolak.');
        }

        $transaksi->status = 'Ditolak';
        $transaksi->save();

        // Kembalikan status mobil ke 'Tersedia'
        $transaksi->mobil->update(['status' => 'Tersedia']);

        return redirect()->route('transaksi')->with('success', 'Transaksi ditolak.');
}


}
