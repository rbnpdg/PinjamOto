<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\Transaksi;

class konsumenController extends Controller
{
    public function home()
    {
        $mobil = Mobil::all();
        return view('konsumen-home', compact('mobil'));
    }

    public function kontak()
    {
        return view('konsumen-kontak');
    }

    public function historiShow()
    {
        $user = auth()->user();

        $transaksis = Transaksi::where('user_id', $user->id)
            ->with('mobil')
            ->latest()
            ->get();

        return view('konsumen-histori', compact('transaksis'));
    }

    public function filterHistori(Request $request)
    {
        $user = auth()->user();

        $query = Transaksi::where('user_id', $user->id);

        // Filter waktu
        if ($request->filled('waktu')) {
            $query->where('tanggal_transaksi', '>=', now()->subDays($request->waktu));
        }

        // Filter metode pembayaran
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->whereHas('mobil', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $transaksis = $query->latest()->get();

        return view('konsumen-histori', compact('transaksis'));
    }

    public function katalog()
    {
        
        $mobil = Mobil::where('status', 'Tersedia')->get();
        $user = auth()->user();

        $pesananAktif = false;
        if ($user) {
            $pesananAktif = Transaksi::where('user_id', $user->id)
                ->whereIn('status', ['Berjalan', 'Menunggu'])
                ->exists();
        }

        return view('konsumen-katalog', compact('mobil', 'pesananAktif'));
    }

    public function tambahkeranjangShow($id)
    {
        $mobil = Mobil::findOrFail($id);
        return view('konsumen-keranjang-add', compact('mobil'));
    }

    public function editProfile() {
        return view('konsumen-edit-profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $user->id,
            'username' => 'required|string|max:255|unique:user,username,' . $user->id,
            'telepon' => 'required|string|max:20|unique:user,telepon,' . $user->id,
            'alamat' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('user-home')->with('success', 'Profil berhasil diperbarui.');
    }


    public function filter(Request $request)
    {
        $query = mobil::query();

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('bbm')) {
            $query->where('bbm', $request->bbm);
        }

        if ($request->filled('tahun')) {
            [$start, $end] = explode('-', $request->tahun);
            $query->whereBetween('tahun', [(int)$start, (int)$end]);
        }

        if ($request->filled('harga')) {
            [$min, $max] = explode('-', $request->harga);
            $query->whereBetween('hargasewa', [(int)$min, (int)$max]);
        }

        $mobil = $query->get();

        return view('konsumen-katalog', compact('mobil'));
    }

    public function pesanShow($id) {
        $mobil = Mobil::findOrFail($id);
        return view('konsumen-pesan', compact('mobil'));
    }

}
