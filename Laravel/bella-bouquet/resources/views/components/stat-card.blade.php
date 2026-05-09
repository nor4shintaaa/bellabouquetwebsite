@props(['judul', 'nilai', 'ikon', 'alert' => false])

<div class="stat-card">
    <div class="stat-header">
        <div class="stat-icon {{ $alert ? 'alert' : '' }}">
            <i data-lucide="{{ $ikon }}"></i>
        </div>
        <p class="stat-label">{{ $judul }}</p>
    </div>
    <h3 class="stat-value">{{ $nilai }}</h3>
</div>