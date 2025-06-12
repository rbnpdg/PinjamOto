<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PinjamOTO')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
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
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="{{ route('home') }}">PinjamOTO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
<<<<<<< Updated upstream
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold text-danger' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('cars') ? 'active fw-bold text-danger' : '' }}" href="{{ route('cars') }}">Mobil</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('cart') ? 'active fw-bold text-danger' : '' }}" href="{{ route('cart') }}">Keranjang</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active fw-bold text-danger' : '' }}" href="{{ route('about') }}">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active fw-bold text-danger' : '' }}" href="{{ route('contact') }}">Kontak</a></li>
=======
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('user-home') ? 'active fw-bold text-danger' : '' }}" href="{{ route('user-home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('mobil-katalog') ? 'active fw-bold text-danger' : '' }}" href="{{ route('mobil-katalog') }}">Mobil</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('favorite') ? 'active fw-bold text-danger' : '' }}" href="{{ route('favorite') }}">Favorit</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('kontak') ? 'active fw-bold text-danger' : '' }}" href="{{ route('kontak') }}">Kontak</a></li>
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('img/profile.png') }}" width="40" height="40" class="rounded-circle" alt="Profile">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href=#>Edit Profil</a></li>
                            <li><a class="dropdown-item" href=#>Histori Transaksi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login-show') }}">Login</a></li>
                    @endauth
>>>>>>> Stashed changes
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-light text-center py-4 mt-5">
        <p class="mb-0 text-muted">&copy; {{ date('Y') }} PinjamOTO - All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
