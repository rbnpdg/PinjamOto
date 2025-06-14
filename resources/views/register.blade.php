@extends('layout/app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 d-none d-md-block bg-left"></div>

        <div class="col-md-4 form-section">
            <div class="form-wrapper">
                <h3 class="fw-bold text-center text-danger">Register</h3>
                <form method="POST" action="{{ route('register-store') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ old('nama') }}" id="nama" name="nama" required>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ old('email') }}" id="email" name="email" required>
                    </div>
                    <div class="mb-2">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" value="{{ old('username') }}" id="username" name="username" required>
                    </div>
                    <div class="mb-2">
                        <label for="telepon" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" value="{{ old('telepon') }}" id="telepon" name="telepon">
                    </div>
                    <div class="mb-2">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" value="{{ old('alamat') }}" id="alamat" name="alamat" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                                <i class="fa fa-eye-slash" id="icon-password"></i>
                            </span>
                        </div>
                    </div>
                    <input type="hidden" name="role" value="Konsumen">

                    <div class="d-grid">
                        <button type="submit" class="btn btn-daftar btn-danger">Daftar</button>
                    </div>

                    <div class="mt-3 text-center">
                        <p class="small">Sudah punya akun? 
                            <a href="{{ route('login-show') }}" class="text-decoration-none">
                                <b>Login</b>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const toggle = document.getElementById('toggle-password');
        const icon = document.getElementById('icon-password');

        toggle.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    });

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Registrasi Gagal',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33'
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Registrasi Gagal',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#d33'
        });
    @endif
</script>
@endsection