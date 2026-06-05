@extends('layouts.pelanggan')

@section('title', 'Detail Produk')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Detail Produk</h1>
        <p>Lihat informasi produk sebelum membuat pesanan.</p>
    </div>
</section>

<section class="section">
    <div class="container detail-grid">
        <div class="detail-image">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->nama }}">
            @else
                <div class="product-placeholder">💐</div>
            @endif
        </div>

        <div class="detail-content">
            <span class="product-category">{{ $product->kategori }}</span>

            <h1>{{ $product->nama }}</h1>

            <div class="detail-price">
                Rp{{ number_format($product->harga, 0, ',', '.') }}
            </div>

            <p>
                Produk bouquet kategori {{ $product->kategori }} yang tersedia di Bella Bouquet.
                Pengunjung dapat melihat detail produk ini tanpa login, tetapi harus login sebagai pelanggan untuk membuat pesanan.
            </p>

            <div class="detail-info">
                <div>
                    <strong>Kode Produk:</strong> {{ $product->kode_produk }}
                </div>

                <div>
                    <strong>Stok:</strong> {{ $product->stok }}
                </div>

                <div>
                    <strong>Status Produk:</strong> {{ $product->status }}
                </div>
            </div>

            <div class="hero-actions">
                <a href="{{ route('pelanggan.produk') }}" class="btn-secondary">
                    Kembali
                </a>

                @if($product->stok > 0 && $product->is_active)
                    <a href="{{ route('pelanggan.pesan', $product) }}" class="btn-primary">
                        Pesan Sekarang
                    </a>
                @else
                    <span class="btn-outline">
                        Stok Habis
                    </span>
                @endif
            </div>

            @guest
                <div class="summary-box" style="margin-top: 22px;">
                    <strong>Catatan:</strong>
                    Kamu akan diarahkan ke halaman login terlebih dahulu saat membuat pesanan.
                </div>
            @endguest
        </div>
    </div>
</section>
@endsection