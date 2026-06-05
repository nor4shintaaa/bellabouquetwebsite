@extends('layouts.pelanggan')

@section('title', 'Produk')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Katalog Produk</h1>
        <p>Semua pengunjung dapat melihat produk. Untuk membuat pesanan, silakan login sebagai pelanggan terlebih dahulu.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="filter-card">
            <form method="GET" action="{{ route('pelanggan.produk') }}" class="filter-form">
                <input
                    type="text"
                    name="search"
                    class="form-input"
                    placeholder="Cari produk bouquet..."
                    value="{{ request('search') }}"
                >

                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-primary">Cari</button>
            </form>
        </div>

        @if($produk->count())
            <div class="product-grid">
                @foreach($produk as $item)
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

                                <a href="{{ route('pelanggan.pesan', $item) }}" class="btn-primary">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>Produk tidak ditemukan</h3>
                <p>Coba gunakan kata kunci lain atau hapus filter kategori.</p>
            </div>
        @endif
    </div>
</section>
@endsection