@extends('layouts.app')

@section('content')
<style>
    .splash-container {
        height: 80vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        background-color: #fffafb; /* Tema soft pink Bella */
    }

    .welcome-text {
        font-size: 2.5rem;
        font-weight: 900;
        color: #1e293b;
        margin-bottom: 16px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s forwards;
    }

    .welcome-text span {
        color: #f472b6;
    }

    .loader-line {
        width: 200px;
        height: 4px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 24px;
    }

    .loader-progress {
        width: 0%;
        height: 100%;
        background: #9f1239;
        animation: loadingBar 2.5s ease-in-out forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes loadingBar {
        to { width: 100%; }
    }
</style>

<div class="splash-container">
    <div class="welcome-text">
        Selamat Datang, <span>{{ auth()->user()->name }}</span>!
    </div>
    <p style="color: #64748b; font-weight: 600;">Menyiapkan dashboard Anda...</p>
    
    <div class="loader-line">
        <div class="loader-progress"></div>
    </div>
</div>

<script>
    // Logika pindah halaman otomatis setelah 3 detik
    setTimeout(function() {
        window.location.href = "{{ route('dashboard') }}";
    }, 5000);
</script>
@endsection