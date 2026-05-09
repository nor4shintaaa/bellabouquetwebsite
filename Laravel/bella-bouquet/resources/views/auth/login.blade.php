<x-guest-layout>
    <style>
        /* Sembunyikan Header default Laravel jika ada */
        .min-h-screen {
            background: #fffafb !important; /* Warna dasar soft pink khas Bella */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            padding: 50px;
            border-radius: 32px;
            box-shadow: 0 20px 50px rgba(244, 114, 182, 0.15);
            width: 100%;
            max-width: 450px;
            border: 1px solid #fce7f3;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            font-size: 2rem;
            font-weight: 900;
            color: #1e293b;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .login-header h1 span {
            color: #f472b6; /* Pink khas BellaAdmin */
        }

        .login-header p {
            color: #64748b;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            font-weight: 600;
            color: #1e293b;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #fbcfe8;
            background: white;
            box-shadow: 0 0 0 4px #fdf2f8;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: #9f1239; /* Deep Rose sesuai tombol utama */
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(159, 18, 57, 0.2);
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #be123c;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(159, 18, 57, 0.3);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
        }

        .remember-me input {
            width: 18px;
            height: 18px;
            accent-color: #f472b6;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.875rem;
            font-weight: 700;
            color: #f472b6;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #db2777;
        }
    </style>

    <div class="login-card">
        <div class="login-header">
            <h1>Bella<span>Admin</span></h1>
            <p>Silakan login untuk mengelola toko Anda.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@gmail.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Kata Sandi</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mb-8">
                <label for="remember_me" class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                Masuk Sekarang
            </button>
        </form>
    </div>
</x-guest-layout>