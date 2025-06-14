
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="{{ asset('img/logo-white.png') }}">
        <title>Selamat Datang</title>
        <!-- Bootstrap 5 CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-...hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Sweetalert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            body {
                background-image: url("{{ asset('img/login-bg.png') }}");
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
                color: #333;
                border-radius: 5px;
                height: 45px;
            }

            .form-control::placeholder {
                color: rgba(255, 255, 255, 0.7);
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

            .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: url('/img/your-background.jpg') no-repeat center center/cover;
        }

        .login-box {
            background: rgba(82, 82, 82, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.8);
            color: white;
            width: 100%;
            max-width: 400px;
        }

        .login-box input.form-control {
            background-color: rgba(0, 0, 0, 0.1);
            border: none;
            color: white;
        }

        .login-box input.form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .login-box .btn-primary {
            background-color:rgb(188, 188, 188);
            border: none;
        }

                .bg-left {
            background: url('{{ asset('img/login-bg.png') }}') no-repeat center center;
            background-size: cover;
            height: 100vh;
        }
        .form-section {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
        }
        .form-wrapper {
            width: 100%;
            max-width: 340px;
            padding: 20px;
        }
        .form-wrapper img {
            width: 80px;
            display: block;
            margin: 0 auto 16px auto;
        }
        .form-wrapper h3 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        b {
            color: #cc5200;
            transition: color 0.3s ease;
        }

        b:hover {
            color:rgb(234, 148, 91);
            transition: color 0.3s ease;
        }

        .btn-daftar {
            transition: all 0.3s ease;
        }

        .btn-daftar:hover {
            background-color: transparent;
            color: #dc3545;
            border: 1px solid #dc3545;
        }
    </style>
</head>
<body>
    
@yield('content')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
