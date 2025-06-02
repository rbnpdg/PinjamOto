
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="{{ asset('img/logo-white.png') }}">
        <title>Selamat Datang</title>
        <!-- Bootstrap 5 CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Sweetalert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            .btn {
                background-color: #1c1c1c;
                color: #fff;
                border: none;
                font-weight: bold;
                transition: background-color 0.3s, color 0.3s;
            }

            .btn:hover {
                background-color: #fff;
                color: #1c1c1c;
                border: none;
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
    </style>
</head>
<body>
    
@yield('content')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
