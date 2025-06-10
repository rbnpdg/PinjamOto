    @extends('layout/app')

    @section('content')
        <div class="login-container">
            <div class="login-box col-md-4 p-4 rounded">
                <img src="{{ asset('/img/logo-full.png') }}" alt="Logo">
                <form action="/login/session" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="email" name="email" value="{{ Session::get('email') }}" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
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