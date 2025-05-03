
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1621808752171-531c30903889?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(3px);
            border: none;
            color: #fff;
            border-radius: 5px;
            height: 45px;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            box-shadow: none;
            border: none;
        }

        h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .form-check-label, .forgot-password {
            color: white;
        }

        .login-box img {
            display: block;
            margin: 0 auto 20px;
            max-width: 70%;
            height: auto;
        }

        .btn-primary {
            background-color: #fff;
            color: #1C3D5A;
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #1C3D5A;
            color: #fff;
            border: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
@yield('content')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
