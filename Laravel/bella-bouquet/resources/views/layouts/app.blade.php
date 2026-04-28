<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bella Admin Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* CSS VARIABEL UTAMA */
        :root {
            --primary: #f43f5e;
            --primary-hover: #e11d48;
            --primary-light: #fff1f2;
            --bg-body: #fff1f2;
            --white: #ffffff;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #f43f5e;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        /* RESET & BASE */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-body); 
            color: var(--slate-800); 
            -webkit-font-smoothing: antialiased;
        }
        a { text-decoration: none; color: inherit; }
        button { border: none; background: none; cursor: pointer; font-family: inherit; }
        input { font-family: inherit; }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--slate-200); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--slate-400); }

        /* LAYOUT & NAVBAR */
        .container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
        .navbar {
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            position: sticky; top: 0; z-index: 50;
        }
        .nav-content { display: flex; justify-content: space-between; align-items: center; height: 80px; }
        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .brand-icon {
            width: 40px; height: 40px; 
            background: linear-gradient(to top right, var(--primary), #ec4899);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            color: white; box-shadow: 0 4px 14px 0 rgba(244, 63, 94, 0.39);
        }
        .brand-text { font-size: 1.5rem; font-weight: 800; color: var(--slate-900); letter-spacing: -0.5px; }
        .brand-text span { color: var(--primary); }
        
        .nav-links { display: none; align-items: center; gap: 8px; }
        @media (min-width: 768px) { .nav-links { display: flex; } }
        .nav-item {
            padding: 8px 16px; border-radius: 12px; font-size: 0.875rem; font-weight: 600;
            color: var(--slate-500); transition: all 0.3s ease;
        }
        .nav-item:hover { background-color: var(--slate-50); color: var(--slate-900); }
        .nav-item.active { background-color: var(--primary-light); color: var(--primary-hover); }

        .nav-profile { display: flex; align-items: center; gap: 16px; }
        .profile-info { display: none; flex-direction: column; align-items: flex-end; }
        @media (min-width: 640px) { .profile-info { display: flex; } }
        .profile-name { font-size: 0.875rem; font-weight: 700; color: var(--slate-900); line-height: 1; margin-bottom: 4px; }
        .profile-role { font-size: 0.75rem; font-weight: 500; color: var(--slate-500); }
        .profile-img { width: 40px; height: 40px; border-radius: 50%; border: 2px solid white; box-shadow: var(--shadow-sm); }

        .main-content { padding: 40px 24px; }

        /* TYPOGRAPHY & HEADERS */
        .page-header { display: flex; flex-direction: column; gap: 16px; margin-bottom: 40px; }
        @media (min-width: 768px) { .page-header { flex-direction: row; justify-content: space-between; align-items: flex-end; } }
        .page-title { font-size: 1.875rem; font-weight: 800; color: var(--slate-900); letter-spacing: -0.5px; }
        .page-subtitle { font-size: 1rem; color: var(--slate-500); font-weight: 500; margin-top: 4px; }
        .date-badge {
            font-size: 0.875rem; font-weight: 600; color: var(--slate-500);
            background-color: var(--white); padding: 8px 16px; border-radius: 12px;
            border: 1px solid var(--slate-200); box-shadow: var(--shadow-sm);
        }

        /* BUTTONS */
        .btn-primary {
            background-color: var(--slate-900); color: white; padding: 14px 24px;
            border-radius: 16px; font-weight: 700; font-size: 0.875rem;
            display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.1);
        }
        .btn-primary:hover { background-color: var(--primary-hover); box-shadow: 0 10px 15px -3px rgba(225, 29, 72, 0.2); }
        .btn-primary i { transition: transform 0.3s ease; }
        .btn-primary:hover i { transform: rotate(90deg); }
        .btn-icon {
            padding: 10px; border-radius: 12px; background-color: var(--slate-50);
            color: var(--slate-400); transition: all 0.3s ease;
        }
        .btn-icon:hover { background-color: var(--slate-200); color: var(--slate-600); }
        .btn-icon.edit:hover { background-color: #fef3c7; color: var(--warning); }
        .btn-icon.delete:hover { background-color: var(--primary-light); color: var(--danger); }

        /* STATS CARDS */
        .stats-grid { display: grid; grid-template-columns: 1fr; gap: 24px; margin-bottom: 48px; }
        @media (min-width: 640px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }
        .stat-card {
            background-color: var(--white); padding: 24px; border-radius: 24px;
            border: 1px solid var(--slate-100); box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
        .stat-header { display: flex; align-items: center; gap: 16px; margin-bottom: 16px; }
        .stat-icon { padding: 12px; border-radius: 16px; background-color: var(--slate-50); color: var(--slate-600); }
        .stat-icon.alert { background-color: var(--primary-light); color: var(--primary-hover); }
        .stat-label { font-size: 0.75rem; font-weight: 700; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-value { font-size: 1.875rem; font-weight: 900; color: var(--slate-800); letter-spacing: -0.5px; }

        /* SECTION CONTAINER */
        .section-box {
            background-color: var(--white); padding: 32px; border-radius: 40px;
            border: 1px solid var(--slate-100); box-shadow: var(--shadow-sm);
        }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .section-title { font-size: 1.25rem; font-weight: 700; color: var(--slate-900); display: flex; align-items: center; gap: 12px; }
        .section-indicator { width: 12px; height: 32px; background: linear-gradient(to bottom, #fb7185, var(--primary)); border-radius: 8px; }
        .link-accent { font-size: 0.875rem; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 4px; transition: color 0.3s ease; }
        .link-accent:hover { color: var(--primary-hover); }
        .link-accent i { width: 16px; height: 16px; transition: transform 0.3s ease; }
        .link-accent:hover i { transform: translateX(4px); }

        /* PRODUCT GRIDS (DASHBOARD) */
        .product-grid { display: grid; grid-template-columns: 1fr; gap: 32px; }
        @media (min-width: 768px) { .product-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .product-grid { grid-template-columns: repeat(3, 1fr); } }
        
        .product-card {
            background-color: rgba(248, 250, 252, 0.5); border: 1px solid var(--slate-100);
            border-radius: 32px; overflow: hidden; transition: all 0.5s ease;
            display: flex; flex-direction: column;
        }
        .product-card:hover { box-shadow: 0 25px 50px -12px rgba(226, 232, 240, 0.5); }
        .product-img-wrapper { position: relative; aspect-ratio: 4/3; overflow: hidden; }
        .product-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease-out; }
        .product-card:hover .product-img { transform: scale(1.1); }
        .product-badges { position: absolute; top: 16px; left: 16px; right: 16px; display: flex; justify-content: space-between; }
        .badge { padding: 6px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 800; box-shadow: var(--shadow-sm); }
        .badge-glass { background-color: rgba(255, 255, 255, 0.9); backdrop-filter: blur(8px); color: var(--slate-800); }
        .badge-success { background-color: var(--success); color: white; }
        .badge-danger { background-color: var(--danger); color: white; }
        
        .product-info { padding: 24px; display: flex; flex-direction: column; flex-grow: 1; }
        .product-meta { display: flex; gap: 12px; margin-bottom: 12px; }
        .meta-item {
            display: flex; align-items: center; gap: 6px; font-size: 0.75rem; font-weight: 700;
            color: var(--slate-500); background: white; padding: 4px 10px; border-radius: 8px; border: 1px solid var(--slate-200);
        }
        .meta-item i.rose { color: var(--primary); }
        .meta-item i.amber { color: var(--warning); }
        .product-name { font-size: 1.25rem; font-weight: 800; color: var(--slate-900); margin-bottom: 8px; transition: color 0.3s ease; }
        .product-card:hover .product-name { color: var(--primary-hover); }
        .product-footer {
            margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(226, 232, 240, 0.6);
            display: flex; justify-content: space-between; align-items: center;
        }
        .product-price { font-size: 1.25rem; font-weight: 900; color: var(--slate-800); }

        /* LIST LAYOUT (PRODUK) */
        .layout-wrapper { display: flex; flex-direction: column; gap: 32px; }
        @media (min-width: 1024px) { .layout-wrapper { flex-direction: row; } }
        
        .sidebar { width: 100%; flex-shrink: 0; }
        @media (min-width: 1024px) { .sidebar { width: 280px; } }
        .filter-box {
            background: var(--white); padding: 24px; border-radius: 32px;
            border: 1px solid var(--slate-100); box-shadow: var(--shadow-sm);
            position: sticky; top: 112px;
        }
        .filter-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .filter-title { font-weight: 800; color: var(--slate-900); }
        .btn-reset { font-size: 0.75rem; font-weight: 700; color: var(--slate-400); }
        .btn-reset:hover { color: var(--primary); }
        
        .form-group { margin-bottom: 24px; }
        .form-label { display: block; font-size: 0.75rem; font-weight: 900; color: var(--slate-400); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px; }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--slate-400); width: 16px; height: 16px; transition: color 0.3s ease; }
        .input-wrapper input:focus + i, .input-wrapper:focus-within i { color: var(--primary); }
        .form-input {
            width: 100%; padding: 12px 16px 12px 44px; background: var(--slate-50); border: 1px solid var(--slate-200);
            border-radius: 16px; font-size: 0.875rem; font-weight: 500; outline: none; transition: all 0.3s ease;
        }
        .form-input:focus { background: var(--white); border-color: #fca5a5; box-shadow: 0 0 0 4px var(--primary-light); }
        
        .checkbox-group { display: flex; flex-direction: column; gap: 12px; }
        .checkbox-label {
            display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--slate-50);
            border: 1px solid transparent; border-radius: 16px; cursor: pointer; transition: all 0.3s ease;
        }
        .checkbox-label:hover { background: var(--primary-light); border-color: #ffe4e6; }
        .checkbox-label input { width: 20px; height: 20px; accent-color: var(--primary); cursor: pointer; }
        .checkbox-text { font-size: 0.875rem; font-weight: 700; color: var(--slate-600); }
        .checkbox-label:hover .checkbox-text { color: var(--primary-hover); }
        
        .btn-block {
            width: 100%; padding: 12px; background: var(--slate-100); color: var(--slate-700);
            font-weight: 700; font-size: 0.875rem; border-radius: 16px; transition: background 0.3s ease;
        }
        .btn-block:hover { background: var(--slate-200); }

        /* LIST CARD (PRODUK) */
        .list-grid { display: grid; grid-template-columns: 1fr; gap: 24px; flex-grow: 1; }
        @media (min-width: 768px) { .list-grid { grid-template-columns: repeat(2, 1fr); } }
        /* Tambahan: 3 kolom di monitor yang lebih lebar agar gambar tidak terlalu raksasa */
        @media (min-width: 1280px) { .list-grid { grid-template-columns: repeat(3, 1fr); } }
        
        .list-card {
            background: var(--white); padding: 16px; border-radius: 32px; border: 1px solid var(--slate-100);
            display: flex; flex-direction: column; gap: 20px; transition: all 0.3s ease;
        }
        /* Efek hover kita tambahkan efek naik sedikit (translateY) agar lebih interaktif */
        .list-card:hover { box-shadow: 0 20px 25px -5px rgba(226, 232, 240, 0.5); transform: translateY(-4px); }
        
        .list-img-box {
            width: 100%; aspect-ratio: 4/3; /* Rasio 4:3 membuat gambar proporsional dan besar */
            border-radius: 24px; overflow: hidden;
            position: relative; background: var(--slate-100); flex-shrink: 0;
        }
        /* Media query 160px dihapus agar gambar melebar penuh mengikuti card */
        .list-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease; }
        .list-card:hover .list-img-box img { transform: scale(1.05); }
        .list-img-overlay { position: absolute; inset: 0; border: 1px solid rgba(0,0,0,0.05); border-radius: 24px; pointer-events: none; }
        
        /* Padding dan margin sedikit dilonggarkan agar teks lebih lega saat mode vertikal */
        .list-info { flex-grow: 1; display: flex; flex-direction: column; padding: 4px 8px; }
        .list-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
        .list-code { background: var(--slate-100); color: var(--slate-600); padding: 4px 10px; border-radius: 8px; font-size: 0.625rem; font-weight: 900; letter-spacing: 0.1em; }
        .list-status { display: flex; align-items: center; gap: 6px; font-size: 0.6875rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; }
        .list-status.tersedia { color: var(--success); }
        .list-status.menipis { color: var(--danger); }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; }
        .status-dot.tersedia { background-color: var(--success); }
        .status-dot.menipis { background-color: var(--danger); }
        
        .list-title { font-size: 1.25rem; font-weight: 800; color: var(--slate-900); line-height: 1.3; margin-bottom: 6px; transition: color 0.3s ease; }
        .list-card:hover .list-title { color: var(--primary-hover); }
        .list-desc { font-size: 0.875rem; font-weight: 600; color: var(--slate-500); margin-bottom: 16px; }
        
        .list-bottom { margin-top: auto; display: flex; justify-content: space-between; align-items: center; }
        .list-price { font-size: 1.25rem; font-weight: 900; color: var(--slate-800); }
        .list-actions { display: flex; gap: 8px; }

        /* EMPTY STATE */
        .empty-state {
            background: var(--white); border: 1px solid var(--slate-100); border-radius: 32px;
            padding: 48px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .empty-icon { width: 64px; height: 64px; background: var(--slate-50); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: var(--slate-400); margin-bottom: 16px; }
        .empty-icon i { width: 32px; height: 32px; }
        .empty-title { font-size: 1.125rem; font-weight: 700; color: var(--slate-900); margin-bottom: 4px; }
        .empty-desc { font-size: 0.875rem; font-weight: 500; color: var(--slate-500); }


        /* TOAST NOTIFICATION (POJOK KANAN BAWAH) */
        .toast-notification {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: var(--white);
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border-left: 6px solid var(--success);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            z-index: 9999;
            transform: translateX(150%);
            animation: slideInRight 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            min-width: 320px;
            overflow: hidden;
        }

        .toast-notification.hide {
            animation: slideOutRight 0.5s ease-in forwards;
        }

        .toast-icon { color: var(--success); display: flex; align-items: center; justify-content: center; }
        .toast-content { flex-grow: 1; }
        .toast-title { font-weight: 800; color: var(--slate-900); font-size: 0.875rem; margin-bottom: 2px; }
        .toast-message { font-weight: 600; color: var(--slate-500); font-size: 0.75rem; }

        .toast-close {
            color: var(--slate-400); background: none; padding: 4px; border-radius: 50%; transition: all 0.2s ease;
        }
        .toast-close:hover { background-color: var(--slate-100); color: var(--slate-900); }

        /* Garis waktu berjalan di bawah notifikasi */
        .toast-progress {
            position: absolute; bottom: 0; left: 0; height: 4px; background-color: var(--success);
            animation: progressShrink 3s linear forwards;
        }

        /* Animasi */
        @keyframes slideInRight {
            0% { transform: translateX(150%); }
            100% { transform: translateX(0); }
        }
        @keyframes slideOutRight {
            0% { transform: translateX(0); }
            100% { transform: translateX(150%); }
        }
        @keyframes progressShrink {
            0% { width: 100%; }
            100% { width: 0%; }
        }

        /* FOOTER STYLES */
        .site-footer {
            border-top: 1px solid rgba(226, 232, 240, 0.6);
            padding: 24px 0;
            margin-top: 40px;
        }
        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }
        @media (min-width: 640px) {
            .footer-content {
                flex-direction: row;
                justify-content: space-between;
            }
        }
        

        .footer-text {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--slate-500);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .footer-text span {
            color: var(--slate-900);
            font-weight: 800;
        }
        .footer-text span.rose {
            color: var(--primary);
        }
        .footer-links {
            display: flex;
            gap: 24px;
        }
        .footer-link {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--slate-400);
            transition: color 0.3s ease;
        }
        .footer-link:hover {
            color: var(--primary-hover);
        }
        .site-footer {
            background-color: var(--white);
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container nav-content">
            <div class="nav-brand">

                <span class="brand-text">Bella<span>Admin</span></span>
            </div>

            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('produk') }}" class="nav-item {{ request()->routeIs('produk') ? 'active' : '' }}">
                    Katalog Produk
                </a>
                <a href="#" class="nav-item ">
                    Pemesanan
                </a>
                <a href="#" class="nav-item ">
                    Pelanggan
                </a>
            </div>

            <div class="nav-profile">
                <div class="profile-info">
                    <span class="profile-name">Admin</span>
                    <span class="profile-role">Owner</span>
                </div>
                <img src="https://ui-avatars.com/api/?name=Admin+Bella&background=ffe4e6&color=e11d48&bold=true" class="profile-img" alt="Admin">
            </div>
        </div>
    </nav>

    <main class="container main-content">
        @yield('content')
    </main>

