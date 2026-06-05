<footer class="customer-footer">
    <div class="footer-grid">
        <div>
            <h3>Bella Bouquet</h3>
            <p>
                {{ $siteSetting->footer_text ?? 'Bella Bouquet menyediakan berbagai pilihan bouquet cantik untuk wisuda, ulang tahun, hadiah spesial, dan momen berkesan lainnya.' }}
            </p>
        </div>

        <div>
            <h4>Menu</h4>
            <div class="footer-links">
                <a href="{{ route('pelanggan.index') }}">Beranda</a>
                <a href="{{ route('pelanggan.produk') }}">Produk</a>
                <a href="{{ route('pelanggan.status') }}">Status Pesanan</a>
                <a href="{{ route('pelanggan.riwayat') }}">Riwayat</a>
            </div>
        </div>

        <div>
            <h4>Kontak</h4>
            <p>WhatsApp: +62 {{ $siteSetting->whatsapp ?? '8xxxxxxxxxx' }}</p>
            <p>Email: {{ $siteSetting->email ?? 'bellabouquet@gmail.com' }}</p>
            <p>Alamat: {{ $siteSetting->address ?? 'Jember, Jawa Timur' }}</p>
        </div>
    </div>

    <div class="footer-bottom">
        © {{ date('Y') }} Bella Bouquet. All rights reserved.
    </div>
</footer>