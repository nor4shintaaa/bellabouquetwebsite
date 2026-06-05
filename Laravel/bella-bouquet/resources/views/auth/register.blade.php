<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bella Bouquet</title>
    <link rel="stylesheet" href="{{ asset('css/auth-pink.css') }}">
</head>
<body>
    <main class="auth-page">
        <section class="auth-card">
            <div class="auth-left">
                <div class="left-content">
                    <h1>Create Your <span>Account!</span></h1>

                    <p>
                        Daftar sebagai pelanggan Bella Bouquet untuk mulai menggunakan layanan.
                        Akun yang dibuat dari halaman ini otomatis menjadi pelanggan.
                    </p>

                    <div class="left-small-text">
                        Join Bella Bouquet as a customer.
                    </div>
                </div>
            </div>

            <div class="auth-right">
                <div class="form-box">
                    <div class="form-header">
                        <h2>Sign Up</h2>
                        <p>
                            Sudah punya akun?
                            <a href="{{ route('login') }}">Sign In</a>
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="form-label">Nama</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-input"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Masukkan nama lengkap"
                            >

                            @error('name')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-input"
                                required
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
                                    autocomplete="new-password"
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

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="password-wrapper">
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    class="form-input"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Ulangi password"
                                >

                                <button type="button" class="toggle-password" id="togglePasswordConfirm">
                                    Lihat
                                </button>
                            </div>

                            @error('password_confirmation')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-primary-auth">
                            Sign Up
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
        function setupToggle(buttonId, inputId) {
            const button = document.getElementById(buttonId);
            const input = document.getElementById(inputId);

            if (button && input) {
                button.addEventListener('click', function () {
                    const isPassword = input.type === 'password';

                    input.type = isPassword ? 'text' : 'password';
                    button.textContent = isPassword ? 'Tutup' : 'Lihat';
                });
            }
        }

        setupToggle('togglePassword', 'password');
        setupToggle('togglePasswordConfirm', 'password_confirmation');
    </script>
</body>
</html>