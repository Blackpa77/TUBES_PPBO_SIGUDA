<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIGUDA PPBO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Custom Style -->
    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #4f8df5, #61dafb);
            font-family: 'Poppins', sans-serif;
        }

        .login-card {
            width: 380px;
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            animation: fadeIn 0.9s ease;
        }

        .login-header {
            text-align: center;
            padding: 25px 20px 10px 20px;
        }

        .login-header i {
            font-size: 50px;
            color: #0d6efd;
        }

        .login-header h3 {
            margin-top: 10px;
            font-weight: 700;
            color: #0d6efd;
        }

        .login-header p {
            margin-top: -5px;
            color: #777;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            letter-spacing: .5px;
            background: linear-gradient(135deg, #0066ff, #559bff);
            border: none;
            transition: 0.2s;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: scale(1.01);
        }

        .card-footer {
            background: transparent;
            border: none;
            text-align: center;
            padding-bottom: 20px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <div class="login-card p-3">
        <div class="login-header">
            <i class="bi bi-box-seam-fill"></i>
            <h3>SIGUDA</h3>
            <p>Sistem Gudang Fashion</p>
        </div>

        <div class="card-body px-4">

            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center py-2" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> <?= $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <label class="form-label">Username</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" name="username"
                        placeholder="Masukan username" required autofocus>
                </div>

                <label class="form-label">Password</label>
                <div class="input-group mb-4">
                    <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                    <input type="password" class="form-control" name="password"
                        placeholder="Masukan password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">MASUK SISTEM</button>

            </form>
        </div>

        <div class="card-footer">
            <small class="text-muted">Gunakan akun: <b>admin</b> / <b>admin123</b></small>
        </div>
    </div>

</body>
</html>
