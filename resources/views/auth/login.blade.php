<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - eLogbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .background-blur {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/bglogin.jpeg');
            background-size: cover;
            background-position: center;
            filter: blur(2px);
            z-index: -1;
        }
        .login-container{
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            position: relative;
            z-index: 1;
        }
        .login-header{
            text-align: center;
            margin-bottom: 25px;
        }
        .logo-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #0053a0;
            margin: 0 auto 15px auto;
            display: block;
            box-shadow: 0 4px 15px rgba(0, 83, 160, 0.3);
        }
        .brand-title {
            color: #0053a0;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .sub-brand {
            color: #0077c8;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="background-blur"></div>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <img src="/images/logo.jpg" alt="Airnav Logo" class="logo-circle">
                <h2>E-Logbook</h2>
                <h2>Airnav Banjarmasin</h2>
                <p class="text-muted">Silahkan masuk ke akun Anda</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf 
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required minlength="8" maxlength="8" title="Password harus tepat 8 karakter">
                    <div class="form-text"> Password harus tepat 8 karakter</div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</body>
</html>