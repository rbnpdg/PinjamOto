<!DOCTYPE html>
<html lang="id" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-white.png') }}">
    <title>@yield('title', 'Katalog')</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://app-sandbox.duitku.com/lib/js/duitku.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-...hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

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

       .dropdown-toggle::after {
            display: none !important;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
        <div class="container">
            <div class="d-flex align-items-center w-100">
                <a class="navbar-brand fw-bold text-danger me-auto" href="">PinjamOTO</a>
                <div class="d-none d-lg-block w-100 text-center">
                    <ul class="navbar-nav d-inline-flex gap-3">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('user-home') ? 'active fw-bold text-danger' : '' }}" href="{{ route('user-home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('mobil-katalog') ? 'active fw-bold text-danger' : '' }}" href="{{ route('mobil-katalog') }}">Mobil</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('favorite') ? 'active fw-bold text-danger' : '' }}" href="{{ route('favorite') }}">Favorit</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('kontak') ? 'active fw-bold text-danger' : '' }}" href="{{ route('kontak') }}">Kontak</a></li>
                    </ul>
                </div>
                @auth
                <div class="ms-auto">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('img/profile.png') }}" width="40" height="40" class="rounded-circle" style="object-fit: cover;">
                            <span class="fw-semibold ms-2">{{ Auth::user()->nama }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('edit-show') }}">Edit Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('histori-show') }}">Histori Transaksi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="GET" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                @else
                <div class="ms-auto">
                    <a href="{{ route('login-show') }}" class="btn btn-outline-danger">Login</a>
                </div>
                @endauth
            </div>
        </div>
    </nav>


    <main class="mt-5">
        @yield('content')
    </main>

    <footer class="bg-light text-center py-4 mt-auto">
        <p class="mb-0 text-muted">&copy; {{ date('Y') }} PinjamOTO - All rights reserved.</p>
    </footer>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
