<?php

namespace App\Http\Controllers;
use App\Models\Mobil;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class ownerController extends Controller
{
    public function show(Request $request)
    {
        $mobil = Mobil::all();

        $query = Mobil::query();

        if ($request->filled('merk')) {
            $query->where('nama', 'like', '%' . $request->merk . '%');
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        if ($request->filled('bbm')) {
            $query->where('bbm', $request->bbm);
        }
        if ($request->filled('tahun')) {
            [$start, $end] = explode('-', $request->tahun);
            $query->whereBetween('tahun', [$start, $end]);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('tnkb', 'like', '%' . $request->search . '%');
            });
        }

        $mobil = $query->get();

        return view('owner-mobil', compact('mobil'));
    }

    public function trShow(Request $request)
    {
        $query = Transaksi::with(['user', 'mobil']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_transaksi', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('harga')) {
            switch ($request->harga) {
                case '<1juta':
                    $query->where('total_biaya', '<', 1000000);
                    break;
                case '1-2juta':
                    $query->whereBetween('total_biaya', [1000000, 2000000]);
                    break;
                case '2-3juta':
                    $query->whereBetween('total_biaya', [2000000, 3000000]);
                    break;
                case '>3juta':
                    $query->where('total_biaya', '>', 3000000);
                    break;
            }
        }

        if ($request->filled('rentang_waktu')) {
            $days = (int) $request->rentang_waktu;
            $query->where('tanggal_transaksi', '>=', now()->subDays($days));
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('nama', 'like', '%' . $request->search . '%');
                })->orWhereHas('mobil', function ($m) use ($request) {
                    $m->where('nama', 'like', '%' . $request->search . '%');
                });
            });
        }

        $transaksis = $query->latest()->get();

        return view('owner-transaksi', compact('transaksis'));
    }

    public function editShow() {
        return view('owner-edit-profile');
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

        return redirect()->route('owner-dash')->with('success', 'Profil berhasil diperbarui.');
    }
}
