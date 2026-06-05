<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pelanggan') - Bella Bouquet</title>
    <link rel="stylesheet" href="{{ asset('css/pelanggan.css') }}">
</head>
<body class="customer-body">
    @include('pelanggan.partials.navbar')

    @if(session('success') || session('error'))
        <div class="container" style="margin-top: 20px;">
            @if(session('success'))
                <div class="customer-alert success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="customer-alert error">{{ session('error') }}</div>
            @endif
        </div>
    @endif

    <main class="customer-main">
        @yield('content')
    </main>

    @include('pelanggan.partials.footer')

    @stack('scripts')

    <script>
        const navToggle = document.getElementById('customerNavToggle');
        const navMenu = document.getElementById('customerNavMenu');

        if (navToggle && navMenu) {
            navToggle.addEventListener('click', function () {
                navMenu.classList.toggle('show');
            });
        }
    </script>
</body>
</html>