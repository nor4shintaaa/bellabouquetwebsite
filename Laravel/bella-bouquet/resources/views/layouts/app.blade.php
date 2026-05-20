<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <script>
        function setCookie(name, value, days) {
            let expires = "";

            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }

            document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
        }

        function getCookie(name) {
            const nameEQ = name + "=";
            const cookies = document.cookie.split(';');

            for (let i = 0; i < cookies.length; i++) {
                let cookie = cookies[i];

                while (cookie.charAt(0) === ' ') {
                    cookie = cookie.substring(1, cookie.length);
                }

                if (cookie.indexOf(nameEQ) === 0) {
                    return decodeURIComponent(cookie.substring(nameEQ.length, cookie.length));
                }
            }

            return null;
        }

        function deleteCookie(name) {
            document.cookie = name + '=; Max-Age=-99999999; path=/';
        }

        function applyThemeBeforeLoad() {
            const theme = getCookie('bella_theme') || 'light';
            const fontSize = getCookie('bella_font_size') || 'normal';
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (theme === 'dark' || (theme === 'system' && systemDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            document.documentElement.setAttribute('data-font-size', fontSize);
        }

        applyThemeBeforeLoad();
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bella Admin Management</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    @php
        $layoutUser = auth()->user();

        $layoutAvatar = $layoutUser && $layoutUser->avatar_path
            ? asset('storage/' . $layoutUser->avatar_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($layoutUser->name ?? 'Admin Bella') . '&background=ffe4e6&color=e11d48&size=100&bold=true';

        $layoutName = $layoutUser->name ?? 'Admin Bella';
    @endphp

    <script>
        window.bellaProfileData = {
            name: @json($layoutName),
            avatar: @json($layoutAvatar)
        };
    </script>

    <style>
        :root {
            --primary: #f43f5e;
            --primary-hover: #e11d48;
            --primary-light: #fff1f2;
            --bg-body: #FADCE9;
            --white: #ffffff;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #f43f5e;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        html.dark {
            --bg-body: #0f172a;
            --white: #1e293b;
            --slate-50: #334155;
            --slate-100: #475569;
            --slate-200: #64748b;
            --slate-400: #cbd5e1;
            --slate-500: #e2e8f0;
            --slate-600: #f1f5f9;
            --slate-700: #f8fafc;
            --slate-800: #f8fafc;
            --slate-900: #ffffff;
            --primary-light: #3f1222;
        }

        html[data-font-size="small"] body {
            font-size: 14px;
        }

        html[data-font-size="normal"] body {
            font-size: 16px;
        }

        html[data-font-size="large"] body {
            font-size: 18px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--slate-800);
            -webkit-font-smoothing: antialiased;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            border: none;
            background: none;
            cursor: pointer;
            font-family: inherit;
        }

        input,
        select {
            font-family: inherit;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--slate-200);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--slate-400);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        html.dark .navbar {
            background-color: rgba(15, 23, 42, 0.85);
            border-bottom-color: rgba(100, 116, 139, 0.4);
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-text {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.5px;
        }

        .brand-text span {
            color: var(--primary);
        }

        .nav-links {
            display: none;
            align-items: center;
            gap: 8px;
        }

        @media (min-width: 768px) {
            .nav-links {
                display: flex;
            }
        }

        .nav-item {
            padding: 8px 4px;
            margin: 0 12px;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--slate-500);
            position: relative;
            transition: color 0.3s ease;
            background-color: transparent !important;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2.5px;
            bottom: -1px;
            left: 0;
            background-color: #9f1239;
            transition: width 0.3s ease-in-out;
            border-radius: 2px;
        }

        .nav-item:hover {
            color: var(--primary);
        }

        .nav-item:hover::after,
        .nav-item.active::after {
            width: 100%;
        }

        .nav-item.active {
            color: var(--primary);
        }

        .theme-toggle {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            background: var(--white);
            color: var(--primary);
            border: 1px solid #fbcfe8;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 800;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: #fff1f2;
            transform: translateY(-1px);
        }

        html.dark .theme-toggle {
            background: #334155;
            color: #fda4af;
            border-color: #475569;
        }

        .nav-profile {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .profile-info {
            display: none;
            flex-direction: column;
            align-items: flex-end;
        }

        @media (min-width: 640px) {
            .profile-info {
                display: flex;
            }
        }

        .profile-name {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--slate-900);
            line-height: 1;
            margin-bottom: 4px;
        }

        .profile-role {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--slate-500);
        }

        .profile-img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: var(--shadow-sm);
            object-fit: cover;
            background-color: #fff1f2;
        }

        .main-content {
            padding: 40px 24px;
            min-height: calc(100vh - 80px - 90px);
        }

        .page-header {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 40px;
        }

        @media (min-width: 768px) {
            .page-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: flex-end;
            }
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            font-size: 1rem;
            color: var(--slate-500);
            font-weight: 500;
            margin-top: 4px;
        }

        .date-badge {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--slate-500);
            background-color: var(--white);
            padding: 8px 16px;
            border-radius: 12px;
            border: 1px solid var(--slate-200);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary {
            background-color: var(--slate-900);
            color: white;
            padding: 14px 24px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.1);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            box-shadow: 0 10px 15px -3px rgba(225, 29, 72, 0.2);
        }

        .btn-icon {
            padding: 10px;
            border-radius: 12px;
            background-color: var(--slate-50);
            color: var(--slate-400);
            transition: all 0.3s ease;
        }

        .btn-icon:hover {
            background-color: var(--slate-200);
            color: var(--slate-600);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            margin-bottom: 48px;
        }

        @media (min-width: 640px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .stat-card,
        .section-box,
        .widget-card,
        .filter-box,
        .card-katalog,
        .empty-state {
            background-color: var(--white);
            border: 1px solid var(--slate-100);
            box-shadow: var(--shadow-sm);
        }

        .stat-card {
            padding: 24px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
        }

        .stat-icon {
            padding: 12px;
            border-radius: 16px;
            background-color: var(--slate-50);
            color: var(--slate-600);
        }

        .stat-icon.alert {
            background-color: var(--primary-light);
            color: var(--primary-hover);
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--slate-400);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-value {
            font-size: 1.875rem;
            font-weight: 900;
            color: var(--slate-800);
            letter-spacing: -0.5px;
        }

        .section-box {
            padding: 32px;
            border-radius: 16px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--slate-900);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
        }

        @media (min-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .layout-wrapper {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        @media (min-width: 1024px) {
            .layout-wrapper {
                flex-direction: row;
            }
        }

        .sidebar {
            width: 100%;
            flex-shrink: 0;
        }

        @media (min-width: 1024px) {
            .sidebar {
                width: 280px;
            }
        }

        .filter-box {
            padding: 24px;
            border-radius: 32px;
            position: sticky;
            top: 112px;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .filter-title {
            font-weight: 800;
            color: var(--slate-900);
        }

        .btn-reset {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--slate-400);
        }

        .btn-reset:hover {
            color: var(--primary);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 900;
            color: var(--slate-400);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 12px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-400);
            width: 16px;
            height: 16px;
            transition: color 0.3s ease;
        }

        .form-input,
        .search-input,
        .preference-select {
            width: 100%;
            padding: 12px 16px;
            background: var(--slate-50);
            border: 1px solid var(--slate-200);
            border-radius: 16px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--slate-700);
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input {
            padding-left: 44px;
        }

        .form-input:focus,
        .search-input:focus,
        .preference-select:focus {
            background: var(--white);
            border-color: #fca5a5;
            box-shadow: 0 0 0 4px var(--primary-light);
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: var(--slate-50);
            border: 1px solid transparent;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox-item:hover {
            background: var(--primary-light);
            border-color: #ffe4e6;
        }

        .checkbox-item input {
            width: 20px;
            height: 20px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .checkbox-text {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--slate-600);
        }

        .filter-footer {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px dashed var(--slate-200);
            text-align: center;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--slate-500);
        }

        .list-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            flex-grow: 1;
        }

        @media (min-width: 768px) {
            .list-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1280px) {
            .list-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .card-katalog {
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .card-katalog:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(244, 63, 94, 0.1), 0 10px 10px -5px rgba(244, 63, 94, 0.04);
        }

        .card-katalog-header {
            background-color: #f472b6;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-katalog-code {
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            letter-spacing: 0.5px;
        }

        .card-katalog-badge {
            background-color: white;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: capitalize;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .card-katalog-badge.tersedia {
            color: #10b981;
        }

        .card-katalog-badge.menipis {
            color: #f43f5e;
        }

        .card-katalog-body {
            padding: 16px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-katalog-img {
            width: 100%;
            aspect-ratio: 4/3;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 16px;
            background-color: var(--slate-50);
        }

        .card-katalog-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--slate-800);
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .card-katalog-meta {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .meta-text {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--slate-500);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-katalog-footer {
            padding: 14px;
            text-align: center;
            background-color: var(--primary-light);
        }

        .card-katalog-price {
            font-size: 1.05rem;
            font-weight: 800;
            color: #f43f5e;
        }

        .btn-outline-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 24px;
            border: 1px solid #f472b6;
            color: #f43f5e;
            font-weight: 700;
            font-size: 0.875rem;
            border-radius: 9999px;
            transition: all 0.3s ease;
            background-color: transparent;
        }

        .btn-outline-primary:hover {
            background-color: #fff1f2;
        }

        html.dark .btn-outline-primary:hover {
            background-color: #334155;
        }

        .empty-state {
            border-radius: 32px;
            padding: 48px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--slate-500);
        }

        .empty-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--slate-900);
            margin-bottom: 4px;
        }

        .toast-notification {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: var(--white);
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
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

        .toast-icon {
            color: var(--success);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toast-content {
            flex-grow: 1;
        }

        .toast-title {
            font-weight: 800;
            color: var(--slate-900);
            font-size: 0.875rem;
            margin-bottom: 2px;
        }

        .toast-message {
            font-weight: 600;
            color: var(--slate-500);
            font-size: 0.75rem;
        }

        .toast-close {
            color: var(--slate-400);
            background: none;
            padding: 4px;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .toast-close:hover {
            background-color: var(--slate-100);
            color: var(--slate-900);
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background-color: var(--success);
            animation: progressShrink 3s linear forwards;
        }

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

        .site-footer {
            border-top: 1px solid rgba(226, 232, 240, 0.6);
            padding: 24px 0;
            margin-top: 40px;
            background-color: var(--white);
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
    </style>
</head>

<body>
    @include('partials.navbar')

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

    <footer class="site-footer">
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
        function applyTheme() {
            const theme = getCookie('bella_theme') || 'light';
            const fontSize = getCookie('bella_font_size') || 'normal';
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (theme === 'dark' || (theme === 'system' && systemDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            document.documentElement.setAttribute('data-font-size', fontSize);

            const toggleText = document.getElementById('themeToggleText');
            const toggleIcon = document.getElementById('themeToggleIcon');

            if (toggleText && toggleIcon) {
                const isDark = document.documentElement.classList.contains('dark');

                toggleText.textContent = isDark ? 'Light' : 'Dark';
                toggleIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');

                if (window.lucide) {
                    lucide.createIcons();
                }
            }
        }

        function closeToast() {
            const toast = document.getElementById('toast-success');

            if (toast) {
                toast.classList.add('hide');

                setTimeout(() => {
                    toast.remove();
                }, 500);
            }
        }

        function updateNavbarProfileFromDatabase() {
            const profileData = window.bellaProfileData || {};

            const navAvatar = document.querySelector('.profile-img');
            const navName = document.querySelector('.profile-name');

            if (navAvatar && profileData.avatar) {
                navAvatar.src = profileData.avatar;
                navAvatar.alt = profileData.name || 'Profile';
            }

            if (navName && profileData.name) {
                navName.textContent = profileData.name;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                lucide.createIcons();
            }

            applyTheme();
            updateNavbarProfileFromDatabase();

            const toast = document.getElementById('toast-success');

            if (toast) {
                setTimeout(() => {
                    closeToast();
                }, 3000);
            }
        });

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
            if ((getCookie('bella_theme') || 'light') === 'system') {
                applyTheme();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>