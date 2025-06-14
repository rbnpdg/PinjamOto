@extends('layout/app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 d-none d-md-block bg-left"></div>

        <div class="col-md-4 form-section">
            <div class="form-wrapper">
                <h3 class="fw-bold text-center text-danger">Login</h3>
                <form method="POST" action="{{ url('/login/session') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ Session::get('email') }}" required>
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
                    <div class="d-grid mb-2">
                        <button type="submit" class="btn btn-daftar btn-danger">Login</button>
                    </div>
                    <div class="mt-3 text-center">
                        <p class="small">Belum punya akun? 
                            <a href="{{ route('register-show') }}" class="text-decoration-none">
                                <b>Daftar</b>
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
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal!',
            text: {!! json_encode(session('error')) !!},
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection
