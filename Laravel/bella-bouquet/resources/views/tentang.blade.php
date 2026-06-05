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

    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }

    @media (min-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group.full {
        grid-column: 1 / -1;
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

    .preview-current {
        margin-top: 14px;
        background: #fff1f2;
        border: 1px solid #fbcfe8;
        border-radius: 18px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .preview-current img {
        width: 120px;
        height: 85px;
        object-fit: cover;
        border-radius: 14px;
        border: 3px solid white;
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

    .preview-box {
        margin-top: 28px;
        background: #fff7fb;
        border: 1px solid #fce7f3;
        border-radius: 24px;
        overflow: hidden;
    }

    .preview-banner {
        height: 220px;
        background: linear-gradient(135deg, #fce7f3, #f9a8d4);
        display: grid;
        place-items: center;
        overflow: hidden;
    }

    .preview-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-content {
        padding: 28px;
    }

    .preview-content h2 {
        margin-top: 0;
        color: var(--slate-900);
        font-weight: 900;
    }

    .preview-content p {
        color: var(--slate-600);
        line-height: 1.7;
    }

    .preview-mini-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        margin-top: 22px;
    }

    @media (min-width: 768px) {
        .preview-mini-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .preview-mini-card {
        background: white;
        padding: 18px;
        border-radius: 18px;
        border: 1px solid #fce7f3;
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
        <h1 class="settings-title">Pengaturan Halaman Tentang</h1>
        <p class="settings-subtitle">
            Data di halaman ini akan otomatis tampil di halaman beranda pelanggan bagian Tentang Bella Bouquet.
        </p>
    </div>

    <div class="settings-card">
        <form action="{{ route('tentang.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="label-pengaturan">Deskripsi Utama Toko</label>
                <textarea
                    name="about_description"
                    id="aboutDescription"
                    rows="5"
                    class="input-pengaturan"
                    required
                >{{ old('about_description', $setting->about_description) }}</textarea>

                @error('about_description')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="label-pengaturan">Visi</label>
                    <textarea
                        name="vision"
                        id="vision"
                        rows="5"
                        class="input-pengaturan"
                        required
                    >{{ old('vision', $setting->vision) }}</textarea>

                    @error('vision')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="label-pengaturan">Misi</label>
                    <textarea
                        name="mission"
                        id="mission"
                        rows="5"
                        class="input-pengaturan"
                        required
                    >{{ old('mission', $setting->mission) }}</textarea>

                    @error('mission')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="label-pengaturan">Foto Banner Tentang</label>
                <input type="file" name="banner" id="bannerInput" class="input-pengaturan" accept="image/*">

                @error('banner')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                @if($setting->banner_path)
                    <div class="preview-current">
                        <img src="{{ asset('storage/' . $setting->banner_path) }}" alt="Banner Tentang">
                        <div>
                            <strong>Banner saat ini</strong>
                            <p style="margin: 6px 0 0; color: var(--slate-500);">
                                Upload file baru kalau ingin mengganti gambar.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="form-actions">
                <button type="button" class="btn-preview" onclick="updatePreviewTentang()">
                    Preview
                </button>

                <button type="submit" class="btn-save">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <div class="preview-box">
            <div class="preview-banner">
                @if($setting->banner_path)
                    <img id="previewBanner" src="{{ asset('storage/' . $setting->banner_path) }}" alt="Preview Banner">
                @else
                    <div id="previewBannerText" style="font-size: 3rem;">💐</div>
                @endif
            </div>

            <div class="preview-content">
                <h2>Tentang Bella Bouquet</h2>
                <p id="previewAbout">{{ $setting->about_description }}</p>

                <div class="preview-mini-grid">
                    <div class="preview-mini-card">
                        <strong>Visi</strong>
                        <p id="previewVision">{{ $setting->vision }}</p>
                    </div>

                    <div class="preview-mini-card">
                        <strong>Misi</strong>
                        <p id="previewMission">{{ $setting->mission }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updatePreviewTentang() {
        document.getElementById('previewAbout').textContent =
            document.getElementById('aboutDescription').value;

        document.getElementById('previewVision').textContent =
            document.getElementById('vision').value;

        document.getElementById('previewMission').textContent =
            document.getElementById('mission').value;
    }

    const bannerInput = document.getElementById('bannerInput');

    if (bannerInput) {
        bannerInput.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (e) {
                const previewBanner = document.getElementById('previewBanner');
                const previewBannerText = document.getElementById('previewBannerText');

                if (previewBanner) {
                    previewBanner.src = e.target.result;
                } else if (previewBannerText) {
                    previewBannerText.outerHTML = `<img id="previewBanner" src="${e.target.result}" alt="Preview Banner">`;
                }
            };

            reader.readAsDataURL(file);
        });
    }
</script>
@endpush
@endsection