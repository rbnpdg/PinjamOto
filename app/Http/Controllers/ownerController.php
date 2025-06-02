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

    public function trShow()
    {
        $transaksis = Transaksi::with(['user', 'mobil'])->latest()->get();

        return view('owner-transaksi', compact('transaksis'));
    }
}
