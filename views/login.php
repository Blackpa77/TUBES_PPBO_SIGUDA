<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIGUDA PPBO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #081428, #0d47a1);
            font-family: 'Poppins', sans-serif;
        }

        .left-col {
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(10px);
            padding: 60px 50px;
        }

        /* RIGHT BACKGROUND */
        .right-col {
            background: url('https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=1600') center/cover;
            position: relative;
        }

        .right-overlay {
            background: rgba(0, 0, 40, 0.68);
            position: absolute;
            width: 100%;
            height: 100%;
        }

        /* SIGUDA BOX */
        .siguda-box {
            z-index: 20;
            text-align: center;
            padding: 45px 35px;
            width: 360px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 10px 40px rgba(0,0,0,0.45);
            animation: fadeIn 0.7s ease;
        }

        .siguda-box i {
            font-size: 70px;
            color: #bbdefb;
        }

        .siguda-box h1 {
            margin-top: 10px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
        }

        .siguda-box p {
            margin-top: -5px;
            color: #e0e0e0;
        }

        /* FORM INPUT KECIL */
        .form-control {
            height: 42px;
            font-size: 14px;
            border-radius: 8px;
        }

        .input-group-text {
            padding: 6px 12px;
        }

        /* BUTTON */
        .btn-login {
            padding: 10px;
            border-radius: 10px;
            font-weight: 600;
            background: linear-gradient(135deg, #0d47a1, #1565c0);
            color: #fff;
        }

        .btn-login:hover {
            transform: scale(1.02);
            opacity: .92;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

<div class="container-fluid h-100">
    <div class="row h-100">

        <!-- LEFT FORM -->
        <div class="col-md-6 left-col d-flex align-items-center">
            <div class="w-100">

                <h2 class="text-white fw-bold mb-4">Masuk ke Sistem Gudang</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger py-2 text-center">
                        <i class="bi bi-exclamation-circle-fill"></i> <?= $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <label class="form-label text-white">Username</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" name="username" placeholder="Masukan username" required>
                    </div>

                    <label class="form-label text-white">Password</label>
                    <div class="input-group mb-4">
                        <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Masukan password" required>
                    </div>

                    <button type="submit" class="btn btn-login w-100">MASUK SISTEM</button>
                </form>

                <small class="text-light d-block mt-3">Gunakan akun: <b>admin</b> / <b>admin123</b></small>

            </div>
        </div>

        <!-- RIGHT SIGUDA BRAND BOX -->
        <div class="col-md-6 right-col d-flex justify-content-center align-items-center">
            <div class="right-overlay"></div>

            <div class="siguda-box">
                <i class="bi bi-box-seam-fill"></i>
                <h1>SIGUDA</h1>
                <p>Sistem Gudang Fashion</p>
            </div>
        </div>

    </div>
</div>

</body>
</html>
