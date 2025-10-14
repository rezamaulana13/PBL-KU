<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Client Login | Raracookies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.icon') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Bootstrap & Toastr -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f5f9ff, #e6f2ff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }

        .auth-container {
            display: flex;
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 40, 100, 0.12);
        }

        .auth-brand {
            background: #2c7be5;
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .auth-brand img {
            height: 60px;
            margin-bottom: 24px;
            border-radius: 10px;
            background: rgba(255,255,255,0.15);
            padding: 6px;
        }

        .auth-brand h2 {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 12px;
        }

        .auth-brand p {
            opacity: 0.9;
            line-height: 1.6;
        }

        .auth-forms {
            width: 100%;
            padding: 50px 40px;
        }

        .form-title {
            font-size: 1.7rem;
            color: #2c3e50;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .form-subtitle {
            color: #7b8794;
            margin-bottom: 32px;
        }

        .input-group {
            position: relative;
            margin-bottom: 22px;
        }

        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #2c7be5;
            font-size: 1.2rem;
        }

        .form-control {
            width: 100%;
            padding: 15px 15px 15px 50px;
            border: 2px solid #eef2f7;
            border-radius: 14px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            border-color: #2c7be5;
            box-shadow: 0 0 0 3px rgba(44, 123, 229, 0.15);
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #2c7be5;
            cursor: pointer;
            font-size: 1.3rem;
        }

        .btn-auth {
            background: #2c7be5;
            color: white;
            border: none;
            width: 100%;
            padding: 14px;
            border-radius: 14px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.3s;
        }

        .btn-auth:hover {
            background: #1a68d1;
        }

        .divider {
            text-align: center;
            margin: 24px 0;
            position: relative;
            color: #adb5bd;
            font-size: 0.9rem;
        }

        .divider::before,
        .divider::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #e9ecef;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .switch-form {
            text-align: center;
            margin-top: 24px;
            color: #6c757d;
        }

        .switch-form a {
            color: #2c7be5;
            text-decoration: none;
            font-weight: 600;
            margin-left: 6px;
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            color: #888;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }
            .auth-brand {
                padding: 30px;
            }
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <!-- Brand Side -->
        <div class="auth-brand">
    <div class="brand-logo mb-4">
        <!-- Ganti dengan logo PNG transparan berkualitas -->
        <img src="{{ asset('backend/assets/images/logo.jpeg') }}"
             alt="Raracookies"
             onerror="this.style.display='none'; document.getElementById('fallback-logo').style.display='block';"
             style="height: 72px; max-width: 100%; object-fit: contain;">
        <div id="fallback-logo" style="display:none; text-align:center;">
            <div style="
                font-family: 'Poppins', sans-serif;
                font-weight: 800;
                font-size: 2.1rem;
                background: linear-gradient(90deg, #74c6d4, #35ffd3);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                letter-spacing: -0.5px;
            ">
                Rara<span style="color:#3f5c55;">cookies</span>
            </div>
        </div>
    </div>
    <h2 class="brand-title">Welcome to Raracookies</h2>
    <p class="brand-desc">Tempat terbaik untuk memesan cookies premium dengan rasa yang menghangatkan hati.</p>
</div>

<style>
.auth-brand {
    background: linear-gradient(135deg, #e3f8ff, #39acf8);
    color: #5C4B3F;
    padding: 50px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    border-right: 1px solid rgba(52, 113, 124, 0.2);
}
.brand-title {
    font-weight: 700;
    font-size: 1.8rem;
    margin: 16px 0 12px;
    color: #4950af;
}
.brand-desc {
    opacity: 0.9;
    line-height: 1.6;
    font-size: 1.02rem;
    max-width: 320px;
    margin: 0 auto;
}
</style>

        <!-- Form Side -->
        <div class="auth-forms">
            <!-- Login Form (Default) -->
            <div id="loginForm">
                <h2 class="form-title">Sign In</h2>
                <p class="form-subtitle">Masuk untuk mengelola pesanan Anda</p>

                <form method="POST" action="{{ route('client.login_submit') }}">
                    @csrf
                    <div class="input-group">
                        <i class="mdi mdi-email-outline"></i>
                        <input type="email" name="email" class="form-control" placeholder="Email Anda" required>
                    </div>
                    <div class="input-group">
                        <i class="mdi mdi-lock-outline"></i>
                        <input type="password" id="loginPass" name="password" class="form-control" placeholder="Password" required>
                        <button type="button" class="toggle-password" onclick="togglePass('loginPass')">
                            <i class="mdi mdi-eye-outline"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn-auth">Masuk</button>
                </form>

                <div class="switch-form">
                    Belum punya akun? <a href="#" onclick="showForm('register')">Daftar Sekarang</a>
                </div>
            </div>

            <!-- Register Form (Hidden by default) -->
            <div id="registerForm" style="display:none;">
                <h2 class="form-title">Create Account</h2>
                <p class="form-subtitle">Daftar gratis dalam 30 detik</p>

                <form method="POST" action="{{ route('client.register') }}">
                    @csrf
                    <div class="input-group">
                        <i class="mdi mdi-account-outline"></i>
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="input-group">
                        <i class="mdi mdi-email-outline"></i>
                        <input type="email" name="email" class="form-control" placeholder="Email Anda" required>
                    </div>
                    <div class="input-group">
                        <i class="mdi mdi-lock-outline"></i>
                        <input type="password" id="regPass" name="password" class="form-control" placeholder="Password" required>
                        <button type="button" class="toggle-password" onclick="togglePass('regPass')">
                            <i class="mdi mdi-eye-outline"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn-auth">Daftar Akun</button>
                </form>

                <div class="switch-form">
                    Sudah punya akun? <a href="#" onclick="showForm('login')">Masuk di Sini</a>
                </div>
            </div>

            <div class="footer-text">
                &copy; <script>document.write(new Date().getFullYear())</script> Raracookies — Client Portal
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        function togglePass(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'mdi mdi-eye-off-outline';
            } else {
                input.type = 'password';
                icon.className = 'mdi mdi-eye-outline';
            }
        }

        function showForm(type) {
            const login = document.getElementById('loginForm');
            const register = document.getElementById('registerForm');
            if (type === 'login') {
                login.style.display = 'block';
                register.style.display = 'none';
            } else {
                login.style.display = 'none';
                register.style.display = 'block';
            }
        }

        // Toastr setup
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}";
            var msg = "{{ Session::get('message') }}";
            toastr[type](msg);
        @endif
    </script>

</body>
</html>
