<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Bella Bouquet</title>
    <link rel="stylesheet" href="{{ asset('css/auth-pink.css') }}">
</head>
<body>
    <main class="auth-page">
        <section class="auth-card">
            <div class="auth-left">
                <div class="left-content">
                    <h1>Welcome to <span>Bella Bouquet!</span></h1>

                    <p>
                        Temukan dan kelola produk bouquet dengan tampilan yang manis,
                        rapi, dan mudah digunakan.
                    </p>

                    <div class="left-small-text">
                        Beautiful bouquet, simple management.
                    </div>
                </div>
            </div>

            <div class="auth-right">
                <div class="form-box">
                    <div class="form-header">
                        <h2>Get Started</h2>
                        <p>
                            Silakan pilih untuk masuk atau membuat akun pelanggan baru.
                        </p>
                    </div>

                    <a href="{{ route('login') }}" class="btn-primary-auth">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="btn-secondary-auth">
                        Register
                    </a>

                    <div class="separator">
                        Bella Bouquet
                    </div>

                    <div class="form-footer">
                        Admin akan masuk ke dashboard admin, sedangkan pelanggan akan diarahkan ke halaman pelanggan.
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>