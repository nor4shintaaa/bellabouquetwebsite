@extends('layouts.app')

@section('content')

<style>
    .dashboard-layout { display: grid; grid-template-columns: 1fr; gap: 32px; align-items: start; }
    @media (min-width: 1024px) {
        .dashboard-layout { grid-template-columns: 2.5fr 1fr; }
        .dashboard-layout .product-grid { grid-template-columns: repeat(3, 1fr) !important; gap: 20px; }
    }
    .widget-stack { display: flex; flex-direction: column; gap: 24px; }
    .widget-card { background-color: var(--white); padding: 24px; border-radius: 16px; border: 1px solid var(--slate-100); box-shadow: var(--shadow-sm); }
    .widget-title { font-size: 1.125rem; font-weight: 800; color: var(--primary); margin-bottom: 20px; }
    .terlaris-list { display: flex; flex-direction: column; gap: 8px; }
    .terlaris-item { display: flex; justify-content: space-between; padding: 12px 16px; border-radius: 12px; font-size: 0.875rem; font-weight: 600; color: var(--slate-700); }
    .terlaris-item:nth-child(odd) { background-color: #fce7f3; } 
    .terlaris-item:nth-child(even) { background-color: #fdf2f8; } 
    .table-riwayat { width: 100%; border-collapse: collapse; }
    .table-riwayat td { padding: 12px 0; font-size: 0.875rem; border-bottom: 1px solid var(--slate-100); }
    .table-riwayat tr:last-child td { border-bottom: none; }
    .status-label { font-weight: 700; text-align: right; }
    .status-success { color: var(--success); }
    .status-warning { color: var(--warning); }
    .btn-outline-primary { display: inline-flex; align-items: center; gap: 6px; padding: 10px 24px; border: 1px solid #f472b6; color: #f43f5e; font-weight: 700; font-size: 0.875rem; border-radius: 9999px; transition: all 0.3s ease; background-color: transparent; }
    .btn-outline-primary:hover { background-color: #fff1f2; }
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
        <x-stat-card :judul="$stat['label']" :nilai="$stat['value']" :ikon="$stat['icon']" :warna="isset($stat['alert']) ? 'merah' : ''" />
    @empty
        <p>Belum ada data statistik.</p>
    @endforelse
</div>

<div class="dashboard-layout">
    <div class="section-box" style="padding: 24px;">
        <div class="section-header" style="margin-bottom: 24px;">
            <h2 class="section-title" style="color: #f43f5e; font-size: 1.25rem;">Katalog Produk Tersedia</h2>
        </div>

        <div class="product-grid">
            @foreach($recentProducts as $product)
            <div class="card-katalog">
                <div class="card-katalog-header" @if($product->status == 'Menipis') style="background-color: #f43f5e;" @else style="background-color: #f472b6;" @endif>
                    <div class="card-katalog-code">
                        <i data-lucide="flower" style="width: 14px; color: rgba(255,255,255,0.8);"></i> {{ $product->kode_produk }}
                    </div>
                    <div class="card-katalog-badge {{ $product->status == 'Tersedia' ? 'tersedia' : 'menipis' }}">
                        {{ $product->status }}
                    </div>
                </div>

                <div class="card-katalog-body">
                    <img src="{{ str_starts_with($product->gambar_url, 'http') ? $product->gambar_url : asset('storage/' . $product->gambar_url) }}" alt="{{ $product->nama }}" class="card-katalog-img">
                    <h3 class="card-katalog-title">{{ $product->nama }}</h3>
                    <div class="card-katalog-meta">
                        <div class="meta-text"><i data-lucide="pin" style="width: 14px; color: #f472b6;"></i> Kat: {{ $product->kategori }}</div>
                        <div class="meta-text"><i data-lucide="box" style="width: 14px; color: #a1a1aa;"></i> Stok: {{ $product->stok }} unit</div>
                    </div>
                </div>

                <div class="card-katalog-footer">
                    <span class="card-katalog-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 32px;">
            <a href="{{ route('produk.index') }}" class="btn-outline-primary">
                Lihat Semua Produk <i data-lucide="arrow-down" style="width: 16px; height: 16px;"></i>
            </a>
        </div>
    </div>

    <div class="widget-stack">
        <div class="widget-card">
            <h3 class="widget-title">5 Produk Terlaris</h3>
            @php
                $produkTerlaris = [
                    ['nama' => '1. Bouquet Flower', 'terjual' => '45 Terjual'],
                    ['nama' => '2. Bouquet Snack', 'terjual' => '32 Terjual'],
                    ['nama' => '3. Money Bouquet 100k', 'terjual' => '28 Terjual'],
                    ['nama' => '4. Doll Bouquet', 'terjual' => '15 Terjual'],
                    ['nama' => '5. Cake and flowers', 'terjual' => '10 Terjual'],
                ];
            @endphp
            <div class="terlaris-list">
                @foreach($produkTerlaris as $item)
                <div class="terlaris-item">
                    <span>{{ $item['nama'] }}</span>
                    <span style="font-weight: 800; color: var(--slate-900);">{{ $item['terjual'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="widget-card">
            <h3 class="widget-title">Riwayat Pesanan Terakhir</h3>
            @php
                $riwayatPesanan = [
                    ['inv' => '#INV-001', 'nama' => 'Budi S.', 'status' => 'Selesai', 'warna' => 'var(--success)'],
                    ['inv' => '#INV-002', 'nama' => 'Siti A.', 'status' => 'Selesai', 'warna' => 'var(--success)'],
                    ['inv' => '#INV-003', 'nama' => 'Andi D.', 'status' => 'Proses', 'warna' => 'var(--warning)'],
                    ['inv' => '#INV-004', 'nama' => 'Rina K.', 'status' => 'Selesai', 'warna' => 'var(--success)'],
                    ['inv' => '#INV-005', 'nama' => 'Fajar R.', 'status' => 'Proses', 'warna' => 'var(--warning)'],
                ];
            @endphp
            <table class="table-riwayat">
                <tbody>
                    @foreach($riwayatPesanan as $pesanan)
                    <tr>
                        <td style="color: var(--slate-500); font-weight: 600;">{{ $pesanan['inv'] }}</td>
                        <td style="color: var(--slate-700); font-weight: 600;">{{ $pesanan['nama'] }}</td>
                        <td class="status-label {{ $pesanan['status'] === 'Selesai' ? 'status-success' : 'status-warning' }}">{{ $pesanan['status'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection