@extends('layouts.app')

@section('content')

<style>
    .dashboard-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
        align-items: start;
    }

    @media (min-width: 1024px) {
        .dashboard-layout {
            grid-template-columns: 2.5fr 1fr;
        }

        .dashboard-layout .product-grid {
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 20px;
        }
    }

    .widget-stack {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .widget-card {
        background-color: var(--white);
        padding: 24px;
        border-radius: 16px;
        border: 1px solid var(--slate-100);
        box-shadow: var(--shadow-sm);
    }

    .widget-title {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 20px;
    }

    .api-loading {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--slate-500);
        font-weight: 700;
    }

    .api-spinner {
        width: 18px;
        height: 18px;
        border: 3px solid var(--slate-200);
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .api-error {
        display: none;
        color: #e11d48;
        font-weight: 700;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .api-product-list {
        display: none;
        flex-direction: column;
        gap: 14px;
    }

    .api-product-card {
        display: flex;
        gap: 14px;
        background: var(--slate-50);
        border: 1px solid var(--slate-100);
        border-radius: 16px;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .api-product-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .api-product-img {
        width: 72px;
        height: 72px;
        border-radius: 14px;
        object-fit: cover;
        background: var(--white);
        flex-shrink: 0;
    }

    .api-product-info {
        flex: 1;
        min-width: 0;
    }

    .api-product-name {
        font-size: 0.9rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .api-product-desc {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--slate-500);
        line-height: 1.4;
        margin-bottom: 8px;
    }

    .api-product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }

    .api-product-category {
        font-size: 0.68rem;
        font-weight: 900;
        text-transform: uppercase;
        background: #ffe4e6;
        color: #e11d48;
        padding: 4px 8px;
        border-radius: 999px;
    }

    .api-product-price {
        font-size: 0.8rem;
        font-weight: 900;
        color: var(--primary);
        white-space: nowrap;
    }

    html.dark .api-product-category {
        background: #3f1222;
        color: #fda4af;
    }

    .api-note {
        margin-top: 14px;
        color: var(--slate-500);
        font-size: 0.82rem;
        font-weight: 600;
        line-height: 1.5;
    }

    .visit-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .visit-item {
        background: var(--slate-50);
        border-radius: 14px;
        padding: 14px;
    }

    .visit-label {
        font-size: 0.7rem;
        font-weight: 900;
        color: var(--slate-400);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }

    .visit-value {
        color: var(--slate-900);
        font-weight: 900;
        font-size: 0.95rem;
    }

    .btn-reset-session {
        width: 100%;
        padding: 12px;
        background: #ffe4e6;
        color: #e11d48;
        border-radius: 14px;
        font-weight: 900;
        margin-top: 16px;
        transition: all 0.3s ease;
    }

    .btn-reset-session:hover {
        background: #fecdd3;
    }

    html.dark .btn-reset-session {
        background: #3f1222;
        color: #fda4af;
    }

    .terlaris-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .terlaris-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--slate-700);
    }

    .terlaris-item:nth-child(odd) {
        background-color: #fce7f3;
    }

    .terlaris-item:nth-child(even) {
        background-color: #fdf2f8;
    }

    html.dark .terlaris-item:nth-child(odd),
    html.dark .terlaris-item:nth-child(even) {
        background-color: var(--slate-50);
    }

    .table-riwayat {
        width: 100%;
        border-collapse: collapse;
    }

    .table-riwayat td {
        padding: 12px 0;
        font-size: 0.875rem;
        border-bottom: 1px solid var(--slate-100);
    }

    .table-riwayat tr:last-child td {
        border-bottom: none;
    }

    .status-label {
        font-weight: 700;
        text-align: right;
    }

    .status-success {
        color: var(--success);
    }

    .status-warning {
        color: var(--warning);
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Overview</h1>
        <p class="page-subtitle">Ringkasan performa Bella Bouquet</p>
    </div>

    <div class="date-badge">
        {{ now()->translatedFormat('l, d F Y') }}
    </div>
</div>

<div class="stats-grid">
    @forelse($stats as $stat)
        <x-stat-card
            :judul="$stat['label']"
            :nilai="$stat['value']"
            :ikon="$stat['icon']"
            :warna="isset($stat['alert']) ? 'merah' : ''"
        />
    @empty
        <p>Belum ada data statistik.</p>
    @endforelse
</div>

<div class="dashboard-layout">
    <div class="section-box" style="padding: 24px;">
        <div class="section-header" style="margin-bottom: 24px;">
            <h2 class="section-title" style="color: #f43f5e; font-size: 1.25rem;">
                Katalog Produk Tersedia
            </h2>
        </div>

        <div class="product-grid">
            @forelse($recentProducts as $product)
                <div class="card-katalog">
                    <div class="card-katalog-header" style="background-color: {{ $product->status == 'Menipis' ? '#f43f5e' : '#f472b6' }};">
                        <div class="card-katalog-code">
                            <i data-lucide="flower" style="width: 14px; color: rgba(255,255,255,0.8);"></i>
                            {{ $product->kode_produk }}
                        </div>

                        <div class="card-katalog-badge {{ $product->status == 'Tersedia' ? 'tersedia' : 'menipis' }}">
                            {{ $product->status }}
                        </div>
                    </div>

                    <div class="card-katalog-body">
                        @if($product->gambar_url)
                            <img
                                src="{{ str_starts_with($product->gambar_url, 'http') ? $product->gambar_url : asset('storage/' . $product->gambar_url) }}"
                                alt="{{ $product->nama }}"
                                class="card-katalog-img"
                            >
                        @else
                            <div class="card-katalog-img" style="display:flex; align-items:center; justify-content:center; color:var(--slate-400); background:var(--slate-50);">
                                No Image
                            </div>
                        @endif

                        <h3 class="card-katalog-title">{{ $product->nama }}</h3>

                        <div class="card-katalog-meta">
                            <div class="meta-text">
                                <i data-lucide="pin" style="width: 14px; color: #f472b6;"></i>
                                Kat: {{ $product->kategori }}
                            </div>

                            <div class="meta-text">
                                <i data-lucide="box" style="width: 14px; color: #a1a1aa;"></i>
                                Stok: {{ $product->stok }} unit
                            </div>
                        </div>
                    </div>

                    <div class="card-katalog-footer">
                        <span class="card-katalog-price">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1;">
                    <h3 class="empty-title">Belum ada produk</h3>
                    <p>Silakan tambahkan produk bouquet terlebih dahulu.</p>
                </div>
            @endforelse
        </div>

        <div style="text-align: center; margin-top: 32px;">
            <a href="{{ route('produk.index') }}" class="btn-outline-primary">
                Lihat Semua Produk
                <i data-lucide="arrow-down" style="width: 16px; height: 16px;"></i>
            </a>
        </div>
    </div>

    <div class="widget-stack">
        <div class="widget-card">
            <h3 class="widget-title">Referensi Pewangi Bouquet</h3>

            <div id="apiLoading" class="api-loading">
                <span class="api-spinner"></span>
                <span>Mengambil referensi aroma pewangi bouquet...</span>
            </div>

            <div id="apiProductList" class="api-product-list"></div>

            <div id="apiError" class="api-error">
                Gagal mengambil data referensi pewangi bouquet dari API publik.
            </div>

            <p class="api-note">
                Rekomendasi aroma ini membantu admin memilih pewangi yang sesuai untuk setiap bouquet,sehingga produk terasa lebih segar, menarik, dan memberikan kesan premium saat diterima pelanggan.
            </p>
        </div>
    </div>

        <div class="widget-card">
            <h3 class="widget-title">Kunjungan Dashboard</h3>

            <div class="visit-grid">
                <div class="visit-item">
                    <div class="visit-label">Jumlah Kunjungan</div>
                    <div class="visit-value">{{ $visitData['count'] }} kali</div>
                </div>

                <div class="visit-item">
                    <div class="visit-label">Kunjungan Pertama</div>
                    <div class="visit-value">{{ $visitData['first'] }}</div>
                </div>

                <div class="visit-item">
                    <div class="visit-label">Kunjungan Terakhir</div>
                    <div class="visit-value">{{ $visitData['last'] }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('dashboard.resetKunjungan') }}">
                @csrf
                <button type="submit" class="btn-reset-session">
                    Reset Hitungan
                </button>
            </form>
        </div>

        <div class="widget-card">
            <h3 class="widget-title">5 Produk Terlaris</h3>

            @php
                $produkTerlaris = [
                    ['nama' => '1. Bouquet Flower', 'terjual' => '45 Terjual'],
                    ['nama' => '2. Bouquet Snack', 'terjual' => '32 Terjual'],
                    ['nama' => '3. Money Bouquet 100k', 'terjual' => '28 Terjual'],
                    ['nama' => '4. Doll Bouquet', 'terjual' => '15 Terjual'],
                    ['nama' => '5. Cake and Flowers', 'terjual' => '10 Terjual'],
                ];
            @endphp

            <div class="terlaris-list">
                @foreach($produkTerlaris as $item)
                    <div class="terlaris-item">
                        <span>{{ $item['nama'] }}</span>
                        <span style="font-weight: 800; color: var(--slate-900);">
                            {{ $item['terjual'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="widget-card">
            <h3 class="widget-title">Riwayat Pesanan Terakhir</h3>

            @php
                $riwayatPesanan = [
                    ['inv' => '#INV-001', 'nama' => 'Budi S.', 'status' => 'Selesai'],
                    ['inv' => '#INV-002', 'nama' => 'Siti A.', 'status' => 'Selesai'],
                    ['inv' => '#INV-003', 'nama' => 'Andi D.', 'status' => 'Proses'],
                    ['inv' => '#INV-004', 'nama' => 'Rina K.', 'status' => 'Selesai'],
                    ['inv' => '#INV-005', 'nama' => 'Fajar R.', 'status' => 'Proses'],
                ];
            @endphp

            <table class="table-riwayat">
                <tbody>
                    @foreach($riwayatPesanan as $pesanan)
                        <tr>
                            <td style="color: var(--slate-500); font-weight: 600;">
                                {{ $pesanan['inv'] }}
                            </td>

                            <td style="color: var(--slate-700); font-weight: 600;">
                                {{ $pesanan['nama'] }}
                            </td>

                            <td class="status-label {{ $pesanan['status'] === 'Selesai' ? 'status-success' : 'status-warning' }}">
                                {{ $pesanan['status'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function getInspirasiBouquet() {
        const loading = document.getElementById('apiLoading');
        const list = document.getElementById('apiProductList');
        const errorBox = document.getElementById('apiError');

        try {
            loading.style.display = 'flex';
            list.style.display = 'none';
            errorBox.style.display = 'none';

            const response = await fetch('https://dummyjson.com/products/category/fragrances?limit=3');

            if (!response.ok) {
                throw new Error('API tidak merespon dengan benar');
            }

            const data = await response.json();

            list.innerHTML = '';

            data.products.forEach(function (product) {
                const estimasiRupiah = Math.round(product.price * 16000);

                list.innerHTML += `
                    <div class="api-product-card">
                        <img
                            src="${product.thumbnail}"
                            alt="${escapeHtml(product.title)}"
                            class="api-product-img"
                        >

                        <div class="api-product-info">
                            <div class="api-product-name">
                                ${escapeHtml(product.title)}
                            </div>

                            <div class="api-product-desc">
                                ${escapeHtml(product.description.substring(0, 85))}...
                            </div>

                            <div class="api-product-footer">
                                <span class="api-product-category">
                                    ${escapeHtml(product.category)}
                                </span>

                                <span class="api-product-price">
                                    ± Rp ${estimasiRupiah.toLocaleString('id-ID')}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
            });

            loading.style.display = 'none';
            list.style.display = 'flex';

            if (window.lucide) {
                lucide.createIcons();
            }
        } catch (error) {
            loading.style.display = 'none';
            errorBox.style.display = 'block';
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    document.addEventListener('DOMContentLoaded', getInspirasiBouquet);
</script>
@endpush