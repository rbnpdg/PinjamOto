@extends('layout/user-nav')

@section('title', 'Edit Profil')

@section('content')
<h2 class="mt-5 mb-4 text-center">Edit Profil</h2>
<div class="d-flex justify-content-center px-3">
    <form action="{{ route('update-profile') }}" method="POST" style="width: 50%;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', auth()->user()->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', auth()->user()->username) }}" required>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">No Telp</label>
            <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', auth()->user()->telepon) }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" required>{{ old('alamat', auth()->user()->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                    <i class="fa fa-eye-slash" id="icon-password"></i>
                </span>
            </div>
        </div>
        <a href="{{ route('user-home') }}" class="btn btn-danger">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
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
@endsection

@section('scripts')
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
@endsection