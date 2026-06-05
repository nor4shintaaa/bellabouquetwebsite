@extends('layouts.pelanggan')

@section('title', 'Status Pesanan')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Status Pesanan</h1>
        <p>Pesanan yang sedang berjalan akan tampil di sini.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        @if($pesanan->count())
            <div class="order-grid">
                @foreach($pesanan as $order)
                    <div class="order-card">
                        <div class="order-card-header">
                            @if($order->product_image)
                                <img class="order-image" src="{{ str_starts_with($order->product_image, 'http') ? $order->product_image : asset('storage/' . $order->product_image) }}" alt="{{ $order->product_name }}">
                            @else
                                <div class="order-image" style="display:grid;place-items:center;">💐</div>
                            @endif

                            <div>
                                <h3 class="order-title">{{ $order->product_name }}</h3>
                                <div class="order-code">{{ $order->order_code }}</div>
                                <span class="badge-status {{ $order->status_class }}">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                        </div>

                        <div class="order-meta">
                            <div class="order-meta-item">
                                <span>Jumlah</span>
                                <strong>{{ $order->quantity }}</strong>
                            </div>

                            <div class="order-meta-item">
                                <span>Total</span>
                                <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
                            </div>

                            <div class="order-meta-item">
                                <span>Tanggal</span>
                                <strong>{{ $order->order_date?->format('d/m/Y') ?? '-' }}</strong>
                            </div>

                            <div class="order-meta-item">
                                <span>Pembayaran</span>
                                <strong>{{ $order->payment->status_label ?? 'Belum Bayar' }}</strong>
                            </div>
                        </div>

                        <div class="order-actions">
                            <a href="{{ route('pelanggan.pesanan.show', $order) }}" class="btn-secondary">Detail</a>

                            @if($order->canUploadPayment())
                                <a href="{{ route('pelanggan.bayar', $order) }}" class="btn-primary">Bayar</a>
                            @endif

                            @if($order->status === 'menunggu_pembayaran')
                                <form action="{{ route('pelanggan.pesanan.batal', $order) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-outline">Batalkan</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 28px;">
                {{ $pesanan->links() }}
            </div>
        @else
            <div class="empty-state">
                <h3>Belum ada pesanan aktif</h3>
                <p>Pesanan yang sedang berjalan akan muncul di sini setelah kamu membuat pesanan.</p>
                <a href="{{ route('pelanggan.produk') }}" class="btn-primary">Lihat Produk</a>
            </div>
        @endif
    </div>
</section>
@endsection