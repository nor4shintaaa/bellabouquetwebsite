@extends('layouts.app')

@section('content')
<style>
    /* ==========================================================================
       CSS FORM PENGATURAN ADMIN
       ========================================================================== */
    .settings-wrapper { max-width: 1000px; margin: 0 auto; }
    .label-pengaturan { font-size: 0.75rem; font-weight: 800; color: var(--slate-500); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: block; }
    
    .input-pengaturan {
        width: 100%; padding: 16px 20px; border-radius: 16px; border: 1px solid var(--slate-200);
        font-family: inherit; font-size: 0.95rem; color: var(--slate-700); outline: none;
        transition: all 0.3s ease; background-color: #f8fafc;
    }
    .input-pengaturan:focus { background-color: #ffffff; border-color: #fbcfe8; box-shadow: 0 0 0 4px #fdf2f8; }

    .grid-kontak { display: grid; grid-template-columns: 1fr; gap: 24px; margin-bottom: 24px; }
    @media (min-width: 768px) { .grid-kontak { grid-template-columns: 1fr 1fr; } }

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
        background-color: #ffffff; width: 95%; max-width: 1000px; height: 85vh;
        border-radius: 32px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: flex; flex-direction: column; overflow: hidden;
        transform: translateY(20px) scale(0.95); transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .preview-overlay.show .preview-modal { transform: translateY(0) scale(1); }

    .preview-header {
        background-color: #f1f5f9; padding: 16px 24px; border-bottom: 1px solid var(--slate-200);
        display: flex; justify-content: space-between; align-items: center;
    }
    .browser-dots { display: flex; gap: 8px; }
    .dot { width: 10px; height: 10px; border-radius: 50%; }
    .dot.red { background-color: #ef4444; } .dot.yellow { background-color: #eab308; } .dot.green { background-color: #22c55e; }

    /* Content Pelanggan di Preview */
    .preview-body { flex-grow: 1; overflow-y: auto; background-color: #fffafb; padding: 60px 20px; text-align: center; }
    .customer-contact-title { font-size: 2.5rem; font-weight: 900; color: var(--slate-900); margin-bottom: 16px; letter-spacing: -1px; }
    .customer-contact-subtitle { font-size: 1.1rem; color: var(--slate-500); margin-bottom: 60px; max-width: 500px; margin-left: auto; margin-right: auto; }
    
    .customer-contact-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; max-width: 900px; margin: 0 auto; }
    .contact-item-card { background: white; padding: 32px; border-radius: 24px; border: 1px solid #fdf2f8; transition: transform 0.3s ease; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
    .contact-icon-circle { width: 56px; height: 56px; background-color: #fff1f2; color: #f43f5e; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; }
    .contact-label { font-size: 0.75rem; font-weight: 800; color: var(--slate-400); text-transform: uppercase; margin-bottom: 8px; }
    .contact-value { font-size: 1rem; font-weight: 700; color: var(--slate-800); word-break: break-all; }
</style>

<div class="settings-wrapper">
    <div class="header-pengaturan" style="margin-bottom: 32px;">
        <h1 class="page-title" style="font-size: 2.25rem; font-weight: 900; color: var(--slate-900); margin-bottom: 8px;">Pengaturan Kontak</h1>
        <p class="page-subtitle" style="font-size: 1.05rem; color: var(--slate-500);">Atur informasi kontak dan media sosial toko Bella Bouquet Anda.</p>
    </div>

    <div class="section-box" style="padding: 40px; border-radius: 24px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);">
        <form action="#" method="POST">
            @csrf
            
            <div class="grid-kontak">
                <div>
                    <label class="label-pengaturan">Nomor WhatsApp</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); font-weight: 700; color: var(--slate-400);">+62</span>
                        <input type="text" id="inputWA" name="whatsapp" value="81234567890" class="input-pengaturan" style="padding-left: 55px;">
                    </div>
                </div>
                <div>
                    <label class="label-pengaturan">Email Bisnis</label>
                    <input type="email" id="inputEmail" name="email" value="hello@bellabouquet.com" class="input-pengaturan" placeholder="Alamat email...">
                </div>
            </div>

            <div style="margin-bottom: 32px;">
                <label class="label-pengaturan">Alamat Toko (Fisik)</label>
                <textarea id="inputAlamat" name="alamat" class="input-pengaturan" rows="3" style="resize: none;">Jl. Mawar Melati No. 123, Kota Bunga, Indonesia</textarea>
            </div>

            <div style="margin-bottom: 40px;">
                <label class="label-pengaturan">Social Media (Instagram/TikTok)</label>
                <div class="grid-kontak">
                    <input type="text" id="inputIG" name="instagram" value="@bellabouquet" class="input-pengaturan" placeholder="Username Instagram">
                    <input type="text" id="inputTikTok" name="tiktok" value="@bellabouquet.official" class="input-pengaturan" placeholder="Username TikTok">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 16px; border-top: 1px solid var(--slate-100); padding-top: 32px;">
                <button type="button" id="btnOpenPreview" style="padding: 16px 24px; border-radius: 14px; font-weight: 800; font-size: 1rem; border: 2px solid #e2e8f0; color: var(--slate-600); background: white; cursor: pointer; transition: all 0.3s ease;">
                    <i data-lucide="eye" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i> Preview
                </button>
                <button type="button" class="btn-primary" style="background-color: #9f1239; padding: 16px 32px; border-radius: 14px; font-weight: 800; font-size: 1rem; border: none; color: white; cursor: pointer;" onclick="showToastSuccess()">
                    Simpan Kontak
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
            <button type="button" id="btnClosePreview" style="background: none; border: none; font-size: 0.8rem; font-weight: 800; color: var(--slate-400); cursor: pointer;">TUTUP PREVIEW (ESC)</button>
        </div>

        <div class="preview-body">
            <h2 class="customer-contact-title">Hubungi Kami</h2>
            <p class="customer-contact-subtitle">Punya pertanyaan atau ingin melakukan pemesanan khusus? Tim kami siap melayani Anda sepenuh hati.</p>

            <div class="customer-contact-grid">
                <div class="contact-item-card">
                    <div class="contact-icon-circle"><i data-lucide="phone"></i></div>
                    <p class="contact-label">WhatsApp</p>
                    <p id="prevWA" class="contact-value">+62 812-3456-7890</p>
                </div>

                <div class="contact-item-card">
                    <div class="contact-icon-circle"><i data-lucide="mail"></i></div>
                    <p class="contact-label">Email</p>
                    <p id="prevEmail" class="contact-value">hello@bellabouquet.com</p>
                </div>

                <div class="contact-item-card">
                    <div class="contact-icon-circle"><i data-lucide="instagram"></i></div>
                    <p class="contact-label">Instagram</p>
                    <p id="prevIG" class="contact-value">@bellabouquet</p>
                </div>

                <div class="contact-item-card" style="grid-column: 1 / -1;">
                    <div class="contact-icon-circle"><i data-lucide="map-pin"></i></div>
                    <p class="contact-label">Alamat Toko</p>
                    <p id="prevAlamat" class="contact-value">Jl. Mawar Melati No. 123, Kota Bunga, Indonesia</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnOpen = document.getElementById('btnOpenPreview');
        const btnClose = document.getElementById('btnClosePreview');
        const modal = document.getElementById('modalPreview');
        
        // Inputs
        const inWA = document.getElementById('inputWA');
        const inEmail = document.getElementById('inputEmail');
        const inAlamat = document.getElementById('inputAlamat');
        const inIG = document.getElementById('inputIG');

        // Preview Placeholders
        const pWA = document.getElementById('prevWA');
        const pEmail = document.getElementById('prevEmail');
        const pAlamat = document.getElementById('prevAlamat');
        const pIG = document.getElementById('prevIG');

        btnOpen.addEventListener('click', function() {
            // Sinkronisasi data ke preview
            pWA.textContent = '+62 ' + inWA.value;
            pEmail.textContent = inEmail.value;
            pAlamat.textContent = inAlamat.value;
            pIG.textContent = inIG.value;

            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            lucide.createIcons(); 
        });

        const closeModal = () => {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        };

        btnClose.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => { if(e.key === 'Escape') closeModal(); });
    });

    function showToastSuccess() {
        Swal.fire({
            icon: 'success', title: 'Data Tersimpan!', text: 'Kontak Bella Bouquet berhasil diperbarui.',
            confirmButtonColor: '#9f1239', shape: 'border-radius: 20px', customClass: { popup: 'swal-modern' }
        });
    }
</script>
@endpush
@endsection