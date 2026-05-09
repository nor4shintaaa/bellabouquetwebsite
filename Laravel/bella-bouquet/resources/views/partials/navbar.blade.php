<nav class="navbar">
    <div class="container nav-content">
        <div class="nav-brand">
            <span class="brand-text">Bella<span>Admin</span></span>
        </div>

        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('produk.index') }}" class="nav-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                Daftar Produk
            </a>
            <a href="{{ route('tentang') }}" class="nav-item {{ request()->routeIs('tentang') ? 'active' : '' }}">
                Tentang
            </a>
            <a href="{{ route('kontak') }}" class="nav-item {{ request()->routeIs('kontak') ? 'active' : '' }}">
                Kontak
            </a>
        </div>

        <div style="position: relative;" id="profileContainer">
            {{-- Perbaikan: Hanya tampilkan profil jika user sudah login --}}
            @auth
                <div class="nav-profile" style="cursor: pointer; transition: opacity 0.2s ease;" onclick="toggleDropdown()">
                    <div class="profile-info">
                        <span class="profile-name">{{ auth()->user()->name }}</span>
                        <span class="profile-role">Owner</span>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=ffe4e6&color=e11d48&bold=true" 
                         class="profile-img" 
                         id="navAvatarImg" 
                         alt="Admin">
                </div>

                <div id="logoutDropdown" style="display: none; position: absolute; top: 110%; right: 0; background: white; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 200px; z-index: 1000; border: 1px solid #f1f5f9; overflow: hidden;">
                    <a href="{{ route('profil') }}" style="display: flex; align-items: center; gap: 10px; padding: 14px 20px; color: #475569; text-decoration: none; font-size: 0.9rem; font-weight: 600; transition: background 0.2s;">
                        <i data-lucide="user" style="width: 16px;"></i> Pengaturan Profil
                    </a>
                    
                    <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 0;">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="display: flex; align-items: center; gap: 10px; padding: 14px 20px; color: #e11d48; background: none; border: none; width: 100%; text-align: left; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: background 0.2s;">
                            <i data-lucide="log-out" style="width: 16px;"></i> Logout Akun
                        </button>
                    </form>
                </div>
            @else
                {{-- Tampilkan tombol Login jika belum login --}}
                <a href="{{ route('login') }}" class="nav-item">Login</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    // Fungsi Toggle Dropdown
    function toggleDropdown() {
        const dropdown = document.getElementById('logoutDropdown');
        if(dropdown) {
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
    }

    // Klik di luar untuk menutup
    window.addEventListener('click', function(e) {
        const container = document.getElementById('profileContainer');
        const dropdown = document.getElementById('logoutDropdown');
        if (dropdown && container && !container.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    // Support LocalStorage untuk foto profil agar sinkron di semua halaman
    document.addEventListener('DOMContentLoaded', function() {
        const savedAvatar = localStorage.getItem('adminAvatar');
        if (savedAvatar) {
            const navImg = document.getElementById('navAvatarImg');
            if (navImg) navImg.src = savedAvatar;
        }
    });
</script>