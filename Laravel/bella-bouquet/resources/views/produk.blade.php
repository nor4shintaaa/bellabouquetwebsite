@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Katalog Produk</h1>
        <p class="page-subtitle">Kelola inventaris dan variasi buket Anda.</p>
    </div>
    <a href="{{ route('produk.create') }}" class="btn-primary">
    <i data-lucide="plus" style="width: 20px; height: 20px;"></i> Tambah Produk Baru
</a>
</div>

<div class="layout-wrapper">
    <!-- @if(session('success'))
    <div style="background: var(--success); color: white; padding: 16px 24px; border-radius: 16px; margin-bottom: 24px; font-weight: 700; display: flex; align-items: center; gap: 12px; grid-column: 1 / -1;">
        <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
        {{ session('success') }}
    </div>
    @endif -->
    
    <aside class="sidebar">
        <div class="filter-box">
            <div class="filter-header">
                <h3 class="filter-title">Filter Data</h3>
                <a href="{{ route('produk') }}" class="btn-reset" style="text-decoration: none;">Reset</a>
            </div>
            
            <form action="{{ route('produk') }}" method="GET">
                <div class="form-group">
                    <label class="form-label">Pencarian</label>
                    <div class="input-wrapper">
                        <i data-lucide="search"></i>
                        <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Ketik nama / kode..." class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <div class="checkbox-group">
                        @foreach(['Flower', 'Snack', 'Money', 'Doll'] as $kat)
                        <label class="checkbox-label">
                            <input type="checkbox" name="kategori[]" value="{{ $kat }}" 
                                {{ in_array($kat, request('kategori', [])) ? 'checked' : '' }}>
                            <span class="checkbox-text">{{ $kat }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn-block">Terapkan Filter</button>
            </form>
        </div>
    </aside>

    <div class="list-grid">
        @foreach($products as $product)
        <div class="list-card">
            <div class="list-img-box">
                <img src="{{ $product->gambar_url }}" alt="Produk">
                <div class="list-img-overlay"></div>
            </div>
            
            <div class="list-info">
                <div>
                    <div class="list-top">
                        <span class="list-code">{{ $product->kode_produk }}</span>
                        <span class="list-status {{ $product->status == 'Tersedia' ? 'tersedia' : 'menipis' }}">
                            <span class="status-dot {{ $product->status == 'Tersedia' ? 'tersedia' : 'menipis' }}"></span>
                            {{ $product->status }}
                        </span>
                    </div>
                    <h4 class="list-title">{{ $product->nama }}</h4>
                    <p class="list-desc">{{ $product->kategori }} • {{ $product->stok }} Unit</p>
                </div>
                
                <div class="list-bottom">
                    <span class="list-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    
                    <div class="list-actions">
                        <a href="{{ route('produk.edit', $product->id) }}" class="btn-icon edit" title="Edit">
                            <i data-lucide="edit-2" style="width: 16px; height: 16px;"></i>
                        </a>
                        
                        <form action="{{ route('produk.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon delete" title="Hapus">
                                <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        @if($products->isEmpty())
        <div class="empty-state" style="grid-column: 1 / -1;">
            <div class="empty-icon">
                <i data-lucide="search-x"></i>
            </div>
            <h3 class="empty-title">Produk tidak ditemukan</h3>
            <p class="empty-desc">Coba gunakan kata kunci atau filter yang lain.</p>
        </div>
        @endif
    </div>
</div>
@endsection