<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            margin-top: 5%;
        }
        .navbar-brand {
            margin-left: 5%;
            font-family: 'Montserrat', sans-serif;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            font-family: 'Montserrat', sans-serif;
            font-weight: bold;
            color: white;
            position: relative;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0px;
            left: 0;
            width: 0;
            height: 3px;
            background-color: white;
            transition: width 0.3s ease;
        }
        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }
        .navbar-nav .nav-link:hover {
            color: #fff;
        }
        .navbar-nav .active::after {
            width: 100%;
        }
        .navbar-custom {
            background-color:#0f2b5a;
        }
        form {
            margin-bottom: 10%;
        }
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 50px);
            flex-direction: column;
            text-align: center;
            margin-top: 60px;
        }
    </style>
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <a class="navbar-brand" href="#">PinjamOto</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="">Daftar Mobil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Customer</a>
                </li>
                <li>
                    <a class="nav-link" href="">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        @yield('content')
    </div>


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
