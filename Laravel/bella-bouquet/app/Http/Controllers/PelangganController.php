<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function index()
    {
        $produkUnggulan = Product::aktif()
            ->latest()
            ->take(4)
            ->get();

        $pesananAktif = collect();

        if (auth()->check() && auth()->user()->role === 'pelanggan') {
            $pesananAktif = Order::where('user_id', auth()->id())
                ->whereIn('status', [
                    'menunggu_pembayaran',
                    'menunggu_konfirmasi',
                    'diproses',
                    'siap_diambil',
                ])
                ->latest()
                ->take(3)
                ->get();
        }

        return view('pelanggan.index', compact('produkUnggulan', 'pesananAktif'));
    }

    public function produk(Request $request)
    {
        $query = Product::aktif();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_produk', 'like', '%' . $request->search . '%')
                    ->orWhere('kategori', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $produk = $query->latest()->get();

        $kategoriList = Product::aktif()
            ->select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori');

        return view('pelanggan.produk', compact('produk', 'kategoriList'));
    }

    public function showProduk(Product $product)
    {
        abort_if(!$product->is_active, 404);

        return view('pelanggan.detail-produk', compact('product'));
    }

    public function pesan(Product $product)
    {
        abort_if(!$product->is_active, 404);

        return view('pelanggan.pesan', compact('product'));
    }

    public function storePesan(Request $request, Product $product)
    {
        abort_if(!$product->is_active, 404);

        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:30'],
            'quantity' => ['required', 'integer', 'min:1'],
            'order_date' => ['required', 'date', 'after_or_equal:today'],
            'delivery_method' => ['required', 'in:ambil,kirim'],
            'address' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $product->refresh();

        if ($validated['quantity'] > $product->stok) {
            return back()
                ->withInput()
                ->with('error', 'Jumlah pesanan melebihi stok produk yang tersedia.');
        }

        $order = DB::transaction(function () use ($validated, $product) {
            $total = $product->harga * $validated['quantity'];

            $order = Order::create([
                'order_code' => 'BBQ-' . now()->format('YmdHis') . '-' . random_int(100, 999),
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'product_name' => $product->nama,
                'product_category' => $product->kategori,
                'product_image' => $product->gambar_url,
                'quantity' => $validated['quantity'],
                'unit_price' => $product->harga,
                'total_price' => $total,
                'phone' => $validated['phone'],
                'delivery_method' => $validated['delivery_method'],
                'order_date' => $validated['order_date'],
                'address' => $validated['address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'menunggu_pembayaran',
            ]);

            $product->decrement('stok', $validated['quantity']);
            $product->refresh();
            $product->updateStockStatus();

            return $order;
        });

        return redirect()
            ->route('pelanggan.bayar', $order)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan simulasi pembayaran.');
    }

    public function status()
    {
        $pesanan = Order::with(['payment', 'product'])
            ->where('user_id', auth()->id())
            ->whereIn('status', [
                'menunggu_pembayaran',
                'menunggu_konfirmasi',
                'diproses',
                'siap_diambil',
            ])
            ->latest()
            ->paginate(10);

        return view('pelanggan.status', compact('pesanan'));
    }

    public function riwayat()
    {
        $riwayat = Order::with(['payment', 'product'])
            ->where('user_id', auth()->id())
            ->whereIn('status', [
                'selesai',
                'ditolak',
                'dibatalkan',
            ])
            ->latest()
            ->paginate(10);

        return view('pelanggan.riwayat', compact('riwayat'));
    }

    public function detailPesanan(Order $order)
    {
        $this->authorizeCustomerOrder($order);

        $order->load(['payment', 'product']);

        return view('pelanggan.detail-pesanan', compact('order'));
    }

    public function bayar(Order $order)
    {
        $this->authorizeCustomerOrder($order);

        $order->load('payment');

        if (!$order->canUploadPayment()) {
            return redirect()
                ->route('pelanggan.pesanan.show', $order)
                ->with('error', 'Pembayaran untuk pesanan ini tidak dapat diubah.');
        }

        return view('pelanggan.bayar', compact('order'));
    }

    public function storeBayar(Request $request, Order $order)
    {
        $this->authorizeCustomerOrder($order);

        if (!$order->canUploadPayment()) {
            return redirect()
                ->route('pelanggan.pesanan.show', $order)
                ->with('error', 'Pembayaran untuk pesanan ini tidak dapat diubah.');
        }

        $validated = $request->validate([
            'method' => ['required', 'in:transfer_bank,e_wallet,cod'],
            'proof_image' => ['required_unless:method,cod', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $proofPath = optional($order->payment)->proof_image;

        if ($request->hasFile('proof_image')) {
            if ($proofPath) {
                Storage::disk('public')->delete($proofPath);
            }

            $proofPath = $request->file('proof_image')->store('payment_proofs', 'public');
        }

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'method' => $validated['method'],
                'proof_image' => $proofPath,
                'status' => 'menunggu_konfirmasi',
            ]
        );

        $order->update([
            'status' => 'menunggu_konfirmasi',
        ]);

        return redirect()
            ->route('pelanggan.status')
            ->with('success', 'Simulasi pembayaran berhasil dikirim. Tunggu konfirmasi admin.');
    }

    public function batalPesanan(Order $order)
    {
        $this->authorizeCustomerOrder($order);

        if ($order->status !== 'menunggu_pembayaran') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        DB::transaction(function () use ($order) {
            $this->restoreStock($order);

            $order->update([
                'status' => 'dibatalkan',
            ]);
        });

        return redirect()
            ->route('pelanggan.riwayat')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function profil()
    {
        $user = auth()->user();

        return view('pelanggan.profil', compact('user'));
    }

    private function authorizeCustomerOrder(Order $order): void
    {
        abort_if($order->user_id !== auth()->id(), 403);
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