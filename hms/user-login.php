<?php 
session_start();
error_reporting(0);
include("include/config.php");

if(isset($_POST['submit']))
{
    $puname = mysqli_real_escape_string($con, $_POST['username']);	
    $ppwd = md5($_POST['password']);
    
    $ret = mysqli_query($con, "SELECT * FROM users WHERE email='$puname' and password='$ppwd'");
    $num = mysqli_fetch_array($ret);
    
    if($num > 0)
    {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $pid = $num['id'];
        $host = $_SERVER['HTTP_HOST'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        
        // For storing log if user login successful
        $log = mysqli_query($con, "INSERT INTO userlog(uid,username,userip,status) VALUES('$pid','$puname','$uip','$status')");
        header("location:dashboard.php");
    }
    else
    {
        // For storing log if user login unsuccessful
        $_SESSION['login'] = $_POST['username'];	
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 0;
        mysqli_query($con, "INSERT INTO userlog(username,userip,status) VALUES('$puname','$uip','$status')");
        
        $_SESSION['errmsg'] = "Email atau Password salah!";
        echo "<script>window.location.href='user-login.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Warga Binaan | Lapas Lubuk Linggau</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    
    <style>
        :root {
            --primary-navy: #1a3a52;
            --secondary-navy: #2c5f7f;
            --accent-blue: #4a90c0;
            --light-blue: #e8f1f8;
            --dark-navy: #0f2537;
            --gold-accent: #d4af37;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--dark-navy) 0%, var(--primary-navy) 50%, var(--secondary-navy) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(74, 144, 192, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            top: -200px;
            left: -100px;
            animation: float 20s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -150px;
            right: -100px;
            animation: float 15s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(50px, -50px) rotate(120deg); }
            66% { transform: translate(-30px, 30px) rotate(240deg); }
        }

        .login-container {
            width: 100%;
            max-width: 480px;
            padding: 20px;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.3),
                0 0 100px rgba(74, 144, 192, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--secondary-navy) 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .logo-container img {
            height: 60px;
            width: auto;
            filter: brightness(0) invert(1);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .login-header h1 {
            color: #ffffff;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            margin: 10px 0 0 0;
            position: relative;
            z-index: 2;
        }

        .login-body {
            padding: 40px 35px;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-text h2 {
            color: var(--primary-navy);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .welcome-text p {
            color: #666;
            font-size: 0.9rem;
        }

        .alert {
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            border: none;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .alert-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: var(--primary-navy);
            font-weight: 500;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-blue);
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 14px 20px 14px 50px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-blue);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(74, 144, 192, 0.1);
        }

        .form-control:focus + i {
            color: var(--primary-navy);
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            padding: 5px;
        }

        .password-toggle:hover {
            color: var(--accent-blue);
        }

        .forgot-link {
            display: block;
            text-align: right;
            margin-top: 10px;
            color: var(--accent-blue);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--primary-navy);
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 14px 30px;
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--accent-blue) 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26, 58, 82, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 58, 82, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 30px 0;
            color: #999;
            font-size: 0.85rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }

        .divider span {
            padding: 0 15px;
        }

        .register-link {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }

        .register-link a {
            color: var(--accent-blue);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: var(--primary-navy);
            text-decoration: underline;
        }

        .back-home {
            text-align: center;
            margin-top: 25px;
        }

        .back-home a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .back-home a:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .footer-text {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            margin-top: 20px;
        }

        /* Loading Animation */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-login.loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-container {
                padding: 15px;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-header h1 {
                font-size: 1.4rem;
            }

            .login-body {
                padding: 30px 25px;
            }

            .logo-container img {
                height: 50px;
            }

            .welcome-text h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="logo-container">
                    <img src="../assets/images/pemasyarakatann.png" alt="Logo Pemasyarakatan">
                    <img src="../assets/images/imipas.png" alt="Logo IMIPAS">
                </div>
                <h1>Portal Warga Binaan</h1>
                <p>Lembaga Pemasyarakatan Kelas IIA Lubuk Linggau</p>
            </div>

            <!-- Body -->
            <div class="login-body">
                <div class="welcome-text">
                    <h2>Selamat Datang Kembali!</h2>
                    <p>Silakan masuk ke akun Anda</p>
                </div>

                <?php if(isset($_SESSION['errmsg']) && $_SESSION['errmsg'] != ''): ?>
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION['errmsg']; ?>
                </div>
                <?php $_SESSION['errmsg'] = ''; endif; ?>

                <form method="POST" action="" id="loginForm">
                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email"
                                name="username" 
                                placeholder="contoh@email.com" 
                                required
                                autocomplete="email">
                            <i class="fa fa-envelope"></i>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password"
                                name="password" 
                                placeholder="Masukkan password Anda" 
                                required
                                autocomplete="current-password">
                            <i class="fa fa-lock"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fa fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <a href="forgot-password.php" class="forgot-link">Lupa Password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="submit" class="btn-login" id="loginBtn">
                        <span>Masuk</span>
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider">
                    <span>atau</span>
                </div>

                <!-- Register Link -->
                <div class="register-link">
                    Belum punya akun? <a href="registration.php">Daftar Sekarang</a>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="back-home">
            <a href="../index.php">
                <i class="fa fa-home"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Footer Text -->
        <div class="footer-text">
            &copy; <?php echo date('Y'); ?> Lapas Kelas IIA Lubuk Linggau. All rights reserved.
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    
    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Form Loading Animation
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.querySelector('span').textContent = 'Memproses...';
        });

        // Auto hide alert after 5 seconds
        setTimeout(function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>