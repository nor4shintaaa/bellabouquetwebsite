@extends('layouts.app')

@section('content')
<style>
    /* ==========================================================================
       CSS UTAMA (Card, Tabel, dll - Dipertahankan dari sebelumnya)
       ========================================================================== */
    .btn-action { font-size: 0.7rem; font-weight: 700; padding: 6px 16px; border-radius: 8px; transition: all 0.2s ease; cursor: pointer; border: none; }
    .btn-action.edit { color: #d97706; background-color: #fef3c7; text-decoration: none; display: inline-flex; }
    .btn-action.edit:hover { background-color: #fde68a; }
    .btn-action.hapus { color: #e11d48; background-color: #ffe4e6; }
    .btn-action.hapus:hover { background-color: #fecdd3; }

    .table-modern { width: 100%; border-collapse: collapse; text-align: left; }
    .table-modern th { background-color: #fce7f3; color: var(--slate-500); font-size: 0.75rem; font-weight: 800; padding: 16px 24px; text-transform: uppercase; letter-spacing: 0.5px; }
    .table-modern td { padding: 16px 24px; font-size: 0.875rem; font-weight: 600; color: var(--slate-700); border-bottom: 1px solid var(--slate-100); }
    .table-modern tr:hover td { background-color: var(--slate-50); }

    .filter-box { background-color: var(--white); padding: 32px 24px; border-radius: 32px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); }
    .filter-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
    .filter-title { font-size: 1.5rem; font-weight: 900; color: var(--slate-900); letter-spacing: -0.5px; }
    .btn-reset { font-size: 0.875rem; font-weight: 700; color: var(--slate-400); text-decoration: none; }
    .btn-reset:hover { color: var(--primary); }
    .form-label { font-size: 0.75rem; font-weight: 800; color: var(--slate-400); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block; }
    .input-wrapper { position: relative; margin-bottom: 32px; }
    .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 22px; height: 22px; color: var(--slate-800); }
    .search-input { width: 100%; padding: 16px 16px 16px 48px; border-radius: 20px; border: 1px solid var(--slate-200); background-color: var(--white); font-size: 0.9rem; font-weight: 600; color: var(--slate-700); outline: none; }
    .search-input:focus { border-color: #fbcfe8; box-shadow: 0 0 0 4px #fdf2f8; }
    .checkbox-group { display: flex; flex-direction: column; gap: 12px; }
    .checkbox-item { display: flex; align-items: center; gap: 16px; padding: 14px 20px; background-color: #f8fafc; border-radius: 20px; cursor: pointer; }
    .checkbox-item:hover { background-color: var(--slate-100); }
    .checkbox-item input[type="checkbox"] { width: 20px; height: 20px; accent-color: var(--slate-800); cursor: pointer; }
    .checkbox-text { font-size: 1rem; font-weight: 700; color: var(--slate-700); }
    .filter-footer { margin-top: 32px; padding-top: 24px; border-top: 1px dashed var(--slate-200); text-align: center; font-size: 0.875rem; font-weight: 600; color: var(--slate-500); }

    /* ==========================================================================
       CSS BARU: CUSTOM MODERN DELETE MODAL (SESUAI TEMA)
       ========================================================================== */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(15, 23, 42, 0.6); /* Slate-900 dengan opasitas */
        backdrop-filter: blur(4px); /* Efek blur kaca modern */
        z-index: 9999; display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden; /* Sembunyi secara default */
        transition: all 0.3s ease;
    }
    .modal-overlay.show { opacity: 1; visibility: visible; }

    .modal-content {
        background-color: var(--white);
        width: 90%; max-width: 440px;
        padding: 40px;
        border-radius: 24px; /* Bulat lega sesuai tema */
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); /* Bayangan dalam */
        text-align: center;
        transform: scale(0.9); transition: all 0.3s ease; /* Animasi zoom */
    }
    .modal-overlay.show .modal-content { transform: scale(1); }

    .modal-icon-circle {
        width: 80px; height: 80px;
        background-color: #ffe4e6; /* Rose-100 */
        color: #e11d48; /* Rose-600 */
        border-radius: 9999px; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 28px auto;
    }

    .modal-title { font-size: 1.5rem; font-weight: 900; color: var(--slate-900); margin-bottom: 12px; letter-spacing: -0.5px; }
    .modal-text { font-size: 1rem; font-weight: 600; color: var(--slate-600); line-height: 1.6; margin-bottom: 36px; }

    .modal-action-group { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .btn-modal { padding: 16px; border-radius: 14px; font-size: 1rem; font-weight: 800; cursor: pointer; border: none; transition: all 0.2s ease; }
    
    .btn-modal-cancel { background-color: #f1f5f9; color: #64748b; }
    .btn-modal-cancel:hover { background-color: #e2e8f0; }
    
    .btn-modal-delete { background-color: #e11d48; color: var(--white); box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3); }
    .btn-modal-delete:hover { background-color: #be123c; transform: translateY(-2px); }
</style>

<div class="layout-wrapper">
    <aside class="sidebar">
        <div class="filter-box">
            <div class="filter-header">
                <h3 class="filter-title">Filter Data</h3>
                <a href="{{ route('produk.index') }}" class="btn-reset">Reset</a>
            </div>
            <form id="filterForm" action="{{ route('produk.index') }}" method="GET">
                <div>
                    <label class="form-label">Pencarian</label>
                    <div class="input-wrapper">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau kode..." class="search-input" autocomplete="off">
                    </div>
                </div>
                <div>
                    <label class="form-label">Kategori Produk</label>
                    <div class="checkbox-group">
                        @foreach(['Flower', 'Snack', 'Money', 'Doll'] as $kat)
                        <label class="checkbox-item">
                            <input type="checkbox" name="kategori[]" value="{{ $kat }}" {{ in_array($kat, request('kategori', [])) ? 'checked' : '' }} class="filter-checkbox">
                            <span class="checkbox-text">{{ $kat }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="filter-footer">Menampilkan <strong>{{ $products->total() }}</strong> produk</div>
                <button type="submit" style="display: none;"></button>
            </form>
        </div>
    </aside>

    <div style="flex-grow: 1;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--slate-800);">Katalog & Data Produk</h1>
            <a href="{{ route('produk.create') }}" style="background-color: #9f1239; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                + Tambah Produk
            </a>
        </div>

        <div class="list-grid" style="margin-bottom: 40px;">
            @forelse($products as $product)
            <div class="card-katalog">
                <div class="card-katalog-header" style="background-color: {{ $product->status == 'Menipis' ? '#f43f5e' : '#f472b6' }};">
                    <div class="card-katalog-code"><i data-lucide="flower" style="width: 14px; color: rgba(255,255,255,0.8);"></i> {{ $product->kode_produk }}</div>
                    <div class="card-katalog-badge {{ $product->status == 'Tersedia' ? 'tersedia' : 'menipis' }}">{{ $product->status }}</div>
                </div>
                <div class="card-katalog-body">
                    @if($product->gambar_url)
                        <img src="{{ str_starts_with($product->gambar_url, 'http') ? $product->gambar_url : asset('storage/' . $product->gambar_url) }}" alt="{{ $product->nama }}" class="card-katalog-img">
                    @else
                        <div class="card-katalog-img" style="display:flex; align-items:center; justify-content:center; color:var(--slate-400); background:#f1f5f9;">No Image</div>
                    @endif
                    <h3 class="card-katalog-title">{{ $product->nama }}</h3>
                    <div class="card-katalog-meta">
                        <div class="meta-text"><i data-lucide="pin" style="width: 14px; color: #f472b6;"></i> Kat: {{ $product->kategori }}</div>
                        <div class="meta-text"><i data-lucide="box" style="width: 14px; color: #a1a1aa;"></i> Stok: {{ $product->stok }} unit</div>
                    </div>
                </div>
                <div class="card-katalog-footer" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background-color: var(--white); border-top: 1px solid var(--slate-100);">
                    <span class="card-katalog-price" style="color: #f472b6;">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('produk.edit', $product->id) }}" class="btn-action edit">Edit</a>
                        
                        <button type="button" class="btn-action hapus btn-trigger-delete" data-id="{{ $product->id }}" data-name="{{ $product->nama }}">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1;"><i data-lucide="search-x" style="width: 48px; height: 48px; color: var(--slate-300); margin-bottom: 16px;"></i><h3 class="empty-title">Produk tidak ditemukan</h3></div>
            @endforelse
        </div>

        <div class="section-box" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
            <div style="padding: 24px; border-bottom: 1px solid var(--slate-100);"><h3 style="color: #f472b6; font-size: 1.125rem; font-weight: 800;">Daftar Lengkap Data Produk</h3></div>
            <div style="overflow-x: auto;">
                <table class="table-modern">
                    <thead><tr><th>Kode</th><th>Nama Produk</th><th>Kategori</th><th>Stok</th><th>Harga</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td style="color: var(--slate-900); font-weight: 800;">{{ $product->kode_produk }}</td>
                            <td>{{ $product->nama }}</td>
                            <td>{{ $product->kategori }}</td>
                            <td>{{ $product->stok }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td><span class="card-katalog-badge {{ $product->status == 'Tersedia' ? 'tersedia' : 'menipis' }}" style="box-shadow: none; border: 1px solid currentColor;">{{ $product->status }}</span></td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('produk.edit', $product->id) }}" class="btn-action edit">Edit</a>
                                    
                                    <button type="button" class="btn-action hapus btn-trigger-delete" data-id="{{ $product->id }}" data-name="{{ $product->nama }}">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin-bottom: 40px;">{{ $products->links() }}</div>
    </div>
</div>

<div id="deleteModalOverlay" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-icon-circle">
            <i data-lucide="alert-triangle" style="width: 40px; height: 40px;"></i>
        </div>
        
        <h2 class="modal-title">Hapus Produk?</h2>
        <p class="modal-text">
            Kamu yakin ingin menghapus produk <strong id="deleteModalProductName" style="color:var(--slate-900);">[Nama Produk]</strong>? Tindakan ini permanen dan tidak bisa dibatalkan.
        </p>
        
        <div class="modal-action-group">
            <button type="button" class="btn-modal btn-modal-cancel" id="btnModalCancel">Batal</button>
            
            <button type="button" class="btn-modal btn-modal-delete" id="btnModalConfirm">Ya, Hapus!</button>
        </div>
    </div>
</div>

<form id="globalDeleteForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. SCRIPT FILTER REAL-TIME (Tetap sama) ---
        const filterForm = document.getElementById('filterForm');
        const checkboxes = filterForm.querySelectorAll('.filter-checkbox');
        const searchInput = filterForm.querySelector('.search-input');
        let typingTimer;

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => { filterForm.submit(); });
        });

        searchInput.addEventListener('input', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => { filterForm.submit(); }, 800); 
        });

        if (searchInput.value) {
            searchInput.focus();
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
        }

        // --- 2. SCRIPT BARU: CUSTOM MINIMALIST DELETE MODAL LOGIC ---
        const modalOverlay = document.getElementById('deleteModalOverlay');
        const modalProductNamePlaceholder = document.getElementById('deleteModalProductName');
        const cancelBtn = document.getElementById('btnModalCancel');
        const confirmBtn = document.getElementById('btnModalConfirm');
        const globalDeleteForm = document.getElementById('globalDeleteForm');
        
        // Pilih semua tombol hapus di Grid dan Tabel
        const deleteTriggers = document.querySelectorAll('.btn-trigger-delete');
        
        let currentDeleteUrl = ''; // Menyimpan URL hapus untuk produk yang dipilih

        // Fungsi Buka Modal
        function openModal(id, name) {
            currentDeleteUrl = `{{ url('produk') }}/${id}`; // Buat URL: /produk/{id}
            modalProductNamePlaceholder.textContent = name; // Set nama produk di teks modal
            modalOverlay.classList.add('show'); // Tampilkan modal
            // Nonaktifkan scroll body saat modal buka (Opsional tapi bagus untuk UX)
            document.body.style.overflow = 'hidden'; 
        }

        // Fungsi Tutup Modal
        function closeModal() {
            modalOverlay.classList.remove('show'); // Sembunyikan modal
            currentDeleteUrl = '';
            // Aktifkan kembali scroll body
            document.body.style.overflow = '';
        }

        // Pasang event listener ke setiap tombol hapus
        deleteTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                // Ambil data dari atribut data- HTML
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                openModal(productId, productName);
            });
        });

        // Klik Tombol Batal
        cancelBtn.addEventListener('click', closeModal);

        // Klik Area Overlay (luar kotak modal) untuk menutup
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                closeModal();
            }
        });

        // Klik Tombol Konfirmasi Hapus
        confirmBtn.addEventListener('click', function() {
            if (currentDeleteUrl) {
                globalDeleteForm.action = currentDeleteUrl; // Set action form tersembunyi
                globalDeleteForm.submit(); // Kirim form
            }
        });

        // Tutup dengan tombol Esc
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modalOverlay.classList.contains('show')) {
                closeModal();
            }
        });
    });
</script>
@endpush
@endsection