<nav class="customer-navbar">
    <div class="nav-container">
        <a href="{{ route('pelanggan.index') }}" class="brand">
            Bella<span>Bouquet</span>
        </a>

        <button class="nav-toggle" type="button" id="customerNavToggle">
            ☰
        </button>

        <div class="nav-menu" id="customerNavMenu">
            <a href="{{ route('pelanggan.index') }}" class="{{ request()->routeIs('pelanggan.index') || request()->routeIs('landing') ? 'active' : '' }}">
                Beranda
            </a>

            <a href="{{ route('pelanggan.produk') }}" class="{{ request()->routeIs('pelanggan.produk*') ? 'active' : '' }}">
                Produk
            </a>

            <a href="{{ route('pelanggan.index') }}#tentang">
                Tentang
            </a>

            <a href="{{ route('pelanggan.index') }}#kontak">
                Kontak
            </a>

            @auth
                @if(auth()->user()->role === 'pelanggan')
                    <a href="{{ route('pelanggan.status') }}" class="{{ request()->routeIs('pelanggan.status') ? 'active' : '' }}">
                        Status
                    </a>

                    <a href="{{ route('pelanggan.riwayat') }}" class="{{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}">
                        Riwayat
                    </a>

                    <a href="{{ route('pelanggan.profil') }}" class="{{ request()->routeIs('pelanggan.profil') ? 'active' : '' }}">
                        Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('dashboard') }}" class="btn-login-nav">
                        Dashboard Admin
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-login-nav">
                    Login
                </a>

                <a href="{{ route('register') }}" class="btn-register-nav">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>