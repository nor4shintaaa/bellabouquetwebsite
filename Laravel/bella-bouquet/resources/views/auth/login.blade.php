<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bella Bouquet</title>
    <link rel="stylesheet" href="{{ asset('css/auth-pink.css') }}">
</head>
<body>
    <main class="auth-page">
        <section class="auth-card">
            <div class="auth-left">
                <div class="left-content">
                    <h1>Welcome Back to <span>Bella Bouquet!</span></h1>

                    <p>
                        Login untuk mengakses halaman sesuai role akun kamu.
                        Admin masuk ke dashboard, pelanggan masuk ke halaman pelanggan.
                    </p>

                    <div class="left-small-text">
                        Sign in and continue your bouquet journey.
                    </div>
                </div>
            </div>

            <div class="auth-right">
                <div class="form-box">
                    <div class="form-header">
                        <h2>Sign In</h2>
                        <p>
                            Belum punya akun?
                            <a href="{{ route('register') }}">Register</a>
                        </p>
                    </div>

                    @if (session('status'))
                        <div class="status-box">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-input"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Masukkan email"
                            >

                            @error('email')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>

                            <div class="password-wrapper">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-input"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Masukkan password"
                                >

                                <button type="button" class="toggle-password" id="togglePassword">
                                    Lihat
                                </button>
                            </div>

                            @error('password')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <label for="remember_me" class="remember-me">
                                <input id="remember_me" type="checkbox" name="remember">
                                <span>Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="forgot-link" href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn-primary-auth">
                            Sign In
                        </button>
                    </form>

                    <div class="separator">
                        Bella Bouquet
                    </div>

                    <div class="form-footer">
                        Kembali ke
                        <a href="{{ route('landing') }}">halaman utama</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';

                passwordInput.type = isPassword ? 'text' : 'password';
                togglePassword.textContent = isPassword ? 'Tutup' : 'Lihat';
            });
        }
    </script>
</body>
</html>