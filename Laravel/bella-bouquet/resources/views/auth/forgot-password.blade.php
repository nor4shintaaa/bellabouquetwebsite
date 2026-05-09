<x-guest-layout>
    <style>
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
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 1.8rem;
            font-weight: 900;
            color: #1e293b;
            letter-spacing: -1px;
            margin-bottom: 12px;
        }

        .login-header h1 span {
            color: #f472b6;
        }

        .info-text {
            color: #64748b;
            font-size: 0.9rem;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 500;
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

        .btn-primary-rose {
            width: 100%;
            padding: 16px;
            background: #9f1239;
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 0.95rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(159, 18, 57, 0.2);
        }

        .btn-primary-rose:hover {
            background: #be123c;
            transform: translateY(-2px);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            font-size: 0.875rem;
            font-weight: 700;
            color: #f472b6;
            text-decoration: none;
        }

        .back-link:hover {
            color: #db2777;
        }
    </style>

    <div class="login-card">
        <div class="login-header">
            <h1>Lupa<span>Sandi?</span></h1>
        </div>

        <div class="info-text">
            {{ __('Jangan khawatir! Masukkan alamat email Anda dan kami akan mengirimkan tautan pemulihan kata sandi.') }}
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-6">
                <label for="email" class="form-label">Alamat Email</label>
                <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus placeholder="admin@gmail.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="btn-primary-rose">
                    {{ __('Kirim Tautan Pemulihan') }}
                </button>
            </div>
        </form>

        <a href="{{ route('login') }}" class="back-link">
             Kembali ke Login
        </a>
    </div>
</x-guest-layout>