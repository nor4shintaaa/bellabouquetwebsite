@extends('layouts.app')

@section('content')
<style>
    .profile-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        padding: 48px 24px 80px;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
        align-items: start;
    }

    @media (min-width: 1024px) {
        .profile-grid {
            grid-template-columns: 1fr 2fr;
        }
    }

    .profile-card {
        background-color: var(--white, #ffffff);
        padding: 40px 24px;
        border-radius: 32px;
        text-align: center;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }

    .avatar-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 24px auto;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff1f2;
        box-shadow: 0 4px 10px rgba(244, 63, 94, 0.15);
        transition: all 0.3s ease;
    }

    .avatar-upload-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 36px;
        height: 36px;
        background-color: #e11d48;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid white;
        transition: all 0.2s ease;
    }

    .avatar-upload-btn:hover {
        background-color: #be123c;
        transform: scale(1.1);
    }

    .profile-name-large {
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--slate-900, #0f172a);
        margin-bottom: 4px;
    }

    .profile-role-badge {
        display: inline-block;
        padding: 6px 16px;
        background-color: #fce7f3;
        color: #db2777;
        font-size: 0.75rem;
        font-weight: 800;
        border-radius: 20px;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 24px;
    }

    .profile-info-box {
        border-top: 1px solid var(--slate-100, #f1f5f9);
        padding-top: 24px;
        margin-top: 8px;
        text-align: left;
    }

    .profile-info-item {
        margin-bottom: 16px;
    }

    .profile-info-label {
        font-size: 0.75rem;
        color: var(--slate-400, #94a3b8);
        font-weight: 700;
    }

    .profile-info-text {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--slate-700, #334155);
        margin-top: 4px;
    }

    .form-section {
        background-color: var(--white, #ffffff);
        padding: 40px;
        border-radius: 32px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--slate-800, #1e293b);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid var(--slate-100, #f1f5f9);
        padding-bottom: 16px;
    }

    .label-pengaturan {
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--slate-500, #64748b);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
        display: block;
    }

    .input-pengaturan {
        width: 100%;
        padding: 16px 20px;
        border-radius: 16px;
        border: 1px solid var(--slate-200, #e2e8f0);
        font-family: inherit;
        font-size: 0.95rem;
        color: var(--slate-700, #334155);
        outline: none;
        transition: all 0.3s ease;
        background-color: #f8fafc;
        margin-bottom: 8px;
    }

    .input-pengaturan:focus {
        background-color: #ffffff;
        border-color: #fbcfe8;
        box-shadow: 0 0 0 4px #fdf2f8;
    }

    .grid-2-col {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0 24px;
    }

    @media (min-width: 768px) {
        .grid-2-col {
            grid-template-columns: 1fr 1fr;
        }
    }

    .error-text {
        color: #e11d48;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 18px;
        display: block;
    }

    .btn-wrapper {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        margin-bottom: 60px;
    }

    .btn-cancel {
        padding: 16px 32px;
        border-radius: 14px;
        font-weight: 800;
        font-size: 1rem;
        color: var(--slate-500, #64748b);
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .btn-save-profile {
        background-color: #9f1239;
        padding: 16px 32px;
        border-radius: 14px;
        font-weight: 800;
        font-size: 1rem;
        border: none;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(159, 18, 57, 0.2);
    }

    .btn-save-profile:hover {
        background-color: #be123c;
        transform: translateY(-2px);
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 16px 20px;
        border-radius: 16px;
        font-weight: 700;
        margin-bottom: 24px;
        border: 1px solid #bbf7d0;
    }
</style>

@php
    $loginUser = $user ?? auth()->user();

    $avatarUrl = $loginUser->avatar_path
        ? asset('storage/' . $loginUser->avatar_path)
        : 'https://ui-avatars.com/api/?name=' . urlencode($loginUser->name ?? 'Admin Bella') . '&background=ffe4e6&color=e11d48&size=200&bold=true';
@endphp

<div class="profile-wrapper">
    <div class="header-pengaturan" style="margin-bottom: 32px;">
        <h1 class="page-title" style="font-size: 2.25rem; font-weight: 900; color: var(--slate-900, #0f172a); margin-bottom: 8px;">
            Profil Akun
        </h1>
        <p class="page-subtitle" style="font-size: 1.05rem; color: var(--slate-500, #64748b);">
            Kelola informasi personal dan keamanan akun Admin Anda.
        </p>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form id="profileForm" action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="profile-grid">
            <div class="profile-card">
                <div class="avatar-wrapper">
                    <img id="avatarPreview" src="{{ $avatarUrl }}" class="avatar-img" alt="Admin Avatar">

                    <input type="file" id="uploadAvatar" name="avatar" accept="image/*" style="display: none;">

                    <label for="uploadAvatar" class="avatar-upload-btn" title="Ganti Foto">
                        <i data-lucide="camera" style="width: 16px; height: 16px;"></i>
                    </label>
                </div>

                @error('avatar')
                    <span class="error-text">{{ $message }}</span>
                @enderror

                <h2 class="profile-name-large">{{ $loginUser->name }}</h2>
                <div class="profile-role-badge">Super Owner</div>

                <div class="profile-info-box">
                    <div class="profile-info-item">
                        <span class="profile-info-label">EMAIL TERDAFTAR</span>
                        <p class="profile-info-text">{{ $loginUser->email }}</p>
                    </div>

                    <div class="profile-info-item">
                        <span class="profile-info-label">USERNAME</span>
                        <p class="profile-info-text">{{ $loginUser->username ?? '-' }}</p>
                    </div>

                    <div class="profile-info-item">
                        <span class="profile-info-label">NOMOR TELEPON</span>
                        <p class="profile-info-text">{{ $loginUser->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <div class="form-section">
                    <h3 class="section-title">
                        <i data-lucide="user" style="color: #f472b6;"></i>
                        Informasi Dasar
                    </h3>

                    <div class="grid-2-col">
                        <div>
                            <label class="label-pengaturan">Nama Lengkap</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $loginUser->name) }}"
                                class="input-pengaturan"
                                placeholder="Masukkan nama lengkap"
                                required
                            >
                            @error('name')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="label-pengaturan">Username</label>
                            <input
                                type="text"
                                name="username"
                                value="{{ old('username', $loginUser->username) }}"
                                class="input-pengaturan"
                                placeholder="Contoh: admin_bella"
                            >
                            @error('username')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <label class="label-pengaturan">Alamat Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $loginUser->email) }}"
                        class="input-pengaturan"
                        placeholder="Masukkan alamat email"
                        required
                    >
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror

                    <label class="label-pengaturan">Nomor Telepon</label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $loginUser->phone) }}"
                        class="input-pengaturan"
                        placeholder="Contoh: 081234567890"
                    >
                    @error('phone')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-wrapper">
                    <a href="{{ route('dashboard') }}" class="btn-cancel">
                        Batal
                    </a>

                    <button type="submit" class="btn-save-profile">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const uploadInput = document.getElementById('uploadAvatar');
        const avatarPreview = document.getElementById('avatarPreview');

        if (uploadInput && avatarPreview) {
            uploadInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        avatarPreview.style.opacity = '0.5';

                        setTimeout(() => {
                            avatarPreview.src = e.target.result;
                            avatarPreview.style.opacity = '1';
                        }, 150);
                    };

                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        @if (session('success'))
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Profil Diperbarui!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#9f1239',
                    customClass: {
                        popup: 'swal-modern'
                    }
                });
            }
        @endif
    });
</script>
@endpush
@endsection