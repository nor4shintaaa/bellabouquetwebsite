@extends('layouts.app')

@section('content')
<style>
    .settings-wrapper {
        max-width: 1050px;
        margin: 0 auto;
    }

    .settings-header {
        margin-bottom: 32px;
    }

    .settings-title {
        font-size: 2.25rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 8px;
    }

    .settings-subtitle {
        color: var(--slate-500);
        font-size: 1.05rem;
        line-height: 1.6;
    }

    .settings-card {
        background: var(--white);
        border: 1px solid var(--slate-100);
        border-radius: 24px;
        padding: 36px;
        box-shadow: var(--shadow-sm);
    }

    .grid-kontak {
        display: grid;
        grid-template-columns: 1fr;
        gap: 22px;
    }

    @media (min-width: 768px) {
        .grid-kontak {
            grid-template-columns: 1fr 1fr;
        }
    }

    .form-group {
        margin-bottom: 24px;
    }

    .label-pengaturan {
        font-size: 0.75rem;
        font-weight: 900;
        color: var(--slate-500);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        display: block;
    }

    .input-pengaturan {
        width: 100%;
        padding: 16px 18px;
        border-radius: 16px;
        border: 1px solid var(--slate-200);
        background: #f8fafc;
        color: var(--slate-700);
        font-family: inherit;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s ease;
    }

    .input-pengaturan:focus {
        background: white;
        border-color: #fbcfe8;
        box-shadow: 0 0 0 4px #fdf2f8;
    }

    .input-with-prefix {
        position: relative;
    }

    .input-prefix {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--slate-400);
        font-weight: 800;
    }

    .input-with-prefix input {
        padding-left: 60px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 14px;
        border-top: 1px solid var(--slate-100);
        padding-top: 28px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .btn-save {
        background: #9f1239;
        color: white;
        border: none;
        border-radius: 14px;
        padding: 15px 28px;
        font-weight: 900;
        cursor: pointer;
    }

    .btn-save:hover {
        background: #be185d;
    }

    .btn-preview {
        background: white;
        border: 2px solid var(--slate-200);
        color: var(--slate-600);
        border-radius: 14px;
        padding: 15px 24px;
        font-weight: 900;
        cursor: pointer;
    }

    .preview-contact {
        margin-top: 28px;
        background: #fff7fb;
        border: 1px solid #fce7f3;
        border-radius: 24px;
        padding: 30px;
    }

    .preview-title {
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 8px;
    }

    .preview-subtitle {
        color: var(--slate-500);
        margin-bottom: 24px;
    }

    .preview-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }

    @media (min-width: 768px) {
        .preview-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .preview-card {
        background: white;
        border: 1px solid #fce7f3;
        border-radius: 18px;
        padding: 18px;
    }

    .preview-card span {
        display: block;
        font-size: 0.75rem;
        font-weight: 900;
        color: #be185d;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .preview-card strong {
        color: var(--slate-800);
        word-break: break-word;
    }

    .error-text {
        color: #e11d48;
        font-weight: 700;
        font-size: 0.85rem;
        margin-top: 8px;
    }
</style>

<div class="settings-wrapper">
    <div class="settings-header">
        <h1 class="settings-title">Pengaturan Kontak</h1>
        <p class="settings-subtitle">
            Data kontak ini akan tampil di halaman pelanggan bagian Kontak dan footer.
        </p>
    </div>

    <div class="settings-card">
        <form action="{{ route('kontak.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid-kontak">
                <div class="form-group">
                    <label class="label-pengaturan">Nomor WhatsApp</label>
                    <div class="input-with-prefix">
                        <span class="input-prefix">+62</span>
                        <input
                            type="text"
                            name="whatsapp"
                            id="whatsapp"
                            class="input-pengaturan"
                            value="{{ old('whatsapp', $setting->whatsapp) }}"
                            placeholder="81234567890"
                            required
                        >
                    </div>

                    @error('whatsapp')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="label-pengaturan">Email Bisnis</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="input-pengaturan"
                        value="{{ old('email', $setting->email) }}"
                        placeholder="bellabouquet@gmail.com"
                        required
                    >

                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="label-pengaturan">Alamat Toko</label>
                <textarea
                    name="address"
                    id="address"
                    rows="4"
                    class="input-pengaturan"
                    required
                >{{ old('address', $setting->address) }}</textarea>

                @error('address')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid-kontak">
                <div class="form-group">
                    <label class="label-pengaturan">Instagram</label>
                    <input
                        type="text"
                        name="instagram"
                        id="instagram"
                        class="input-pengaturan"
                        value="{{ old('instagram', $setting->instagram) }}"
                        placeholder="@bellabouquet"
                    >

                    @error('instagram')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="label-pengaturan">TikTok</label>
                    <input
                        type="text"
                        name="tiktok"
                        id="tiktok"
                        class="input-pengaturan"
                        value="{{ old('tiktok', $setting->tiktok) }}"
                        placeholder="@bellabouquet.official"
                    >

                    @error('tiktok')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="label-pengaturan">Teks Footer</label>
                <input
                    type="text"
                    name="footer_text"
                    id="footerText"
                    class="input-pengaturan"
                    value="{{ old('footer_text', $setting->footer_text) }}"
                    placeholder="Bella Bouquet menyediakan berbagai pilihan bouquet cantik."
                >

                @error('footer_text')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="button" class="btn-preview" onclick="updatePreviewKontak()">
                    Preview
                </button>

                <button type="submit" class="btn-save">
                    Simpan Kontak
                </button>
            </div>
        </form>

        <div class="preview-contact">
            <h2 class="preview-title">Preview Kontak Pelanggan</h2>
            <p class="preview-subtitle">Tampilan ringkas data kontak yang akan muncul di halaman pelanggan.</p>

            <div class="preview-grid">
                <div class="preview-card">
                    <span>WhatsApp</span>
                    <strong id="previewWhatsapp">+62 {{ $setting->whatsapp }}</strong>
                </div>

                <div class="preview-card">
                    <span>Email</span>
                    <strong id="previewEmail">{{ $setting->email }}</strong>
                </div>

                <div class="preview-card">
                    <span>Instagram</span>
                    <strong id="previewInstagram">{{ $setting->instagram }}</strong>
                </div>

                <div class="preview-card">
                    <span>TikTok</span>
                    <strong id="previewTiktok">{{ $setting->tiktok }}</strong>
                </div>

                <div class="preview-card" style="grid-column: 1 / -1;">
                    <span>Alamat</span>
                    <strong id="previewAddress">{{ $setting->address }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updatePreviewKontak() {
        document.getElementById('previewWhatsapp').textContent =
            '+62 ' + document.getElementById('whatsapp').value;

        document.getElementById('previewEmail').textContent =
            document.getElementById('email').value;

        document.getElementById('previewInstagram').textContent =
            document.getElementById('instagram').value || '-';

        document.getElementById('previewTiktok').textContent =
            document.getElementById('tiktok').value || '-';

        document.getElementById('previewAddress').textContent =
            document.getElementById('address').value;
    }
</script>
@endpush
@endsection