<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | Raracookies Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.icon') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #D4A574;        /* Warm beige - warna cookies */
            --primary-light: #F2C185;  /* Karamel */
            --primary-dark: #B88659;   /* Cokelat lebih tua */
            --bg-gradient-start: #FFF9F0; /* Krem adonan */
            --bg-gradient-end: #FFECD9;   /* Krem hangat */
            --card-bg: #FFFFFF;
            --input-bg: #FFFDF9;
            --input-border: #F0E6D9;
            --text-dark: #5C4B3F;
            --text-light: #8B7B6A;
            --error-bg: #FFF5F0;
            --error-border: #FF6B35;
            --shadow: 0 10px 25px rgba(212, 165, 116, 0.18);
            --radius: 20px;
        }

        body {
            background: linear-gradient(135deg, var(--bg-gradient-start), var(--bg-gradient-end));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
            color: var(--text-dark);
            background-image:
                radial-gradient(circle at 10% 20%, rgba(242, 193, 133, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(212, 165, 116, 0.04) 0%, transparent 25%);
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-box {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 52px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(242, 193, 133, 0.25);
        }

        /* Accent: cookie crumb effect */
        .login-box::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: var(--primary);
            opacity: 0.08;
            clip-path: polygon(100% 0, 100% 100%, 0 100%);
            z-index: 0;
        }

        .login-box > * {
            position: relative;
            z-index: 1;
        }

        .logo img {
            height: 72px;
            border-radius: 12px;
            background: rgba(255, 252, 247, 0.9);
            padding: 8px;
            box-shadow: 0 4px 10px rgba(92, 75, 63, 0.08);
            border: 2px solid rgba(212, 165, 116, 0.2);
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.03);
        }

        h1 {
            font-weight: 700;
            font-size: 1.9rem;
            color: var(--primary-dark);
            margin: 18px 0 10px;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: var(--text-light);
            font-size: 1.05rem;
            margin-bottom: 36px;
            line-height: 1.5;
        }

        .form-group {
            text-align: left;
            margin-bottom: 26px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.25rem;
        }

        input {
            width: 100%;
            padding: 16px 16px 16px 52px;
            border: 2px solid var(--input-border);
            border-radius: var(--radius);
            font-size: 1rem;
            outline: none;
            font-family: 'Poppins', sans-serif;
            background: var(--input-bg);
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.25);
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            font-size: 1.3rem;
        }

        .btn-login {
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            width: 100%;
            padding: 16px;
            border-radius: var(--radius);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(212, 165, 116, 0.3);
            font-family: 'Poppins', sans-serif;
        }

        .btn-login:hover {
            background: linear-gradient(90deg, var(--primary-dark), var(--primary));
            transform: translateY(-3px);
            box-shadow: 0 6px 22px rgba(212, 165, 116, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            background: var(--error-bg);
            color: #c25a3a;
            padding: 14px 18px;
            border-radius: var(--radius);
            margin-bottom: 26px;
            font-size: 0.95rem;
            border-left: 4px solid var(--error-border);
            text-align: left;
            animation: slideIn 0.4s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .footer {
            margin-top: 32px;
            color: var(--text-light);
            font-size: 0.85rem;
        }

        /* Subtle cookie crumb dots in background */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle, var(--primary) 1px, transparent 1px);
            background-size: 60px 60px;
            opacity: 0.03;
            pointer-events: none;
            z-index: -1;
        }

        @media (max-width: 480px) {
            .login-box {
                padding: 42px 24px;
            }
            h1 {
                font-size: 1.7rem;
            }
            input {
                padding: 15px 15px 15px 48px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-box">
            <div class="logo">
                <img src="{{ asset('backend/assets/images/logo.jpeg') }}" alt="Raracookies">
            </div>
            <h1>Raracookies Admin</h1>
            <p class="subtitle">Masuk untuk kelola pesanan, stok, dan laporan harian.</p>

            @if ($errors->any())
                <div class="alert">
                    <ul style="list-style: none; padding-left: 0; margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert">• {{ Session::get('error') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login_submit') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="mdi mdi-email-outline"></i>
                        <input type="email" id="email" name="email" placeholder="admin@raracookies.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="mdi mdi-lock-outline"></i>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <button type="button" class="toggle-password" id="togglePass">
                            <i class="mdi mdi-eye-outline"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login">Masuk ke Dashboard</button>
            </form>

            <div class="footer">
                &copy; <script>document.write(new Date().getFullYear())</script> Raracookies — Admin Panel
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('togglePass');
            const pass = document.getElementById('password');
            if (toggle && pass) {
                toggle.addEventListener('click', () => {
                    const isPassword = pass.type === 'password';
                    pass.type = isPassword ? 'text' : 'password';
                    toggle.innerHTML = isPassword
                        ? '<i class="mdi mdi-eye-off-outline"></i>'
                        : '<i class="mdi mdi-eye-outline"></i>';
                });
            }
        });
    </script>

</body>
</html>
