<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | KOPI KITA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: #f5e6ca;
            color: #1f1f1f;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* =========================
           CONTAINER
        ========================= */

        .login-container {
            width: 100%;
            max-width: 1050px;
            min-height: 620px;
            background: white;
            border-radius: 28px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            box-shadow: 0 25px 70px rgba(92, 61, 46, 0.20);
        }

        /* =========================
           LEFT SIDE
        ========================= */

        .login-left {
            position: relative;
            overflow: hidden;
            padding: 55px;
            color: white;

            background:
                linear-gradient(
                    rgba(92, 61, 46, 0.94),
                    rgba(61, 40, 31, 0.98)
                );
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            top: -130px;
            right: -100px;
        }

        .circle-2 {
            width: 220px;
            height: 220px;
            top: -90px;
            right: -60px;
        }

        .circle-3 {
            width: 350px;
            height: 350px;
            bottom: -210px;
            left: -190px;
        }

        .left-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* =========================
           LOGO
        ========================= */

        .logo-box {
            width: 65px;
            height: 65px;
            background: #f5e6ca;
            color: #5c3d2e;
            border-radius: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 31px;
            margin-bottom: 25px;

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .brand-name {
            font-size: 40px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .brand-description {
            max-width: 390px;
            color: rgba(255, 255, 255, 0.75);
            font-size: 14px;
            line-height: 1.8;
        }

        /* =========================
           LEFT BOTTOM
        ========================= */

        .coffee-quote {
            max-width: 350px;
            font-size: 19px;
            font-weight: 600;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .copyright {
            color: rgba(255, 255, 255, 0.50);
            font-size: 11px;
        }

        /* =========================
           RIGHT SIDE
        ========================= */

        .login-right {
            padding: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .login-form {
            width: 100%;
            max-width: 390px;
        }

        .login-heading {
            margin-bottom: 32px;
        }

        .login-heading h2 {
            font-size: 30px;
            font-weight: 800;
            color: #1f1f1f;
            margin-bottom: 8px;
        }

        .login-heading p {
            color: #777;
            font-size: 13px;
            line-height: 1.7;
        }

        /* =========================
           ALERT
        ========================= */

        .alert {
            border-radius: 12px;
            padding: 13px 15px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.5;
        }

        .alert-error {
            background: #fff1f1;
            border: 1px solid #ffd5d5;
            color: #b42318;
        }

        .alert-success {
            background: #effaf3;
            border: 1px solid #ccebd7;
            color: #19743a;
        }

        .alert ul {
            margin: 6px 0 0 18px;
        }

        /* =========================
           FORM GROUP
        ========================= */

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;

            color: #333;
            font-size: 13px;
            font-weight: 600;
        }

        /* =========================
           INPUT
        ========================= */

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: #8b6f5a;
            font-size: 17px;

            pointer-events: none;
        }

        .form-input {
            width: 100%;
            height: 52px;

            border: 1px solid #ded8d3;
            border-radius: 12px;

            background: #fff;

            padding: 0 15px 0 45px;

            color: #1f1f1f;
            font-family: inherit;
            font-size: 14px;

            outline: none;

            transition: all 0.2s ease;
        }

        .form-input::placeholder {
            color: #aaa;
        }

        .form-input:focus {
            border-color: #5c3d2e;

            box-shadow:
                0 0 0 4px rgba(92, 61, 46, 0.08);
        }

        /* =========================
           PASSWORD
        ========================= */

        .password-input {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;

            transform: translateY(-50%);

            border: none;
            background: transparent;

            color: #8b6f5a;

            font-size: 17px;
            cursor: pointer;

            padding: 6px;
        }

        .password-toggle:hover {
            color: #5c3d2e;
        }

        /* =========================
           REMEMBER
        ========================= */

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 25px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;

            color: #666;
            font-size: 13px;

            cursor: pointer;
        }

        .remember input {
            width: 16px;
            height: 16px;

            accent-color: #5c3d2e;

            cursor: pointer;
        }

        /* =========================
           BUTTON
        ========================= */

        .login-button {
            width: 100%;
            height: 52px;

            border: none;
            border-radius: 12px;

            background: #5c3d2e;
            color: white;

            font-family: inherit;
            font-size: 14px;
            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 8px 20px rgba(92, 61, 46, 0.20);

            transition: all 0.2s ease;
        }

        .login-button:hover {
            background: #493025;

            transform: translateY(-1px);

            box-shadow:
                0 12px 25px rgba(92, 61, 46, 0.25);
        }

        .login-button:active {
            transform: translateY(0);
        }

        /* =========================
           DEVELOPMENT INFO
        ========================= */

        .dev-info {
            margin-top: 25px;

            padding: 14px 16px;

            border-radius: 12px;

            background: #f9f5ef;
            border: 1px solid #eee3d5;

            color: #6c5a4f;

            font-size: 12px;
            line-height: 1.6;
        }

        .dev-info strong {
            color: #5c3d2e;
        }

        /* =========================
           ERROR TEXT
        ========================= */

        .field-error {
            margin-top: 7px;

            color: #b42318;

            font-size: 12px;
        }

        /* =========================
           RESPONSIVE TABLET
        ========================= */

        @media (max-width: 850px) {

            body {
                padding: 15px;
            }

            .login-container {
                max-width: 560px;
                min-height: auto;

                grid-template-columns: 1fr;
            }

            .login-left {
                min-height: 280px;
                padding: 35px;
            }

            .brand-name {
                font-size: 32px;
            }

            .brand-description {
                max-width: 450px;
            }

            .coffee-quote {
                display: none;
            }

            .login-right {
                padding: 40px 35px;
            }
        }

        /* =========================
           RESPONSIVE MOBILE
        ========================= */

        @media (max-width: 480px) {

            body {
                padding: 10px;
            }

            .login-container {
                border-radius: 20px;
            }

            .login-left {
                min-height: 220px;
                padding: 28px 24px;
            }

            .logo-box {
                width: 52px;
                height: 52px;

                border-radius: 15px;

                font-size: 25px;

                margin-bottom: 17px;
            }

            .brand-name {
                font-size: 27px;
            }

            .brand-description {
                font-size: 12px;
                line-height: 1.6;
            }

            .login-right {
                padding: 30px 22px;
            }

            .login-heading h2 {
                font-size: 25px;
            }

            .login-heading p {
                font-size: 12px;
            }

            .form-input,
            .login-button {
                height: 50px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    {{-- =========================================================
         LEFT SIDE
    ========================================================== --}}

    <div class="login-left">

        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>

        <div class="left-content">

            <div>

                <div class="logo-box">
                    ☕
                </div>

                <h1 class="brand-name">
                    KOPI KITA
                </h1>

                <p class="brand-description">
                    Coffee Shop Point of Sale yang membantu
                    mengelola penjualan, produk, stok,
                    transaksi, dan laporan dengan mudah.
                </p>

            </div>

            <div>

                <div class="coffee-quote">
                    "Secangkir kopi, sebuah cerita."
                </div>

                <div class="copyright">
                    © {{ date('Y') }} KOPI KITA
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         RIGHT SIDE
    ========================================================== --}}

    <div class="login-right">

        <div class="login-form">

            <div class="login-heading">

                <h2>
                    Selamat Datang 👋
                </h2>

                <p>
                    Masuk ke akun Anda untuk mengakses
                    sistem KOPI KITA.
                </p>

            </div>


            {{-- =================================================
                 SUCCESS MESSAGE
            ================================================== --}}

            @if (session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            {{-- =================================================
                 ERROR MESSAGE
            ================================================== --}}

            @if (session('error'))

                <div class="alert alert-error">
                    {{ session('error') }}
                </div>

            @endif


            {{-- =================================================
                 VALIDATION ERRORS
            ================================================== --}}

            @if ($errors->any())

                <div class="alert alert-error">

                    <strong>
                        Login gagal.
                    </strong>

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =================================================
                 LOGIN FORM
            ================================================== --}}

            <form
                method="POST"
                action="{{ route('login.process') }}"
            >

                @csrf


                {{-- EMAIL --}}

                <div class="form-group">

                    <label
                        for="email"
                        class="form-label"
                    >
                        Email
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            ✉
                        </span>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            autocomplete="email"
                            required
                            autofocus
                        >

                    </div>

                    @error('email')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- PASSWORD --}}

                <div class="form-group">

                    <label
                        for="password"
                        class="form-label"
                    >
                        Password
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            🔒
                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input password-input"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="passwordToggle"
                            onclick="togglePassword()"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                    @error('password')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- REMEMBER --}}

                <div class="form-options">

                    <label class="remember">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            {{ old('remember') ? 'checked' : '' }}
                        >

                        <span>
                            Ingat saya
                        </span>

                    </label>

                </div>


                {{-- LOGIN BUTTON --}}

                <button
                    type="submit"
                    class="login-button"
                >
                    Masuk ke Sistem
                </button>

            </form>


            {{-- =================================================
                 DEVELOPMENT INFO
            ================================================== --}}

            @if (app()->environment('local'))

                <div class="dev-info">

                    <strong>Development Mode</strong>

                    <br>

                    Akun Admin:

                    <br>

                    <strong>
                        admin@kopikita.com
                    </strong>

                    <br>

                    Password:

                    <strong>
                        password123
                    </strong>

                    <br><br>

                    Akun Kasir:

                    <br>

                    <strong>
                        kasir@kopikita.com
                    </strong>

                    <br>

                    Password:

                    <strong>
                        password123
                    </strong>

                </div>

            @endif

        </div>

    </div>

</div>


<script>

    function togglePassword() {

        const password =
            document.getElementById('password');

        const button =
            document.getElementById('passwordToggle');

        if (password.type === 'password') {

            password.type = 'text';

            button.textContent = '🙈';

            button.setAttribute(
                'aria-label',
                'Sembunyikan password'
            );

        } else {

            password.type = 'password';

            button.textContent = '👁';

            button.setAttribute(
                'aria-label',
                'Tampilkan password'
            );
        }
    }

</script>

</body>
</html>