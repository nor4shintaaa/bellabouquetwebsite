@extends('layouts.app')

@section('content')
<style>
    .form-container {
        background: var(--white); padding: 40px; border-radius: 32px;
        border: 1px solid var(--slate-100); box-shadow: var(--shadow-sm);
        max-width: 800px; margin: 0 auto;
    }
    .grid-2 { display: grid; grid-template-columns: 1fr; gap: 24px; }
    @media (min-width: 640px) { .grid-2 { grid-template-columns: repeat(2, 1fr); } }
    .input-control {
        width: 100%; padding: 14px 16px; background: var(--slate-50); 
        border: 1px solid var(--slate-200); border-radius: 16px; 
        font-size: 0.875rem; font-weight: 500; outline: none; transition: all 0.3s ease;
    }
    .input-control:focus {
        background: var(--white); border-color: #fca5a5; box-shadow: 0 0 0 4px var(--primary-light);
    }
    .btn-secondary {
        background-color: var(--slate-100); color: var(--slate-700); padding: 14px 24px;
        border-radius: 16px; font-weight: 700; font-size: 0.875rem; transition: all 0.3s ease;
    }
    .btn-secondary:hover { background-color: var(--slate-200); }
    .form-actions { display: flex; justify-content: flex-end; gap: 16px; margin-top: 32px; padding-top: 32px; border-top: 1px solid var(--slate-100); }
</style>

<div class="page-header" style="max-width: 800px; margin: 0 auto 32px auto;">
    <div>
        <h1 class="page-title">{{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}</h1>
        <p class="page-subtitle">Isi data produk buket Anda dengan lengkap.</p>
    </div>
</div>

<div class="form-container">
    <form action="{{ isset($product) ? route('produk.update', $product->id) : route('produk.store') }}" method="POST">
        @csrf
        @if(isset($product)) @method('PUT') @endif

        <div class="grid-2" style="margin-bottom: 24px;">
            <div class="form-group">
                <label class="form-label">Kode Produk</label>
                <input type="text" name="kode_produk" value="{{ old('kode_produk', $product->kode_produk ?? '') }}" class="input-control" placeholder="Contoh: BQT-001" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama" value="{{ old('nama', $product->nama ?? '') }}" class="input-control" placeholder="Nama buket..." required>
            </div>
        </div>

        <div class="grid-2" style="margin-bottom: 24px;">
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="input-control" required>
                    <option value="" hidden>Pilih Kategori</option>
                    @foreach(['Flower', 'Snack', 'Money', 'Doll'] as $kat)
                        <option value="{{ $kat }}" {{ old('kategori', $product->kategori ?? '') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <!-- <div class="form-group">
                <label class="form-label">Status Ketersediaan</label>
                <select name="status" class="input-control" required>
                    <option value="Tersedia" {{ old('status', $product->status ?? '') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Menipis" {{ old('status', $product->status ?? '') == 'Menipis' ? 'selected' : '' }}>Menipis</option>
                </select>
            </div> -->
        </div>

        <div class="grid-2" style="margin-bottom: 24px;">
            <div class="form-group">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" value="{{ old('stok', $product->stok ?? '') }}" class="input-control" placeholder="0" required>
            </div>
            <div class="form-group">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga', $product->harga ?? '') }}" class="input-control" placeholder="100000" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">URL Gambar</label>
            <input type="url" name="gambar_url" value="{{ old('gambar_url', $product->gambar_url ?? '') }}" class="input-control" placeholder="https://..." required>
        </div>

        <div class="form-actions">
            <a href="{{ route('produk') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" style="width: 18px; height: 18px;"></i> 
                {{ isset($product) ? 'Simpan Perubahan' : 'Simpan Produk' }}
            </button>
        </div>
    </form>
</div>
@endsection