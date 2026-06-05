@extends('layouts.pelanggan')

@section('title', 'Simulasi Pembayaran')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Simulasi Pembayaran</h1>
        <p>Kirim metode pembayaran dan bukti pembayaran simulasi agar bisa dikonfirmasi admin.</p>
    </div>
</section>

<section class="section">
    <div class="container payment-layout">
        <div class="payment-summary">
            @if($order->product_image)
                <img src="{{ str_starts_with($order->product_image, 'http') ? $order->product_image : asset('storage/' . $order->product_image) }}" alt="{{ $order->product_name }}">
            @else
                <div class="product-placeholder">💐</div>
            @endif

            <h2>{{ $order->product_name }}</h2>
            <p class="order-code">{{ $order->order_code }}</p>

            <div class="detail-list">
                <div class="detail-row">
                    <span>Jumlah</span>
                    <strong>{{ $order->quantity }}</strong>
                </div>

                <div class="detail-row">
                    <span>Total</span>
                    <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </div>

                <div class="detail-row">
                    <span>Status</span>
                    <strong>{{ $order->status_label }}</strong>
                </div>
            </div>
        </div>

        <div class="payment-form-card">
            <form action="{{ route('pelanggan.bayar.store', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="summary-box">
                    <strong>Catatan:</strong>
                    Ini hanya simulasi pembayaran untuk kebutuhan project. Tidak terhubung ke payment gateway asli.
                </div>

                <div class="form-group">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="method" class="form-select" required>
                        <option value="">Pilih metode pembayaran</option>
                        <option value="transfer_bank">Transfer Bank</option>
                        <option value="e_wallet">E-Wallet</option>
                        <option value="cod">COD</option>
                    </select>
                    @error('method') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Upload Bukti Pembayaran</label>
                    <input type="file" name="proof_image" class="form-input" accept="image/*">
                    <p style="color:#64748b; font-size:13px; margin-top:8px;">
                        Wajib untuk Transfer Bank dan E-Wallet. Untuk COD boleh dikosongkan.
                    </p>
                    @error('proof_image') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="order-actions">
                    <a href="{{ route('pelanggan.pesanan.show', $order) }}" class="btn-secondary">Kembali</a>
                    <button type="submit" class="btn-primary">Kirim Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection