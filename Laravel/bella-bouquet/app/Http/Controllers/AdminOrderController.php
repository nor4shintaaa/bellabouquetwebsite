<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'payment', 'product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_code', 'like', '%' . $request->search . '%')
                    ->orWhere('product_name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($request) {
                        $userQuery->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $orders = $query->latest()->paginate(10)->appends($request->query());

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'payment', 'product']);

        return view('admin.orders.show', compact('order'));
    }

    public function confirmPayment(Order $order)
    {
        if (!$order->payment) {
            return back()->with('error', 'Pesanan ini belum memiliki data pembayaran.');
        }

        DB::transaction(function () use ($order) {
            $order->payment->update([
                'status' => 'diterima',
                'paid_at' => now(),
            ]);

            $order->update([
                'status' => 'diproses',
            ]);
        });

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi. Pesanan masuk status Diproses.');
    }

    public function rejectPayment(Order $order)
    {
        if (!$order->payment) {
            return back()->with('error', 'Pesanan ini belum memiliki data pembayaran.');
        }

        DB::transaction(function () use ($order) {
            $order->payment->update([
                'status' => 'ditolak',
                'paid_at' => null,
            ]);

            $order->update([
                'status' => 'menunggu_pembayaran',
            ]);
        });

        return back()->with('success', 'Pembayaran ditolak. Pelanggan dapat upload ulang bukti pembayaran.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:menunggu_pembayaran,menunggu_konfirmasi,diproses,siap_diambil,selesai,ditolak,dibatalkan',
            ],
        ]);

        DB::transaction(function () use ($order, $validated) {
            $newStatus = $validated['status'];

            if (in_array($newStatus, ['ditolak', 'dibatalkan'])) {
                $this->restoreStock($order);
            }

            $order->update([
                'status' => $newStatus,
            ]);
        });

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    private function restoreStock(Order $order): void
    {
        if ($order->stock_restored_at || !$order->product_id) {
            return;
        }

        $product = Product::find($order->product_id);

        if ($product) {
            $product->increment('stok', $order->quantity);
            $product->refresh();
            $product->updateStockStatus();
        }

        $order->update([
            'stock_restored_at' => now(),
        ]);
    }
}