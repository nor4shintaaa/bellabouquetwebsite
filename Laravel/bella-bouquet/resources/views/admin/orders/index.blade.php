@extends('layouts.app')

@section('content')
<style>
    .admin-order-card {
        background: var(--white);
        border: 1px solid var(--slate-100);
        border-radius: 24px;
        padding: 28px;
        box-shadow: var(--shadow-sm);
    }

    .admin-filter {
        display: grid;
        grid-template-columns: 1fr 220px 130px;
        gap: 14px;
        margin-bottom: 24px;
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

    .admin-table-wrap {
        overflow-x: auto;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .admin-table th,
    .admin-table td {
        padding: 16px;
        border-bottom: 1px solid var(--slate-100);
        text-align: left;
        font-size: 0.9rem;
    }

    .admin-table th {
        color: var(--slate-500);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-admin-primary {
        background: #f43f5e;
        color: white;
        padding: 12px 18px;
        border-radius: 12px;
        font-weight: 900;
        display: inline-block;
    }

    .btn-admin-secondary {
        background: #fff1f2;
        color: #be123c;
        padding: 10px 14px;
        border-radius: 12px;
        font-weight: 900;
        display: inline-block;
    }

    .admin-badge {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 900;
        background: #fff1f2;
        color: #be123c;
    }

    @media (max-width: 760px) {
        .admin-filter {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Pesanan Pelanggan</h1>
        <p class="page-subtitle">Kelola pesanan, pembayaran, dan status pesanan pelanggan.</p>
    </div>
</div>

<div class="admin-order-card">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="admin-filter">
        <input type="text" name="search" class="admin-input" placeholder="Cari kode, produk, pelanggan..." value="{{ request('search') }}">

        <select name="status" class="admin-input">
            <option value="">Semua Status</option>
            @foreach([
                'menunggu_pembayaran' => 'Menunggu Pembayaran',
                'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                'diproses' => 'Diproses',
                'siap_diambil' => 'Siap Diambil',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
                'dibatalkan' => 'Dibatalkan',
            ] as $value => $label)
                <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn-admin-primary">Filter</button>
    </form>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>{{ $order->order_code }}</strong></td>
                        <td>
                            {{ $order->user->name ?? '-' }}<br>
                            <span style="color:var(--slate-500); font-size:0.8rem;">{{ $order->user->email ?? '-' }}</span>
                        </td>
                        <td>{{ $order->product_name }}</td>
                        <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td><span class="admin-badge">{{ $order->status_label }}</span></td>
                        <td>{{ $order->payment->status_label ?? 'Belum Bayar' }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn-admin-secondary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; color:var(--slate-500); padding:32px;">
                            Belum ada pesanan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px;">
        {{ $orders->links() }}
    </div>
</div>
@endsection