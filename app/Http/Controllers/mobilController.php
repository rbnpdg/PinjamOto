<?php

namespace App\Http\Controllers;
use App\Models\Mobil;

use Illuminate\Http\Request;

class mobilController extends Controller
{
    public function show()
    {
        $mobil = Mobil::all();
        return view('mobil', compact('mobil'));
    }

    public function tambah() {
        return view('mobil-add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tahun' => 'required|digits:4|integer|min:2000',
            'tnkb' => 'required|unique:mobil',
            'status' => 'required|in:Tersedia,Disewa,Maintenance',
        ]);
        
        Mobil::create($request->all());
        return redirect()->route('mobil-show')->with('success', 'Mobil berhasil ditambahkan');
    }

    public function edit(Mobil $mobil)
    {
        return view('mobil-edit', compact('mobil'));
    }


    public function update(Request $request, Mobil $mobil)
    {
        $request->validate([
            'nama' => 'required',
            'tahun' => 'required|digits:4|integer|min:2000',
            'tnkb' => 'required|unique:mobil,tnkb,' . $mobil->id,
            'status' => 'required',
        ]);

        $mobil->update($request->all());
        return redirect()->route('mobil-show')->with('success', 'Data mobil berhasil diupdate');
    }

    public function destroy(Mobil $mobil)
    {
        $mobil->delete();
        return redirect()->route('mobil-show')->with('success', 'Data mobil berhasil dihapus');
    }
}
