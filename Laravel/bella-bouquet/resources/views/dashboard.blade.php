@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Overview</h1>
        <p class="page-subtitle">Pantau performa bisnis buket Anda hari ini.</p>
    </div>
    <div class="date-badge">
        {{ now()->translatedFormat('l, d F Y') }}
    </div>
</div>

<div class="stats-grid">
    @foreach($stats as $stat)
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon {{ isset($stat['alert']) ? 'alert' : '' }}">
                <i data-lucide="{{ $stat['icon'] }}"></i>
            </div>
            <p class="stat-label">{{ $stat['label'] }}</p>
        </div>
        <h3 class="stat-value">{{ $stat['value'] }}</h3>
    </div>
    @endforeach
</div>

<div class="section-box">
    <div class="section-header">
        <h2 class="section-title">
            <div class="section-indicator"></div>
            Produk Terbaru
        </h2>
        <a href="{{ route('produk') }}" class="link-accent">
            Lihat Semua Katalog 
            <i data-lucide="arrow-right"></i>
        </a>
    </div>

    <div class="product-grid">
        @foreach($recentProducts as $product)
        <div class="product-card">
            <div class="product-img-wrapper">
                <img src="{{ $product->gambar_url }}" alt="{{ $product->nama }}" class="product-img">
                <div class="product-badges">
                    <span class="badge badge-glass">
                        {{ $product->kode_produk }}
                    </span>
                    <span class="badge {{ $product->status == 'Tersedia' ? 'badge-success' : 'badge-danger' }}">
                        {{ $product->status }}
                    </span>
                </div>
            </div>

            <div class="product-info">
                <div class="product-meta">
                    <span class="meta-item">
                        <i data-lucide="tag" class="rose" style="width: 12px; height: 12px;"></i> {{ $product->kategori }}
                    </span>
                    <span class="meta-item">
                        <i data-lucide="box" class="amber" style="width: 12px; height: 12px;"></i> {{ $product->stok }} Tersisa
                    </span>
                </div>
                
                <h3 class="product-name">{{ $product->nama }}</h3>
                
                <div class="product-footer">
                    <span class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    <button class="btn-icon">
                        <i data-lucide="more-vertical"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection