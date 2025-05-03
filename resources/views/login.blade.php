@extends('layout/app')

@section('content')
    <div class="login-container">
        <div class="login-box col-md-4">
            <img src="{{ asset('/img/logo.png') }}" alt="Logo">
            <form action="/login/session" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="email" name="email" value="{{ Session::get('email') }}" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection