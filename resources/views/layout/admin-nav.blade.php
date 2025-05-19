<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
    }

    .wrapper {
      display: flex;
    }

    .sidebar {
      width: 220px;
      height: 100vh;
      background-color: #0f2b5a;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 60px;
    }

    .sidebar a {
      color: white;
      padding: 15px;
      display: block;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background-color: #1a3a72;
    }

    .content {
      margin-left: 220px;
      padding: 60px 20px 20px 20px;
    }

    .navbar-custom {
      background-color: #0f2b5a;
    }

    .navbar {
      position: fixed;
      top: 0;
      left: 220px;
      right: 0;
      width: calc(100% - 220px);
      z-index: 1000;
    }

    .navbar-brand {
      font-weight: bold;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <a href="#">Daftar Mobil</a>
    <a href="#">Transaksi</a>
    <a href="#">Customer</a>
    <a href="#">Logout</a>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <a class="navbar-brand ml-3" href="#">PinjamOto</a>
  </nav>

  <!-- Main Content -->
  <div class="content">
    <div class="container-fluid">
      @yield('content')
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
