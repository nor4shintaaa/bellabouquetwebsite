@extends('layouts.pelanggan')

@section('title', 'Detail Pesanan')

@section('content')
@php
    $isActiveOrder = in_array($order->status, [
        'menunggu_pembayaran',
        'menunggu_konfirmasi',
        'diproses',
        'siap_diambil',
    ]);

    $canUploadPayment = $order->status === 'menunggu_pembayaran'
        || optional($order->payment)->status === 'ditolak';

    $statusLabels = [
        'menunggu_pembayaran' => 'Menunggu Pembayaran',
        'menunggu_konfirmasi' => 'Menunggu Konfirmasi Admin',
        'diproses' => 'Diproses',
        'siap_diambil' => 'Siap Diambil',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
        'dibatalkan' => 'Dibatalkan',
    ];

    $paymentStatusLabels = [
        'belum_bayar' => 'Belum Bayar',
        'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
        'diterima' => 'Diterima',
        'ditolak' => 'Ditolak',
    ];

    $paymentMethodLabels = [
        'transfer_bank' => 'Transfer Bank',
        'e_wallet' => 'E-Wallet',
        'cod' => 'COD',
    ];

    $statusLabel = $order->status_label ?? ($statusLabels[$order->status] ?? 'Tidak Diketahui');

    $statusClass = $order->status_class ?? match ($order->status) {
        'menunggu_pembayaran' => 'warning',
        'menunggu_konfirmasi' => 'info',
        'diproses' => 'primary',
        'siap_diambil', 'selesai' => 'success',
        'ditolak', 'dibatalkan' => 'danger',
        default => 'secondary',
    };

    $paymentStatus = $order->payment
        ? ($order->payment->status_label ?? ($paymentStatusLabels[$order->payment->status] ?? 'Tidak Diketahui'))
        : 'Belum Bayar';

    $paymentMethod = $order->payment
        ? ($order->payment->method_label ?? ($paymentMethodLabels[$order->payment->method] ?? '-'))
        : '-';

    $productImage = null;

    if ($order->product_image) {
        if (str_starts_with($order->product_image, 'http')) {
            $productImage = $order->product_image;
        } elseif (str_starts_with($order->product_image, '/storage/')) {
            $productImage = $order->product_image;
        } elseif (str_starts_with($order->product_image, 'storage/')) {
            $productImage = asset($order->product_image);
        } else {
            $productImage = asset('storage/' . $order->product_image);
        }
    }
@endphp

<section class="page-header">
    <div class="container">
        <h1>Detail Pesanan</h1>
        <p>Lihat rincian pesanan, pembayaran, dan status pesanan kamu.</p>
    </div>
</section>

<section class="section">
    <div class="container payment-layout">
        <div class="order-detail-card">
            @if($productImage)
                <img src="{{ $productImage }}" alt="{{ $order->product_name }}">
            @else
                <div class="product-placeholder">💐</div>
            @endif

            <h2>{{ $order->product_name }}</h2>
            <p class="order-code">{{ $order->order_code }}</p>

            <span class="badge-status {{ $statusClass }}">
                {{ $statusLabel }}
            </span>

            <div class="summary-box" style="margin-top: 22px;">
                <strong>Total Pesanan:</strong>
                <br>
                Rp{{ number_format($order->total_price, 0, ',', '.') }}
            </div>

            <div class="summary-box">
                <strong>Status Pembayaran:</strong>
                <br>
                {{ $paymentStatus }}
            </div>
        </div>

        <div class="order-detail-card">
            <h2>Rincian Pesanan</h2>

            <div class="detail-list">
                <div class="detail-row">
                    <span>Nama Pelanggan</span>
                    <strong>{{ auth()->user()->name }}</strong>
                </div>

                <div class="detail-row">
                    <span>Email</span>
                    <strong>{{ auth()->user()->email }}</strong>
                </div>

                <div class="detail-row">
                    <span>No HP</span>
                    <strong>{{ $order->phone }}</strong>
                </div>

                <div class="detail-row">
                    <span>Kode Pesanan</span>
                    <strong>{{ $order->order_code }}</strong>
                </div>

                <div class="detail-row">
                    <span>Produk</span>
                    <strong>{{ $order->product_name }}</strong>
                </div>

                <div class="detail-row">
                    <span>Kategori</span>
                    <strong>{{ $order->product_category ?? '-' }}</strong>
                </div>

                <div class="detail-row">
                    <span>Jumlah</span>
                    <strong>{{ $order->quantity }}</strong>
                </div>

                <div class="detail-row">
                    <span>Harga Satuan</span>
                    <strong>Rp{{ number_format($order->unit_price, 0, ',', '.') }}</strong>
                </div>

                <div class="detail-row">
                    <span>Total Harga</span>
                    <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </div>

                <div class="detail-row">
                    <span>Metode Pengambilan</span>
                    <strong>
                        {{ $order->delivery_method === 'ambil' ? 'Ambil di tempat' : 'Dikirim' }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Tanggal Pengambilan / Pengiriman</span>
                    <strong>
                        {{ $order->order_date ? $order->order_date->format('d/m/Y') : '-' }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Status Pesanan</span>
                    <strong>{{ $statusLabel }}</strong>
                </div>

                <div class="detail-row">
                    <span>Metode Pembayaran</span>
                    <strong>{{ $paymentMethod }}</strong>
                </div>

                <div class="detail-row">
                    <span>Status Pembayaran</span>
                    <strong>{{ $paymentStatus }}</strong>
                </div>
            </div>

            @if($order->address)
                <div class="summary-box" style="margin-top: 18px;">
                    <strong>Alamat:</strong>
                    <br>
                    {{ $order->address }}
                </div>
            @endif

            @if($order->notes)
                <div class="summary-box" style="margin-top: 18px;">
                    <strong>Catatan Request:</strong>
                    <br>
                    {{ $order->notes }}
                </div>
            @endif

            @if($order->payment && $order->payment->proof_image)
                <h3 style="margin-top: 24px;">Bukti Pembayaran</h3>

                <img
                    class="proof-image"
                    src="{{ asset('storage/' . $order->payment->proof_image) }}"
                    alt="Bukti Pembayaran"
                >
            @endif

            <div class="order-actions">
                @if($isActiveOrder)
                    <a href="{{ route('pelanggan.status') }}" class="btn-secondary">
                        Kembali ke Status
                    </a>
                @else
                    <a href="{{ route('pelanggan.riwayat') }}" class="btn-secondary">
                        Kembali ke Riwayat
                    </a>
                @endif

                @if($canUploadPayment)
                    <a href="{{ route('pelanggan.bayar', $order) }}" class="btn-primary">
                        Bayar / Upload Bukti
                    </a>
                @endif

                @if($order->status === 'menunggu_pembayaran')
                    <form
                        action="{{ route('pelanggan.pesanan.batal', $order) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')"
                    >
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="btn-outline">
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection