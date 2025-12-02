<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIGUDA PPBO</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #0a1930, #0d47a1);
            font-family: 'Poppins', sans-serif;
        }

        .left-section {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
            padding: 60px 50px;
            height: 100vh;
        }

        .login-title {
            color: #fff;
            font-weight: 700;
            margin-bottom: 25px;
            animation: fadeInDown 0.7s ease;
        }

        label {
            color: #e0e0e0;
        }

        .input-group-text {
            background: #eef3ff;
        }

        .btn-login {
            background: linear-gradient(135deg, #1565c0, #1e88e5);
            border: none;
            padding: 11px;
            font-weight: bold;
            border-radius: 8px;
        }

        .btn-login:hover {
            opacity: .9;
        }

        /* RIGHT Branding */
        .right-section {
            position: relative;
            background: url('https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=1600')
                center/cover;
            height: 100vh;
        }

        .overlay {
            background: rgba(0, 10, 35, 0.7);
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .branding-box {
            position: absolute;
            text-align: center;
            top: 50%;
            right: 15%;
            transform: translateY(-50%);
            color: white;
            padding: 40px 35px;
            width: 330px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            backdrop-filter: blur(12px);
            animation: fadeInUp 0.8s ease;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .branding-box i {
            font-size: 85px;
            color: #90caf9;
        }

        .branding-box h1 {
            font-weight: 700;
            margin-top: 10px;
        }

        .branding-box p {
            font-size: 15px;
            color: #d0d0d0;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

<div class="container-fluid h-100">
    <div class="row h-100">

        <!-- LEFT: LOGIN FORM -->
        <div class="col-md-6 left-section d-flex align-items-center">
            <div class="w-100">

                <h2 class="login-title">Masuk ke Sistem Gudang</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger text-center py-2">
                        <i class="bi bi-exclamation-circle-fill"></i> <?= $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <label class="form-label">Username</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" class="form-control"
                               placeholder="Masukan username" required>
                    </div>

                    <label class="form-label">Password</label>
                    <div class="input-group mb-4">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" name="password" class="form-control"
                               placeholder="Masukan password" required>
                    </div>

                    <button class="btn btn-login w-100">MASUK SISTEM</button>
                </form>

                <small class="text-light d-block mt-3">
                    Gunakan akun: <b>admin</b> / <b>admin123</b>
                </small>

            </div>
        </div>

        <!-- RIGHT: SIGUDA BOX -->
        <div class="col-md-6 right-section">
            <div class="overlay"></div>

            <div class="branding-box">
                <i class="bi bi-box-seam-fill"></i>
                <h1>SIGUDA</h1>
                <p>Sistem Gudang Fashion</p>
            </div>
        </div>

    </div>
</div>

</body>
</html>
