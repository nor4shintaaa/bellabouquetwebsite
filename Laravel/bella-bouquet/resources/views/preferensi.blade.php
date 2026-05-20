@extends('layouts.app')

@section('content')
<style>
    .preference-wrapper {
        max-width: 760px;
        margin: 0 auto;
    }

    .preference-card {
        background: var(--white);
        border: 1px solid var(--slate-100);
        border-radius: 24px;
        padding: 32px;
        box-shadow: var(--shadow-sm);
    }

    .preference-title {
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 8px;
    }

    .preference-desc {
        color: var(--slate-500);
        font-weight: 600;
        margin-bottom: 32px;
        line-height: 1.6;
    }

    .preference-row {
        margin-bottom: 24px;
    }

    .preference-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 900;
        color: var(--slate-400);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .btn-save-preference {
        width: 100%;
        padding: 15px;
        border-radius: 16px;
        background: #9f1239;
        color: white;
        font-weight: 900;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .btn-save-preference:hover {
        background: #be123c;
        transform: translateY(-2px);
    }

    .preference-alert {
        display: none;
        margin-top: 20px;
        padding: 14px 18px;
        border-radius: 16px;
        background: #dcfce7;
        color: #166534;
        font-weight: 800;
        font-size: 0.9rem;
    }

    html.dark .preference-alert {
        background: #052e16;
        color: #bbf7d0;
    }
</style>

<div class="preference-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title">Preferensi Tampilan</h1>
            <p class="page-subtitle">Atur tema dan ukuran font untuk halaman admin Bella Bouquet.</p>
        </div>
    </div>

    <div class="preference-card">
        <h2 class="preference-title">Pengaturan Tema</h2>
        <p class="preference-desc">
            Pilihan ini akan disimpan ke cookie browser. Laravel juga membaca cookie lama dari request,
            lalu mengembalikan JSON sebagai konfirmasi.
        </p>

        <form id="preferenceForm">
            @csrf

            <div class="preference-row">
                <label for="theme" class="preference-label">Pilih Tema</label>
                <select name="theme" id="theme" class="preference-select">
                    <option value="light" {{ $theme === 'light' ? 'selected' : '' }}>Light</option>
                    <option value="dark" {{ $theme === 'dark' ? 'selected' : '' }}>Dark</option>
                    <option value="system" {{ $theme === 'system' ? 'selected' : '' }}>System</option>
                </select>
            </div>

            <div class="preference-row">
                <label for="font_size" class="preference-label">Ukuran Font</label>
                <select name="font_size" id="font_size" class="preference-select">
                    <option value="small" {{ $fontSize === 'small' ? 'selected' : '' }}>Small</option>
                    <option value="normal" {{ $fontSize === 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="large" {{ $fontSize === 'large' ? 'selected' : '' }}>Large</option>
                </select>
            </div>

            <button type="submit" class="btn-save-preference">
                Simpan Preferensi
            </button>
        </form>

        <div id="preferenceAlert" class="preference-alert"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('preferenceForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const alertBox = document.getElementById('preferenceAlert');

        try {
            const response = await fetch("{{ route('preferensi.save') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json"
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                setCookie('bella_theme', formData.get('theme'), 30);
                setCookie('bella_font_size', formData.get('font_size'), 30);
                applyTheme();

                alertBox.style.display = 'block';
                alertBox.textContent = result.message + ' Tema: ' + result.cookie_baru.theme + ', Font: ' + result.cookie_baru.font_size;
            }
        } catch (error) {
            alertBox.style.display = 'block';
            alertBox.textContent = 'Gagal menyimpan preferensi. Coba ulangi lagi.';
        }
    });
</script>
@endpush