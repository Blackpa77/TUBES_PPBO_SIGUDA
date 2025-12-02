<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIGUDA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2d5a4d 0%, #1a3a30 100%);
            overflow: hidden;
        }

        .login-container {
            display: flex;
            width: 90%;
            max-width: 1100px;
            height: 600px;
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        /* Left Side - Illustration */
        .left-side {
            flex: 1;
            background: linear-gradient(135deg, #e8f5f0 0%, #d4e9e2 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-section img {
            width: 50px;
            height: 50px;
        }

        .logo-text {
            font-size: 14px;
            color: #2d5a4d;
            line-height: 1.3;
        }

        .logo-text .name {
            font-weight: 600;
            display: block;
        }

        .illustration-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .illustration {
            width: 100%;
            max-width: 400px;
            position: relative;
        }

        /* Simple illustration using CSS */
        .tree-scene {
            width: 300px;
            height: 300px;
            position: relative;
            margin: 0 auto;
        }

        .ground {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 350px;
            height: 200px;
            background: rgba(180, 220, 200, 0.4);
            border-radius: 50%;
        }

        .tree {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
        }

        .tree-trunk {
            width: 30px;
            height: 80px;
            background: #5a4a3a;
            margin: 0 auto;
            border-radius: 5px;
        }

        .tree-foliage {
            width: 150px;
            height: 150px;
            background: #2d5a4d;
            border-radius: 50%;
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .decorations {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .ornament {
            width: 12px;
            height: 12px;
            background: #ff6b6b;
            border-radius: 50%;
            position: absolute;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .ornament:nth-child(1) { top: 30%; left: 35%; background: #ffd93d; }
        .ornament:nth-child(2) { top: 45%; right: 30%; background: #ff6b6b; }
        .ornament:nth-child(3) { top: 60%; left: 40%; background: #6bcf7f; }
        .ornament:nth-child(4) { top: 50%; left: 25%; background: #4ecdc4; }
        .ornament:nth-child(5) { top: 70%; right: 35%; background: #ffd93d; }

        .characters {
            position: absolute;
            bottom: 20px;
            left: 20%;
            display: flex;
            gap: 20px;
        }

        .character {
            width: 40px;
            height: 60px;
            background: #2d5a4d;
            border-radius: 20px 20px 10px 10px;
            position: relative;
        }

        .character-head {
            width: 25px;
            height: 25px;
            background: #f4c2a5;
            border-radius: 50%;
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .bubble {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            position: absolute;
            animation: float 6s ease-in-out infinite;
        }

        .bubble:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .bubble:nth-child(2) { top: 20%; right: 15%; width: 40px; height: 40px; animation-delay: 2s; }
        .bubble:nth-child(3) { bottom: 30%; left: 20%; width: 50px; height: 50px; animation-delay: 4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .footer-info {
            text-align: center;
            color: #6b7280;
            font-size: 11px;
        }

        /* Right Side - Login Form */
        .right-side {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h1 {
            font-size: 32px;
            color: #1a3a30;
            margin-bottom: 8px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f9fafb;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2d5a4d;
            background: white;
            box-shadow: 0 0 0 3px rgba(45, 90, 77, 0.1);
        }

        .forgot-password {
            text-align: right;
            margin-top: -15px;
            margin-bottom: 25px;
        }

        .forgot-password a {
            color: #2d5a4d;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            color: #1a3a30;
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #2d5a4d 0%, #1a3a30 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(45, 90, 77, 0.3);
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45, 90, 77, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #6b7280;
            font-size: 14px;
        }

        .register-link a {
            color: #2d5a4d;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #1a3a30;
            text-decoration: underline;
        }

        .terms-links {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .terms-links a {
            color: #2d5a4d;
            text-decoration: none;
            font-size: 12px;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .terms-links a:hover {
            color: #1a3a30;
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                width: 95%;
            }

            .left-side {
                display: none;
            }

            .right-side {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Illustration -->
        <div class="left-side">
            <div class="logo-section">
                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="25" cy="25" r="25" fill="#2d5a4d"/>
                    <path d="M25 10L35 20H30V35H20V20H15L25 10Z" fill="white"/>
                </svg>
                <div class="logo-text">
                    <span class="name">UNIVERSITAS<br>KRISTEN<br>MARANATHA</span>
                </div>
            </div>

            <div class="illustration-container">
                <div class="floating-elements">
                    <div class="bubble"></div>
                    <div class="bubble"></div>
                    <div class="bubble"></div>
                </div>
                
                <div class="tree-scene">
                    <div class="ground"></div>
                    <div class="tree">
                        <div class="tree-foliage">
                            <div class="decorations">
                                <div class="ornament"></div>
                                <div class="ornament"></div>
                                <div class="ornament"></div>
                                <div class="ornament"></div>
                                <div class="ornament"></div>
                            </div>
                        </div>
                        <div class="tree-trunk"></div>
                    </div>
                    <div class="characters">
                        <div class="character">
                            <div class="character-head"></div>
                        </div>
                        <div class="character">
                            <div class="character-head"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-info">
                © 2025 Universitas Kristen Maranatha<br>
                Powered by KM
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="right-side">
            <div class="login-header">
                <h1>Login</h1>
            </div>

            <!-- Error Alert -->
            <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Enter your username"
                            required 
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter your password"
                            required
                        >
                    </div>
                </div>

                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" class="login-button">
                    Login to System
                </button>

                <div class="register-link">
                    Gunakan akun: <strong>admin</strong> / <strong>admin123</strong>
                </div>

                <div class="terms-links">
                    <a href="#">Terms and Services</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
