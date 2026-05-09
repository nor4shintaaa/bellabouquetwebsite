@extends('layouts.app')

@section('content')
<div class="page-header" style="max-width: 800px; margin: 0 auto 32px auto;">
    <h1 class="page-title">Edit Produk</h1>
    <p class="page-subtitle">Perbarui informasi produk buket Anda.</p>
</div>

<div class="section-box" style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div class="form-group" style="margin: 0;">
                <label class="form-label">Kode Produk</label>
                <input type="text" name="kode_produk" value="{{ old('kode_produk', $produk->kode_produk) }}" class="form-input" style="padding-left: 16px;" required>
                @error('kode_produk') <span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group" style="margin: 0;">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama" value="{{ old('nama', $produk->nama) }}" class="form-input" style="padding-left: 16px;" required>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label class="form-label">Kategori</label>
            <select name="kategori" class="form-input" style="padding-left: 16px;" required>
                @foreach(['Flower', 'Snack', 'Money', 'Doll'] as $kat)
                    <option value="{{ $kat }}" {{ old('kategori', $produk->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div class="form-group" style="margin: 0;">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" class="form-input" style="padding-left: 16px;" required>
            </div>
            <div class="form-group" style="margin: 0;">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" class="form-input" style="padding-left: 16px;" required>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 32px;">
            <label class="form-label">Ganti Foto Produk (Biarkan kosong jika tidak ingin ganti)</label>
            <div style="border: 1px dashed var(--slate-200); padding: 24px; border-radius: 16px; text-align: center; background-color: var(--slate-50);">
                <input type="file" name="gambar" class="form-input" style="padding: 10px; background: white; max-width: 300px; margin: 0 auto;" accept="image/*">
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 16px; border-top: 1px solid var(--slate-100); padding-top: 24px;">
            <a href="{{ route('produk.index') }}" style="padding: 14px 24px; font-weight: 700; color: var(--slate-500);">Batal</a>
            <button type="submit" class="btn-primary" style="background-color: #9f1239;">Perbarui Produk</button>
        </div>
    </form>
</div>
@endsection