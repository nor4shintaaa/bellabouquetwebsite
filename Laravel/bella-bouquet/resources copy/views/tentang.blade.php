@extends('layouts.app')

@section('content')
<style>
    /* ==========================================================================
       CSS FORM PENGATURAN ADMIN
       ========================================================================== */
    .settings-wrapper { max-width: 1000px; margin: 0 auto; }
    .header-pengaturan { display: flex; flex-direction: column; gap: 8px; margin-bottom: 32px; }
    .grid-visi-misi { display: grid; grid-template-columns: 1fr; gap: 24px; }
    
    @media (min-width: 768px) {
        .header-pengaturan { flex-direction: row; justify-content: space-between; align-items: flex-end; }
        .grid-visi-misi { grid-template-columns: 1fr 1fr; }
    }

    .input-pengaturan {
        width: 100%; padding: 16px 20px; border-radius: 16px; border: 1px solid var(--slate-200);
        font-family: inherit; font-size: 0.95rem; color: var(--slate-700); outline: none;
        transition: all 0.3s ease; background-color: #f8fafc;
    }
    .input-pengaturan:focus { background-color: #ffffff; border-color: #fbcfe8; box-shadow: 0 0 0 4px #fdf2f8; }
    .label-pengaturan { font-size: 0.75rem; font-weight: 800; color: var(--slate-500); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block; }

    /* ==========================================================================
       CSS PREVIEW MODAL (TAMPILAN PELANGGAN)
       ========================================================================== */
    .preview-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(15, 23, 42, 0.75); backdrop-filter: blur(8px);
        z-index: 9999; display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden; transition: all 0.3s ease;
    }
    .preview-overlay.show { opacity: 1; visibility: visible; }

    .preview-modal {
        background-color: #ffffff; width: 95%; max-width: 1100px; height: 90vh;
        border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: flex; flex-direction: column; overflow: hidden;
        transform: translateY(20px) scale(0.95); transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .preview-overlay.show .preview-modal { transform: translateY(0) scale(1); }

    /* Header ala Browser Mac */
    .preview-header {
        background-color: #f1f5f9; padding: 16px 24px; border-bottom: 1px solid var(--slate-200);
        display: flex; justify-content: space-between; align-items: center;
    }
    .browser-dots { display: flex; gap: 8px; }
    .dot { width: 12px; height: 12px; border-radius: 50%; }
    .dot.red { background-color: #ef4444; }
    .dot.yellow { background-color: #eab308; }
    .dot.green { background-color: #22c55e; }
    .preview-url { font-size: 0.8rem; font-weight: 600; color: var(--slate-500); background: white; padding: 6px 24px; border-radius: 20px; }
    .btn-close-preview { background: none; border: none; font-size: 0.875rem; font-weight: 700; color: var(--slate-500); cursor: pointer; transition: color 0.2s; }
    .btn-close-preview:hover { color: #e11d48; }

    /* Area Konten Pelanggan (Scrollable) */
    .preview-body { flex-grow: 1; overflow-y: auto; background-color: #fffafb; padding: 0; }
    
    /* Styling Halaman Pelanggan */
    .customer-hero { width: 100%; height: 350px; background-color: #ffe4e6; position: relative; }
    .customer-hero img { width: 100%; height: 100%; object-fit: cover; }
    .customer-hero-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.5), transparent); }
    
    .customer-content-wrapper { max-width: 800px; margin: -60px auto 60px auto; position: relative; z-index: 10; background: white; padding: 48px; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); text-align: center; }
    .customer-title { font-size: 2.5rem; font-weight: 900; color: var(--slate-900); margin-bottom: 24px; font-family: 'Playfair Display', serif; }
    .customer-desc { font-size: 1.125rem; line-height: 1.8; color: var(--slate-600); margin-bottom: 40px; }
    
    .customer-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; text-align: left; padding-top: 40px; border-top: 1px solid var(--slate-100); }
    .customer-card-title { font-size: 1.25rem; font-weight: 800; color: #f472b6; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .customer-card-text { font-size: 1rem; line-height: 1.7; color: var(--slate-600); }
</style>

<div class="settings-wrapper">
    <div class="header-pengaturan">
        <div style="max-width: 700px;">
            <h1 class="page-title" style="font-size: 2.25rem; font-weight: 900; color: var(--slate-900); margin-bottom: 8px;">Pengaturan Halaman Tentang</h1>
            <p class="page-subtitle" style="font-size: 1.05rem; color: var(--slate-500); line-height: 1.5;">Kelola informasi profil Bella Bouquet yang akan ditampilkan di website pelanggan.</p>
        </div>
    </div>

    <div class="section-box" style="padding: 40px; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 32px;">
                <label class="label-pengaturan">Deskripsi Utama Toko</label>
                <textarea id="inputDeskripsi" name="deskripsi" class="input-pengaturan" rows="4" style="resize: vertical;">Bella Bouquet adalah platform manajemen florist modern yang berfokus pada kualitas dan keindahan. Kami merangkai setiap buket dengan cinta untuk momen spesial Anda.</textarea>
            </div>

            <div class="grid-visi-misi" style="margin-bottom: 40px;">
                <div>
                    <label class="label-pengaturan">Visi</label>
                    <textarea id="inputVisi" name="visi" class="input-pengaturan" rows="4" style="resize: none;">Menjadi florist pilihan utama yang menghadirkan kebahagiaan di setiap momen berharga.</textarea>
                </div>
                <div>
                    <label class="label-pengaturan">Misi</label>
                    <textarea id="inputMisi" name="misi" class="input-pengaturan" rows="4" style="resize: none;">Menyediakan rangkaian bunga segar berkualitas premium dengan pelayanan yang hangat dan profesional.</textarea>
                </div>
            </div>

            <div style="margin-bottom: 40px;">
                <label class="label-pengaturan">Foto Banner / Toko (Opsional)</label>
                <div style="border: 2px dashed var(--slate-200); padding: 48px 24px; border-radius: 20px; text-align: center; background-color: #f8fafc;">
                    <div style="background-color: white; width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                        <i data-lucide="image" style="width: 32px; height: 32px; color: #f472b6;"></i>
                    </div>
                    <p style="font-size: 1rem; color: var(--slate-700); font-weight: 800; margin-bottom: 8px;">Upload foto toko atau tim Anda</p>
                    <input type="file" id="inputGambar" name="banner" style="font-size: 0.9rem; font-weight: 600; color: var(--slate-600); background: white; padding: 12px 20px; border-radius: 12px; border: 1px solid var(--slate-200); cursor: pointer;" accept="image/*">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 16px; border-top: 1px solid var(--slate-100); padding-top: 32px;">
                <button type="button" id="btnBukaPreview" style="padding: 16px 24px; border-radius: 14px; font-weight: 800; font-size: 1rem; border: 2px solid #e2e8f0; color: var(--slate-600); background: white; cursor: pointer; transition: all 0.3s ease;">
                    <i data-lucide="eye" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i> Preview
                </button>
                <button type="button" class="btn-primary" style="background-color: #9f1239; padding: 16px 32px; border-radius: 14px; font-weight: 800; font-size: 1rem; border: none; color: white; cursor: pointer; transition: all 0.3s ease;" onclick="showToastDummy()">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalPreview" class="preview-overlay">
    <div class="preview-modal">
        <div class="preview-header">
            <div class="browser-dots">
                <div class="dot red"></div><div class="dot yellow"></div><div class="dot green"></div>
            </div>
            <div class="preview-url"><i data-lucide="lock" style="width: 12px; height: 12px; display:inline; margin-right:4px;"></i> bellabouquet.com/tentang-kami</div>
            <button type="button" id="btnTutupPreview" class="btn-close-preview">Tutup Preview <i data-lucide="x" style="width: 16px; height: 16px; display:inline; vertical-align:-3px;"></i></button>
        </div>

        <div class="preview-body">
            <div class="customer-hero">
                <img id="prevGambar" src="https://images.unsplash.com/photo-1563241597-124b419c15c0?q=80&w=1200&auto=format&fit=crop" alt="Banner Bella Bouquet">
                <div class="customer-hero-overlay"></div>
            </div>

            <div class="customer-content-wrapper">
                <h1 class="customer-title">Tentang Bella Bouquet</h1>
                <p id="prevDeskripsi" class="customer-desc">Loading deskripsi...</p>

                <div class="customer-grid">
                    <div>
                        <h3 class="customer-card-title"><i data-lucide="target"></i> Visi Kami</h3>
                        <p id="prevVisi" class="customer-card-text">Loading visi...</p>
                    </div>
                    <div>
                        <h3 class="customer-card-title"><i data-lucide="heart-handshake"></i> Misi Kami</h3>
                        <p id="prevMisi" class="customer-card-text">Loading misi...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Deklarasi Elemen
        const btnBukaPreview = document.getElementById('btnBukaPreview');
        const btnTutupPreview = document.getElementById('btnTutupPreview');
        const modalPreview = document.getElementById('modalPreview');
        
        // Input dari Admin
        const inputDeskripsi = document.getElementById('inputDeskripsi');
        const inputVisi = document.getElementById('inputVisi');
        const inputMisi = document.getElementById('inputMisi');
        const inputGambar = document.getElementById('inputGambar');
        
        // Output di Preview
        const prevDeskripsi = document.getElementById('prevDeskripsi');
        const prevVisi = document.getElementById('prevVisi');
        const prevMisi = document.getElementById('prevMisi');
        const prevGambar = document.getElementById('prevGambar');

        // Fungsi Buka Preview
        btnBukaPreview.addEventListener('click', function() {
            // 1. Transfer teks real-time
            // Menggunakan replace untuk mengubah Enter (\n) menjadi <br> di HTML
            prevDeskripsi.innerHTML = inputDeskripsi.value.replace(/\n/g, '<br>');
            prevVisi.innerHTML = inputVisi.value.replace(/\n/g, '<br>');
            prevMisi.innerHTML = inputMisi.value.replace(/\n/g, '<br>');

            // 2. Transfer gambar real-time (jika admin memilih file baru)
            if (inputGambar.files && inputGambar.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    prevGambar.src = e.target.result;
                }
                reader.readAsDataURL(inputGambar.files[0]);
            }

            // 3. Tampilkan Modal
            modalPreview.classList.add('show');
            document.body.style.overflow = 'hidden'; // Matikan scroll layar belakang
            lucide.createIcons(); // Refresh icon di dalam modal
        });

        // Fungsi Tutup Preview
        function tutupModal() {
            modalPreview.classList.remove('show');
            document.body.style.overflow = ''; 
        }

        btnTutupPreview.addEventListener('click', tutupModal);

        // Tutup jika area gelap diluar modal diklik
        modalPreview.addEventListener('click', function(e) {
            if (e.target === modalPreview) tutupModal();
        });

        // Tutup dengan tombol Esc
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modalPreview.classList.contains('show')) tutupModal();
        });
    });

    // Dummy Toast untuk tombol simpan
    function showToastDummy() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success', title: 'Berhasil Disimpan!', text: 'Profil Bella Bouquet berhasil diperbarui.',
                confirmButtonColor: '#9f1239', shape: 'border-radius: 20px', customClass: { popup: 'swal-modern' }
            });
        } else {
            alert('Berhasil! Profil diperbarui.');
        }
    }
</script>
@endpush
@endsection