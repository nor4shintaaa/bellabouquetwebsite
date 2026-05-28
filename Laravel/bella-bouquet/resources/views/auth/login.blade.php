<x-guest-layout>
    <style>
        /* Sembunyikan Header default Laravel jika ada */
        .min-h-screen {
            background: #fffafb !important;
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
            color: #f472b6;
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

        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper .form-input {
            padding-right: 55px;
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            color: #94a3b8;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password:hover {
            color: #f472b6;
        }

        .toggle-password svg {
            width: 22px;
            height: 22px;
        }

        .hidden-icon {
            display: none;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: #9f1239;
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
                <input
                    id="email"
                    class="form-input"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Silakan isi alamat email"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Kata Sandi</label>

                <div class="password-wrapper">
                    <input
                        id="password"
                        class="form-input"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Silakan isi kata sandi"
                    />

                    <button
                        type="button"
                        class="toggle-password"
                        id="togglePassword"
                        aria-label="Tampilkan atau sembunyikan kata sandi"
                    >
                        <!-- Icon mata terbuka -->
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <!-- Icon mata tertutup -->
                        <svg id="eyeClosed" class="hidden-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.223-3.592m3.31-2.218A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.132 5.411M15 12a3 3 0 00-3-3m0 0a3 3 0 00-3 3m3-3l9 9M3 3l18 18" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mb-8">
                <label for="remember_me" class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>

                <!-- @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif -->
            </div>

            <button type="submit" class="btn-login">
                Masuk Sekarang
            </button>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            eyeOpen.classList.toggle('hidden-icon', isPassword);
            eyeClosed.classList.toggle('hidden-icon', !isPassword);
        });
    </script>
</x-guest-layout>