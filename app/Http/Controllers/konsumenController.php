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


    public function tambahKeranjang(Request $request, $id)
    {
        $mobil = Mobil::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['jumlah'] += 1;
        } else {
            $cart[$id] = [
                'nama' => $mobil->nama,
                'gambar' => $mobil->gambar,
                'harga' => $mobil->hargasewa,
                'jumlah' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('katalog-show')->with('success', 'Mobil ditambahkan ke keranjang!');
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
