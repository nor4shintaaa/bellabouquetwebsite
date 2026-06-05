@extends('layouts.pelanggan')

@section('title', 'Pesan Produk')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Form Pemesanan</h1>
        <p>Isi data pemesanan bouquet. Setelah pesanan dibuat, kamu akan diarahkan ke simulasi pembayaran.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="payment-layout">
            <div class="payment-summary">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->nama }}">
                @else
                    <div class="product-placeholder">💐</div>
                @endif

                <h2>{{ $product->nama }}</h2>
                <p class="product-meta">{{ $product->kategori }}</p>
                <div class="detail-price">Rp{{ number_format($product->harga, 0, ',', '.') }}</div>

                <div class="detail-list">
                    <div class="detail-row">
                        <span>Stok</span>
                        <strong>{{ $product->stok }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>Status</span>
                        <strong>{{ $product->status }}</strong>
                    </div>
                </div>
            </div>

            <div class="payment-form-card">
                <form action="{{ route('pelanggan.pesan.store', $product) }}" method="POST">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-input" value="{{ auth()->user()->name }}" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" value="{{ auth()->user()->email }}" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" class="form-input" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" required>
                            @error('phone') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-input" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="{{ $product->stok }}" required>
                            @error('quantity') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Pengambilan / Pengiriman</label>
                            <input type="date" class="form-input" name="order_date" value="{{ old('order_date') }}" required>
                            @error('order_date') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Metode Pengambilan</label>
                            <select name="delivery_method" class="form-select" required>
                                <option value="ambil" {{ old('delivery_method') === 'ambil' ? 'selected' : '' }}>Ambil di tempat</option>
                                <option value="kirim" {{ old('delivery_method') === 'kirim' ? 'selected' : '' }}>Dikirim</option>
                            </select>
                            @error('delivery_method') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label">Alamat / Catatan</label>
                            <textarea name="address" rows="3" class="form-textarea" placeholder="Isi alamat jika memilih dikirim.">{{ old('address') }}</textarea>
                            @error('address') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group full">
                            <label class="form-label">Catatan Request Bouquet</label>
                            <textarea name="notes" rows="4" class="form-textarea" placeholder="Contoh: warna pita pink, ucapan Happy Graduation, dll.">{{ old('notes') }}</textarea>
                            @error('notes') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group full">
                            <div class="summary-box">
                                Total sementara:
                                <strong id="totalPrice">Rp{{ number_format($product->harga, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="order-actions">
                        <a href="{{ route('pelanggan.produk.show', $product) }}" class="btn-secondary">Batal</a>
                        <button type="submit" class="btn-primary">Buat Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const quantityInput = document.getElementById('quantity');
    const totalPrice = document.getElementById('totalPrice');
    const price = {{ (int) $product->harga }};

    if (quantityInput && totalPrice) {
        quantityInput.addEventListener('input', function () {
            let quantity = parseInt(this.value) || 1;
            let total = price * quantity;

            totalPrice.textContent = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);
        });
    }
</script>
@endpush