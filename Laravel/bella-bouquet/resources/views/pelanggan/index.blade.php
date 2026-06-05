@extends('layouts.pelanggan')

@section('title', 'Beranda')

@section('content')
<section class="hero">
    <div class="container hero-grid">
        <div>
            @auth
                @if(auth()->user()->role === 'pelanggan')
                    <span class="hero-label">Halo, {{ auth()->user()->name }}</span>
                @elseif(auth()->user()->role === 'admin')
                    <span class="hero-label">Admin sedang login</span>
                @endif
            @else
                <span class="hero-label">Selamat datang di Bella Bouquet</span>
            @endauth

            <h1 class="hero-title">
                Pesan <span>Bouquet Cantik</span> untuk Momen Spesialmu
            </h1>

            <p class="hero-desc">
                Bella Bouquet menyediakan berbagai pilihan bouquet yang manis, rapi,
                dan cocok untuk hadiah wisuda, ulang tahun, anniversary, maupun momen spesial lainnya.
                Kamu bisa melihat produk tanpa login, tetapi harus login terlebih dahulu untuk membuat pesanan.
            </p>

            <div class="hero-actions">
                <a href="{{ route('pelanggan.produk') }}" class="btn-primary">Lihat Produk</a>

                @guest
                    <a href="{{ route('login') }}" class="btn-secondary">Login untuk Pesan</a>
                @else
                    @if(auth()->user()->role === 'pelanggan')
                        <a href="{{ route('pelanggan.status') }}" class="btn-secondary">Cek Status Pesanan</a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="btn-secondary">Dashboard Admin</a>
                    @endif
                @endguest
            </div>
        </div>

        <div class="hero-card">
            <h3>Cara Pemesanan</h3>

            <div class="hero-list">
                <div class="hero-list-item">
                    <div class="hero-number">1</div>
                    <div>
                        <strong>Lihat Produk</strong>
                        <p>Semua pengunjung bisa melihat katalog bouquet yang tersedia.</p>
                    </div>
                </div>

                <div class="hero-list-item">
                    <div class="hero-number">2</div>
                    <div>
                        <strong>Login Pelanggan</strong>
                        <p>Login diperlukan ketika pelanggan ingin membuat pesanan.</p>
                    </div>
                </div>

                <div class="hero-list-item">
                    <div class="hero-number">3</div>
                    <div>
                        <strong>Buat Pesanan</strong>
                        <p>Pilih produk, isi jumlah, tanggal, dan catatan request bouquet.</p>
                    </div>
                </div>

                <div class="hero-list-item">
                    <div class="hero-number">4</div>
                    <div>
                        <strong>Cek Status</strong>
                        <p>Status pesanan dapat dipantau setelah pelanggan login.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(auth()->check() && auth()->user()->role === 'pelanggan' && isset($pesananAktif) && $pesananAktif->count())
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Pesanan Aktif Kamu</h2>
            <p>Berikut beberapa pesanan terbaru yang sedang berjalan.</p>
        </div>

        <div class="order-grid">
            @foreach($pesananAktif as $order)
                <div class="order-card">
                    <div class="order-card-header">
                        @if($order->product_image)
                            <img class="order-image" src="{{ str_starts_with($order->product_image, 'http') ? $order->product_image : asset('storage/' . $order->product_image) }}" alt="{{ $order->product_name }}">
                        @else
                            <div class="order-image" style="display:grid;place-items:center;">💐</div>
                        @endif

                        <div>
                            <h3 class="order-title">{{ $order->product_name }}</h3>
                            <div class="order-code">{{ $order->order_code }}</div>
                            <span class="badge-status {{ $order->status_class }}">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="order-actions">
                        <a href="{{ route('pelanggan.pesanan.show', $order) }}" class="btn-secondary">Detail</a>

                        @if($order->canUploadPayment())
                            <a href="{{ route('pelanggan.bayar', $order) }}" class="btn-primary">Bayar</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Produk Unggulan</h2>
            <p>Produk yang tampil di sini diambil langsung dari data produk yang dikelola oleh admin.</p>
        </div>

        @if($produkUnggulan->count())
            <div class="product-grid">
                @foreach($produkUnggulan as $item)
                    <article class="product-card">
                        <div class="product-image">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->nama }}">
                            @else
                                <div class="product-placeholder">💐</div>
                            @endif
                        </div>

                        <div class="product-content">
                            <span class="product-category">{{ $item->kategori }}</span>
                            <h3 class="product-title">{{ $item->nama }}</h3>
                            <p class="product-meta">Stok tersedia: {{ $item->stok }}</p>

                            <div class="product-price">
                                Rp{{ number_format($item->harga, 0, ',', '.') }}
                            </div>

                            <div class="product-actions">
                                <a href="{{ route('pelanggan.produk.show', $item) }}" class="btn-secondary">Detail</a>
                                <a href="{{ route('pelanggan.pesan', $item) }}" class="btn-primary">Pesan</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="text-align:center; margin-top:34px;">
                <a href="{{ route('pelanggan.produk') }}" class="btn-secondary">
                    Lihat Semua Produk
                </a>
            </div>
        @else
            <div class="empty-state">
                <h3>Belum ada produk</h3>
                <p>Produk akan tampil setelah admin menambahkan data produk.</p>
            </div>
        @endif
    </div>