@if(session('success'))
    <div id="toast-success" class="toast-notification">
        <div class="toast-icon">
            <i data-lucide="check-circle" style="width: 24px; height: 24px;"></i>
        </div>
        <div class="toast-content">
            <p class="toast-title">Berhasil!</p>
            <p class="toast-message">{{ session('success') }}</p>
        </div>
        <button class="toast-close" onclick="closeToast()" title="Tutup">
            <i data-lucide="x" style="width: 16px; height: 16px;"></i>
        </button>
        <div class="toast-progress"></div>
    </div>
    @endif

    </main> <footer class="site-footer">
        <div class="container footer-content">
            <div class="footer-text">
                &copy; {{ date('Y') }} <span>Bella<span class="rose">Admin</span></span>. 
                Dibuat dengan <i data-lucide="heart" style="width: 14px; height: 14px; color: var(--primary); fill: var(--primary);"></i> untuk bisnis Anda.
            </div>
            
            <div class="footer-links">
                <a href="#" class="footer-link">Pusat Bantuan</a>
                <a href="#" class="footer-link">Versi 1.0.0</a>
            </div>
        </div>
    </footer>

    <script>
        // Inisialisasi ikon
        lucide.createIcons();

        // Fungsi untuk menutup toast secara manual (tombol X)
        function closeToast() {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.classList.add('hide'); // Tambahkan class animasi keluar
                setTimeout(() => { toast.remove(); }, 500); // Hapus elemen setelah animasi selesai
            }
        }

        // Fungsi otomatis menutup toast setelah 3 detik
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                setTimeout(() => {
                    closeToast();
                }, 3000); // 3000 milidetik = 3 detik
            }
        });
    </script>
</body>
</html>