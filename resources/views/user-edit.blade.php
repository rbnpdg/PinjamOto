@extends('layout/admin-nav')

@section('content')
<h2 class="mt-5 mb-4 text-center">Edit User</h2>
<div class="d-flex justify-content-center ml-4 mr-4">
    <form action="{{ route('user-update', $user->id) }}" class="mb-4" method="POST" style="width: 50%;">
        @csrf
        @method('PUT')  
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">No Telp</label>
            <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $user->telepon) }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" required>{{ old('alamat', $user->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password">
                <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                    <i class="fa fa-eye-slash" id="icon-password"></i>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="">-- Pilih Status --</option>
                <option value="Konsumen" {{ old('role', $user->role) == 'Konsumen' ? 'selected' : '' }}>Konsumen</option>
                <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Owner" {{ old('role', $user->role) == 'Owner' ? 'selected' : '' }}>Owner</option>
            </select>
        </div>

        <a href="{{ route('user-show') }}" class="btn btn-danger">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const toggle = document.getElementById('toggle-password');
            const icon = document.getElementById('icon-password');

            if (toggle) {
                toggle.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>

    @if ($errors->any())
    <script>       
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonText: 'Tutup'
        });
    </script>
    @endif
</div>
@endsection