</section>

<section class="section" id="tentang">
    <div class="container">
        <div class="section-header">
            <h2>Tentang Bella Bouquet</h2>
            <p>Informasi ini dikelola langsung oleh admin melalui halaman pengaturan tentang.</p>
        </div>

        <div class="about-admin-grid">
            <div class="about-text-card">
                <h3>Bella Bouquet</h3>

                <p>
                    {{ $siteSetting->about_description ?? 'Bella Bouquet adalah layanan pemesanan bouquet yang membantu pelanggan memilih hadiah cantik dengan proses pemesanan yang mudah dan praktis.' }}
                </p>

                <div class="about-mini-grid">
                    <div class="about-mini-card">
                        <h4>Visi</h4>
                        <p>{{ $siteSetting->vision ?? '-' }}</p>
                    </div>

                    <div class="about-mini-card">
                        <h4>Misi</h4>
                        <p>{{ $siteSetting->mission ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="about-banner-card">
                @if(!empty($siteSetting?->banner_path))
                    <img src="{{ asset('storage/' . $siteSetting->banner_path) }}" alt="Tentang Bella Bouquet">
                @else
                    <div class="about-banner-placeholder">
                        <div>💐</div>
                        <strong>Bella Bouquet</strong>
                        <p style="color:#64748b;">Banner dapat diatur melalui dashboard admin.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="section" id="kontak">
    <div class="container">
        <div class="section-header">
            <h2>Kontak Kami</h2>
            <p>Data kontak ini terhubung dengan pengaturan kontak di dashboard admin.</p>
        </div>

        <div class="contact-admin-grid">
            <div class="customer-contact-card">
                <div class="contact-icon">☎</div>
                <h3>WhatsApp</h3>
                <a href="https://wa.me/62{{ preg_replace('/[^0-9]/', '', $siteSetting->whatsapp ?? '') }}" target="_blank">
                    +62 {{ $siteSetting->whatsapp ?? '8xxxxxxxxxx' }}
                </a>
            </div>

            <div class="customer-contact-card">
                <div class="contact-icon">✉</div>
                <h3>Email</h3>
                <a href="mailto:{{ $siteSetting->email ?? 'bellabouquet@gmail.com' }}">
                    {{ $siteSetting->email ?? 'bellabouquet@gmail.com' }}
                </a>
            </div>

            <div class="customer-contact-card">
                <div class="contact-icon">📍</div>
                <h3>Alamat</h3>
                <p>{{ $siteSetting->address ?? 'Jember, Jawa Timur' }}</p>
            </div>

            <div class="customer-contact-card">
                <div class="contact-icon">📱</div>
                <h3>Sosial Media</h3>
                <p>{{ $siteSetting->instagram ?? '@bellabouquet' }}</p>
                <p>{{ $siteSetting->tiktok ?? '@bellabouquet.official' }}</p>
            </div>
        </div>
    </div>
</section>
@endsection