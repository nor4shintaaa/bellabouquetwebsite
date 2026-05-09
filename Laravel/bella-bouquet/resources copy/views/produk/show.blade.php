@extends('layouts.app')

@section('content')
<div class="page-header" style="max-width: 900px; margin: 0 auto 32px auto;">
    <h1 class="page-title">Detail Produk</h1>
</div>

<div class="section-box" style="max-width: 900px; margin: 0 auto; display: grid; grid-template-columns: 1fr; gap: 40px; padding: 40px;">
    @media (min-width: 768px) {
        <style> .detail-grid { grid-template-columns: 1fr 1fr !important; } </style>
    }
    <div class="detail-grid" style="display: grid; grid-template-columns: 1fr; gap: 40px;">
        
        <div>
            @if($produk->gambar_url)
                <img src="{{ str_starts_with($produk->gambar_url, 'http') ? $produk->gambar_url : asset('storage/' . $produk->gambar_url) }}" 
                     style="width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: 16px; box-shadow: var(--shadow-sm);">
            @else
                <div style="width: 100%; aspect-ratio: 4/3; background: var(--slate-100); border-radius: 16px; display:flex; align-items:center; justify-content:center; color: var(--slate-400);">
                    Belum ada foto
                </div>
            @endif
        </div>

        <div>
            <div style="display: inline-block; padding: 6px 12px; background: var(--slate-100); border-radius: 8px; font-size: 0.75rem; font-weight: 800; color: var(--slate-600); letter-spacing: 1px; margin-bottom: 12px;">
                {{ $produk->kode_produk }}
            </div>
            
            <h1 style="font-size: 2.25rem; font-weight: 800; color: var(--slate-900); margin-bottom: 12px; line-height: 1.2;">
                {{ $produk->nama }}
            </h1>
            
            <p style="font-size: 1.75rem; color: #f43f5e; font-weight: 800; margin-bottom: 32px;">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </p>
            
            <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 40px;">
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--slate-100); padding-bottom: 12px;">
                    <span style="color: var(--slate-500); font-weight: 600;">Kategori</span>
                    <span style="font-weight: 800; color: var(--slate-800);">{{ $produk->kategori }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--slate-100); padding-bottom: 12px;">
                    <span style="color: var(--slate-500); font-weight: 600;">Status Persediaan</span>
                    <style>
        @media (min-width: 768px) {
            .detail-grid { grid-template-columns: 1fr 1fr !important; }
        }
    </style>
                        {{ $produk->status }} (Tersisa {{ $produk->stok }} Unit)
                    </span>
                </div>
            </div>

            <div style="display: flex; gap: 16px;">
                <a href="{{ route('produk.index') }}" style="padding: 12px 24px; background: var(--slate-100); color: var(--slate-700); font-weight: 700; border-radius: 12px; flex-grow: 1; text-align: center;">
                    Kembali
                </a>
                <a href="{{ route('produk.edit', $produk->id) }}" style="padding: 12px 24px; background: #9f1239; color: white; font-weight: 700; border-radius: 12px; flex-grow: 1; text-align: center;">
                    Edit Data
                </a>
            </div>
        </div>
    </div>
</div>
@endsection