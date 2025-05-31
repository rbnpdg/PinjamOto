<?php

namespace App\Http\Controllers;
use App\Models\Mobil;
use Illuminate\Support\Facades\Storage;
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
            'tipe' => 'nullable|in:Mpv,SUV,Sedan,City car',
            'tnkb' => 'required|unique:mobil',
            'kapasitas' => 'nullable|integer|min:1',
            'transmisi' => 'nullable|in:Manual,Otomatis',
            'bbm' => 'nullable|in:Bensin,Diesel,Listrik',
            'hargasewa' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Disewa,Maintenance',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('gambar');
        
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('mobil', 'public');
        }

        Mobil::create($data);

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
            'tipe' => 'nullable|in:Mpv,SUV,Sedan,City car',
            'tnkb' => 'required|unique:mobil,tnkb,' . $mobil->id,
            'kapasitas' => 'nullable|integer|min:1',
            'transmisi' => 'nullable|in:Manual,Otomatis',
            'bbm' => 'nullable|in:Bensin,Diesel,Listrik',
            'hargasewa' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Disewa,Maintenance',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($mobil->gambar) {
                Storage::disk('public')->delete($mobil->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('mobil', 'public');
        }

        $mobil->update($data);

        return redirect()->route('mobil-show')->with('success', 'Data mobil berhasil diupdate');
    }


    public function destroy(Mobil $mobil)
    {
        $mobil->delete();
        return redirect()->route('mobil-show')->with('success', 'Data mobil berhasil dihapus');
    }
}
