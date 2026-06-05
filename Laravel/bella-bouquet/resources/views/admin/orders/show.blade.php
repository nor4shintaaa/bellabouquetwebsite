@extends('layouts.app')

@section('content')
<style>
    .admin-detail-grid {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        gap: 24px;
        align-items: start;
    }

    .admin-card {
        background: var(--white);
        border: 1px solid var(--slate-100);
        border-radius: 24px;
        padding: 28px;
        box-shadow: var(--shadow-sm);
    }

    .admin-product-img {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border-radius: 18px;
        background: var(--slate-50);
        margin-bottom: 18px;
    }

    .detail-row-admin {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid var(--slate-100);
    }

    .detail-row-admin span {
        color: var(--slate-500);
        font-weight: 800;
    }

    .detail-row-admin strong {
        text-align: right;
    }

    .admin-input {
        width: 100%;
        padding: 14px 16px;
        border-radius: 14px;
        border: 1px solid var(--slate-200);
        background: var(--slate-50);
        color: var(--slate-800);
        font-weight: 700;
    }

    .admin-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .btn-admin-primary,
    .btn-admin-success,
    .btn-admin-danger,
    .btn-admin-secondary {
        padding: 12px 18px;
        border-radius: 12px;
        font-weight: 900;
        display: inline-block;
    }

    .btn-admin-primary {
        background: #f43f5e;
        color: white;
    }

    .btn-admin-success {
        background: #16a34a;
        color: white;
    }

    .btn-admin-danger {
        background: #e11d48;
        color: white;
    }

    .btn-admin-secondary {
        background: #fff1f2;
        color: #be123c;
    }

    .proof-img {
        width: 100%;
        max-width: 420px;
        border-radius: 18px;
        border: 1px solid var(--slate-100);
        margin-top: 14px;
    }

    @media (max-width: 900px) {
        .admin-detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Detail Pesanan</h1>
        <p class="page-subtitle">{{ $order->order_code }}</p>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="btn-admin-secondary">
        Kembali
    </a>
</div>

<div class="admin-detail-grid">
    <div class="admin-card">
        @if($order->product_image)
            <img class="admin-product-img" src="{{ str_starts_with($order->product_image, 'http') ? $order->product_image : asset('storage/' . $order->product_image) }}" alt="{{ $order->product_name }}">
        @else
            <div class="admin-product-img" style="display:grid;place-items:center;">No Image</div>
        @endif

        <h2>{{ $order->product_name }}</h2>

        <div class="detail-row-admin">
            <span>Kategori</span>
            <strong>{{ $order->product_category }}</strong>
        </div>

        <div class="detail-row-admin">
            <span>Jumlah</span>
            <strong>{{ $order->quantity }}</strong>
        </div>

        <div class="detail-row-admin">
            <span>Harga Satuan</span>
            <strong>Rp{{ number_format($order->unit_price, 0, ',', '.') }}</strong>
        </div>

        <div class="detail-row-admin">
            <span>Total</span>
            <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
        </div>

        <div class="detail-row-admin">
            <span>Status</span>
            <strong>{{ $order->status_label }}</strong>
        </div>
    </div>

    <div class="admin-card">
        <h2>Data Pelanggan</h2>

        <div class="detail-row-admin">
            <span>Nama</span>
            <strong>{{ $order->user->name ?? '-' }}</strong>
        </div>

        <div class="detail-row-admin">
            <span>Email</span>
            <strong>{{ $order->user->email ?? '-' }}</strong>
        </div>

        <div class="detail-row-admin">
            <span>No HP</span>
            <strong>{{ $order->phone }}</strong>
        </div>

        <div class="detail-row-admin">
            <span>Metode</span>
            <strong>{{ $order->delivery_method === 'ambil' ? 'Ambil di tempat' : 'Dikirim' }}</strong>
        </div>

        <div class="detail-row-admin">
            <span>Tanggal</span>
            <strong>{{ $order->order_date?->format('d/m/Y') ?? '-' }}</strong>
        </div>

        @if($order->address)
            <div style="margin-top:18px;">
                <strong>Alamat:</strong>
                <p style="color:var(--slate-500); line-height:1.7;">{{ $order->address }}</p>
            </div>
        @endif

        @if($order->notes)
            <div style="margin-top:18px;">
                <strong>Catatan:</strong>
                <p style="color:var(--slate-500); line-height:1.7;">{{ $order->notes }}</p>
            </div>
        @endif

        <hr style="border:0; border-top:1px solid var(--slate-100); margin:24px 0;">

        <h2>Pembayaran</h2>

        @if($order->payment)
            <div class="detail-row-admin">
                <span>Metode</span>
                <strong>{{ $order->payment->method_label }}</strong>
            </div>

            <div class="detail-row-admin">
                <span>Status</span>
                <strong>{{ $order->payment->status_label }}</strong>
            </div>

            @if($order->payment->proof_image)
                <p style="margin-top:18px;"><strong>Bukti Bayar:</strong></p>
                <img class="proof-img" src="{{ asset('storage/' . $order->payment->proof_image) }}" alt="Bukti Bayar">
            @endif

            @if($order->payment->status === 'menunggu_konfirmasi')
                <div class="admin-actions">
                    <form action="{{ route('admin.orders.confirmPayment', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-admin-success">Terima Pembayaran</button>
                    </form>

                    <form action="{{ route('admin.orders.rejectPayment', $order) }}" method="POST" onsubmit="return confirm('Tolak pembayaran ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-admin-danger">Tolak Pembayaran</button>
                    </form>
                </div>
            @endif
        @else
            <p style="color:var(--slate-500);">Pelanggan belum melakukan pembayaran.</p>
        @endif

        <hr style="border:0; border-top:1px solid var(--slate-100); margin:24px 0;">

        <h2>Ubah Status Pesanan</h2>

        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
            @csrf
            @method('PATCH')

            <select name="status" class="admin-input">
                @foreach([
                    'menunggu_pembayaran' => 'Menunggu Pembayaran',
                    'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                    'diproses' => 'Diproses',
                    'siap_diambil' => 'Siap Diambil',
                    'selesai' => 'Selesai',
                    'ditolak' => 'Ditolak',
                    'dibatalkan' => 'Dibatalkan',
                ] as $value => $label)
                    <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <div class="admin-actions">
                <button type="submit" class="btn-admin-primary">Simpan Status</button>
            </div>
        </form>
    </div>
</div>
@endsection