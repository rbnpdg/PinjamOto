<?php

namespace App\Http\Controllers;
use App\Models\Mobil;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class ownerController extends Controller
{
    public function show()
    {
        $mobil = Mobil::all();
        return view('owner-mobil', compact('mobil'));
    }

    public function trShow(Request $request)
    {
        $query = Transaksi::with(['user', 'mobil']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $transaksis = $query->latest()->get();

        return view('owner-transaksi', compact('transaksis'));
        // $transaksis = Transaksi::with(['user', 'mobil'])->latest()->get();

        // return view('owner-transaksi', compact('transaksis'));
    }
}
