@extends('layouts.app')

@section('content')
<style>
    /* ==========================================================================
       CSS HALAMAN PROFIL
       ========================================================================== */
    .profile-wrapper { max-width: 1000px; margin: 0 auto; }
    
    .profile-grid { display: grid; grid-template-columns: 1fr; gap: 32px; align-items: start; }
    @media (min-width: 1024px) {
        .profile-grid { grid-template-columns: 1fr 2fr; } /* Layout terbagi 1:2 di layar besar */
    }

    /* KARTU PROFIL KIRI */
    .profile-card { background-color: var(--white); padding: 40px 24px; border-radius: 32px; text-align: center; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); }
    
    .avatar-wrapper { position: relative; width: 120px; height: 120px; margin: 0 auto 24px auto; }
    .avatar-img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 4px solid #fff1f2; box-shadow: 0 4px 10px rgba(244, 63, 94, 0.15); }
    
    /* Tombol Upload Avatar overlay */
    .avatar-upload-btn {
        position: absolute; bottom: 0; right: 0; width: 36px; height: 36px;
        background-color: #e11d48; color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; border: 3px solid white; transition: all 0.2s ease;
    }
    .avatar-upload-btn:hover { background-color: #be123c; transform: scale(1.1); }

    .profile-name-large { font-size: 1.5rem; font-weight: 900; color: var(--slate-900); margin-bottom: 4px; }
    .profile-role-badge { display: inline-block; padding: 6px 16px; background-color: #fce7f3; color: #db2777; font-size: 0.75rem; font-weight: 800; border-radius: 20px; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 24px; }

    /* FORM KANAN */
    .form-section { background-color: var(--white); padding: 40px; border-radius: 32px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); margin-bottom: 24px; }
    .section-title { font-size: 1.25rem; font-weight: 800; color: var(--slate-800); margin-bottom: 24px; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--slate-100); padding-bottom: 16px; }
    
    .label-pengaturan { font-size: 0.75rem; font-weight: 800; color: var(--slate-500); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block; }
    .input-pengaturan { width: 100%; padding: 16px 20px; border-radius: 16px; border: 1px solid var(--slate-200); font-family: inherit; font-size: 0.95rem; color: var(--slate-700); outline: none; transition: all 0.3s ease; background-color: #f8fafc; margin-bottom: 24px; }
    .input-pengaturan:focus { background-color: #ffffff; border-color: #fbcfe8; box-shadow: 0 0 0 4px #fdf2f8; }

    .grid-2-col { display: grid; grid-template-columns: 1fr; gap: 0 24px; }
    @media (min-width: 768px) { .grid-2-col { grid-template-columns: 1fr 1fr; } }
</style>

<div class="profile-wrapper">
    <div class="header-pengaturan" style="margin-bottom: 32px;">
        <h1 class="page-title" style="font-size: 2.25rem; font-weight: 900; color: var(--slate-900); margin-bottom: 8px;">Profil Akun</h1>
        <p class="page-subtitle" style="font-size: 1.05rem; color: var(--slate-500);">Kelola informasi personal dan keamanan akun Admin Anda.</p>
    </div>

    <div class="profile-grid">
        <div class="profile-card">
            <div class="avatar-wrapper">
                <img id="avatarPreview" src="https://ui-avatars.com/api/?name=Admin+Bella&background=ffe4e6&color=e11d48&size=200&bold=true" class="avatar-img" alt="Admin Avatar">
                
                <input type="file" id="uploadAvatar" accept="image/*" style="display: none;">
                <label for="uploadAvatar" class="avatar-upload-btn" title="Ganti Foto">
                    <i data-lucide="camera" style="width: 16px; height: 16px;"></i>
                </label>
            </div>
            
            <h2 class="profile-name-large">Admin Bella</h2>
            <div class="profile-role-badge">Super Owner</div>
            
            <div style="border-top: 1px solid var(--slate-100); padding-top: 24px; margin-top: 8px; text-align: left;">
                <div style="margin-bottom: 16px;">
                    <span style="font-size: 0.75rem; color: var(--slate-400); font-weight: 700;">EMAIL TERDAFTAR</span>
                    <p style="font-size: 0.9rem; font-weight: 600; color: var(--slate-700);">admin@bellabouquet.com</p>
                </div>
                <div>
                    <span style="font-size: 0.75rem; color: var(--slate-400); font-weight: 700;">TERAKHIR LOGIN</span>
                    <p style="font-size: 0.9rem; font-weight: 600; color: var(--slate-700);">Hari ini, 08:30 WIB</p>
                </div>
            </div>
        </div>

        <div>
            <form action="#" method="POST">
                @csrf
                
                <div class="form-section">
                    <h3 class="section-title"><i data-lucide="user" style="color: #f472b6;"></i> Informasi Dasar</h3>
                    
                    <div class="grid-2-col">
                        <div>
                            <label class="label-pengaturan">Nama Lengkap</label>
                            <input type="text" name="name" value="Admin Bella" class="input-pengaturan">
                        </div>
                        <div>
                            <label class="label-pengaturan">Username</label>
                            <input type="text" name="username" value="admin_bella" class="input-pengaturan">
                        </div>
                    </div>

                    <label class="label-pengaturan">Alamat Email</label>
                    <input type="email" name="email" value="admin@bellabouquet.com" class="input-pengaturan">
                    
                    <label class="label-pengaturan">Nomor Telepon</label>
                    <input type="text" name="phone" value="081234567890" class="input-pengaturan" style="margin-bottom: 0;">
                </div>

                <!-- <div class="form-section">
                    <h3 class="section-title"><i data-lucide="shield-check" style="color: #f472b6;"></i> Keamanan & Password</h3>
                    
                    <label class="label-pengaturan">Password Saat Ini</label>
                    <input type="password" name="current_password" placeholder="Masukkan password lama..." class="input-pengaturan">
                    
                    <div class="grid-2-col">
                        <div>
                            <label class="label-pengaturan">Password Baru</label>
                            <input type="password" name="new_password" placeholder="Minimal 8 karakter..." class="input-pengaturan" style="margin-bottom: 0;">
                        </div>
                        <div>
                            <label class="label-pengaturan">Konfirmasi Password</label>
                            <input type="password" name="new_password_confirmation" placeholder="Ulangi password baru..." class="input-pengaturan" style="margin-bottom: 0;">
                        </div>
                    </div>
                </div> -->

                <div style="display: flex; justify-content: flex-end; gap: 16px; margin-bottom: 60px;">
                    <a href="{{ route('dashboard') }}" style="padding: 16px 32px; border-radius: 14px; font-weight: 800; font-size: 1rem; color: var(--slate-500); text-decoration: none; display: flex; align-items: center;">
                        Batal
                    </a>
                    <button type="button" class="btn-primary" style="background-color: #9f1239; padding: 16px 32px; border-radius: 14px; font-weight: 800; font-size: 1rem; border: none; color: white; cursor: pointer; transition: all 0.3s ease;" onclick="showToastProfile()">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Variabel global sementara untuk menyimpan gambar sebelum tombol simpan ditekan
    let tempAvatarSrc = null;

    document.addEventListener('DOMContentLoaded', function() {
        const uploadInput = document.getElementById('uploadAvatar');
        const avatarPreview = document.getElementById('avatarPreview');

        // 1. SAAT HALAMAN DIBUKA: Cek apakah sebelumnya sudah ada foto yang tersimpan
        const savedAvatar = localStorage.getItem('adminAvatar');
        if (savedAvatar) {
            avatarPreview.src = savedAvatar;
        }

        // 2. SAAT UPLOAD FOTO BARU: Tampilkan preview
        uploadInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    tempAvatarSrc = e.target.result; // Simpan ke variabel sementara
                    
                    // Animasi pergantian gambar
                    avatarPreview.style.opacity = '0.5';
                    setTimeout(() => {
                        avatarPreview.src = tempAvatarSrc;
                        avatarPreview.style.opacity = '1';
                    }, 150);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // 3. SAAT TOMBOL SIMPAN DITEKAN
    function showToastProfile() {
        const navbarAvatar = document.querySelector('.profile-img');

        // Jika user mengupload foto baru, simpan permanen ke memori browser
        if (tempAvatarSrc) {
            localStorage.setItem('adminAvatar', tempAvatarSrc); // Simpan ke LocalStorage
            
            // Update gambar di Navbar langsung
            if (navbarAvatar) {
                navbarAvatar.style.opacity = '0.5';
                setTimeout(() => {
                    navbarAvatar.src = tempAvatarSrc;
                    navbarAvatar.style.opacity = '1';
                }, 150);
            }
        }

        // Munculkan Notifikasi
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success', 
                title: 'Profil Diperbarui!', 
                text: 'Data akun dan foto profil Anda berhasil disimpan secara permanen.',
                confirmButtonColor: '#9f1239', 
                shape: 'border-radius: 20px', 
                customClass: { popup: 'swal-modern' }
            });
        } else {
            alert('Berhasil disimpan!');
        }
    }
</script>
@endpush
@endsection