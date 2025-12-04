<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIGUDA PPBO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: linear-gradient(120deg,#1e3c72,#2a5298,#00c3ff);
            position: relative;
        }

        /* Light Flare Floating */
        .flare {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: radial-gradient(circle,rgba(255,255,255,0.25),transparent 70%);
            animation: flareMove 11s infinite alternate ease-in-out;
            filter: blur(25px);
        }

        @keyframes flareMove {
            from { transform: translate(-100px,-80px) scale(1); }
            to { transform: translate(120px,110px) scale(1.3); }
        }

        /* Mini Stars */
        .light-dot {
            position: absolute;
            background: white;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            opacity: 0.8;
            animation: blink 2s infinite alternate;
        }

        @keyframes blink { 50% { opacity: .2; } }

        .login-card {
            width: 410px;
            padding: 30px 32px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.40);
            position: relative;
            overflow: hidden;
            animation: floatCard 2.3s ease infinite alternate;
            box-shadow: 0 0 25px rgba(255,255,255,.25);
        }

        @keyframes floatCard {
            0% { transform: translateY(0); }
            100% { transform: translateY(-7px); }
        }

        /* Animated Border Glow */
        .login-card::before {
            content: "";
            position: absolute;
            inset: -2px;
            border-radius: 18px;
            padding: 2px;
            background: linear-gradient(140deg,#00eaff,#007bff,#00ffd0,#0077ff);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
                    mask-composite: exclude;
            animation: borderGlow 3.5s linear infinite;
        }

        @keyframes borderGlow { 
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(360deg); }
        }

        .login-header {
            text-align: center;
            color: #fff;
        }

        .login-header i {
            font-size: 60px;
            color: #ffffff;
            text-shadow: 0 0 18px rgba(255,255,255,.8);
            animation: headPop .8s ease;
        }

        @keyframes headPop {
            from { transform: scale(.6); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }

        .login-header h3 {
            margin-top: 12px;
            font-weight: 800;
            font-size: 28px;
            letter-spacing: 1px;
            color: #ffffff;
        }

        .form-control {
            border-radius: 12px;
            border: none;
            padding: 10px;
            transition: 0.25s;
        }
        .form-control:focus {
            transform: scale(1.03);
            box-shadow: 0 0 14px #9cd5ff;
        }

        /* Show/Hide Pass Icon */
        .toggle-pass {
            cursor: pointer;
            user-select: none;
        }

        /* Ripple Button */
        .btn-primary {
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            font-size: 15px;
            background: linear-gradient(135deg,#0090ff,#00eaff);
            border: none;
            overflow: hidden;
            position: relative;
        }

        .btn-primary::after {
            content:"";
            position:absolute;
            width:0;height:0;
            background:rgba(255,255,255,.7);
            border-radius:50%;
            transform:translate(-50%,-50%);
            top:var(--y);
            left:var(--x);
            opacity:.6;
            transition:.5s;
        }
        .btn-primary:hover::after { width:190px;height:190px; }
        .btn-primary:hover {
            box-shadow: 0 0 22px #00d5ff;
            letter-spacing: .5px;
        }

        .card-footer small { color: white;font-size: 13px; }
    </style>
</head>

<body>

    <div class="flare"></div>

    <script>
        // Particles blinking random stars
        for(let i=0;i<30;i++){
            let star=document.createElement("div");
            star.className="light-dot";
            star.style.left=Math.random()*100+"%";
            star.style.top=Math.random()*100+"%";
            star.style.animationDuration=(1+Math.random()*2)+"s";
            document.body.appendChild(star);
        }
    </script>

    <div class="login-card">

        <div class="login-header">
            <i class="bi bi-box-seam-fill"></i>
            <h3>SIGUDA</h3>
            <p class="text-light">Sistem Gudang Fashion</p>
        </div>

        <div class="card-body mt-3">

            <form method="POST">

                <label class="form-label text-white">Username</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" class="form-control" name="username" placeholder="Masukan username" required>
                </div>

                <label class="form-label text-white">Password</label>
                <div class="input-group mb-4">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-key"></i>
                    </span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password" required>
                    <span class="input-group-text toggle-pass bg-light" onclick="togglePass()">
                        <i class="bi bi-eye-fill" id="icon-pass"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-primary w-100"
                    onmousemove="btnRipple(event,this)">
                    MASUK SISTEM
                </button>

            </form>
        </div>

        <div class="card-footer text-center mt-3">
            <small>Gunakan akun: <b>admin</b> / <b>admin123</b></small>
        </div>
    </div>

    <!-- JS: Toggle Password + Ripple -->
    <script>
        function togglePass(){
            let pass = document.getElementById("password");
            let icon = document.getElementById("icon-pass");
            if(pass.type === "password"){
                pass.type = "text";
                icon.className="bi bi-eye-slash-fill";
            } else {
                pass.type="password";
                icon.className="bi bi-eye-fill";
            }
        }

        function btnRipple(e,btn){
            let rect = btn.getBoundingClientRect();
            btn.style.setProperty("--x",(e.clientX-rect.left)+"px");
            btn.style.setProperty("--y",(e.clientY-rect.top)+"px");
        }
    </script>

</body>
</html>
