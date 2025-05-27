<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class userController extends Controller
{
    public function show()
    {
        $user = User::all();
        return view('user', compact('user'));
    }

    public function tambah() {
        return view('user-add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:user,email',
            'username' => 'required|string|max:255|unique:user,username',
            'telepon'  => 'nullable|string|min:11|max:15|unique:user,telepon',
            'alamat'   => 'nullable|string',
            'password' => 'required|string|min:6',
            'role'   => 'required|in:Konsumen,Admin,Owner',
        ]);
        $data = $request->all();
        User::create($data);        

        return redirect()->route('user-show')->with('success', 'User berhasil ditambahkan');
    }


    public function edit(User $user)
    {
        return view('user-edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:user,email,' . $user->id,
            'username' => 'required|string|max:255|unique:user,username,' . $user->id,
            'telepon'  => 'nullable|string|min:11|max:15|unique:user,telepon,' . $user->id,
            'alamat'   => 'nullable|string',
            'password' => 'nullable|string|min:6',
            'role'     => 'required|in:Konsumen,Admin,Owner',
        ]);

        $data = [
            'nama'     => $request->nama,
            'email'    => $request->email,
            'username' => $request->username,
            'telepon'  => $request->telepon,
            'alamat'   => $request->alamat,
            'role'     => $request->role,
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('user-show')->with('success', 'Data user berhasil diupdate');
    }
}
