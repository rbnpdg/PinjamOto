<!DOCTYPE html>
<html lang="id" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-white.png') }}">
    <title>@yield('title', 'Katalog')</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .menu-image {
            height: 200px;
            object-fit: cover;
        }

        .hero {
            background: url('{{ asset('img/banner-bg.png') }}') no-repeat center center;
            background-size: cover;
            height: 400px;
            position: relative;
            color: white;
        }

        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-shadow: 1px 1px 3px black;
        }

        .mobil-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="">PinjamOTO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('user-home') ? 'active fw-bold text-danger' : '' }}" href="{{ route('user-home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('mobil-katalog') ? 'active fw-bold text-danger' : '' }}" href="{{ route('mobil-katalog') }}">Mobil</a></li>
                    <li class="nav-item"><a class="nav-link">Keranjang</a></li>
                    <li class="nav-item"><a class="nav-link">Kontak</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login-show') }}">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-light text-center py-4 mt-auto">
        <p class="mb-0 text-muted">&copy; {{ date('Y') }} PinjamOTO - All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
