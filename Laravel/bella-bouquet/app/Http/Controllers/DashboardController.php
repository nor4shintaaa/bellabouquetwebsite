<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $totalProduk = $products->count();
        $totalInventaris = $products->sum(function($product) { return $product->harga * $product->stok; });
        $stokMenipis = $products->where('stok', '<', 5)->count();
        $terjual = 124; 

        $stats = [
            ['label' => 'Total Produk', 'value' => $totalProduk, 'icon' => 'package'],
            ['label' => 'Total Nilai Inventaris', 'value' => 'Rp ' . number_format($totalInventaris, 0, ',', '.'), 'icon' => 'dollar-sign'],
            ['label' => 'Stok Menipis (< 5)', 'value' => $stokMenipis, 'icon' => 'alert-circle', 'alert' => true],
            ['label' => 'Terjual (Bulan Ini)', 'value' => $terjual, 'icon' => 'trending-up'],
        ];

        $recentProducts = Product::latest()->take(3)->get();
        return view('dashboard', compact('stats', 'recentProducts'));
    }

public function produk(Request $request)
    {
        $query = Product::query();
        
        // 1. Fitur Pencarian (Search Teks)
        if ($request->filled('cari')) {
            // Kita bungkus ke dalam function($q) agar logika OR tidak bertabrakan dengan filter Kategori
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('kode_produk', 'like', '%' . $request->cari . '%');
            });
        }

        // 2. Fitur Filter Kategori (Checkbox Multi-select)
        if ($request->filled('kategori')) {
            // whereIn digunakan karena $request->kategori bentuknya Array (bisa pilih lebih dari 1)
            $query->whereIn('kategori', $request->kategori);
        }

        $products = $query->latest()->get();

        return view('produk', compact('products'));
    }

    // --- FITUR CRUD BARU ---

    // 1. Menampilkan Form Tambah
    public function create()
    {
        return view('produk_form');
    }

    // 2. Memproses Data Tambah ke Database
public function store(Request $request)
    {
        // Validasi input (hapus validasi 'status')
        $request->validate([
            'kode_produk' => 'required|unique:products',
            'nama' => 'required',
            'kategori' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar_url' => 'required|url'
        ]);

        // Ambil semua data request
        $data = $request->all();
        
        // LOGIKA OTOMATIS: Jika stok di bawah 5, status Menipis. Jika tidak, Tersedia.
        $data['status'] = $data['stok'] < 5 ? 'Menipis' : 'Tersedia';

        // Menyimpan data ke tabel products
        Product::create($data);

        return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 3. Menampilkan Form Edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('produk_form', compact('product'));
    }

    // 4. Memproses Perubahan Data (Update)
public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        // Validasi input (hapus validasi 'status')
        $request->validate([
            'kode_produk' => 'required|unique:products,kode_produk,' . $product->id,
            'nama' => 'required',
            'kategori' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar_url' => 'required|url'
        ]);

        // Ambil semua data request
        $data = $request->all();
        
        // LOGIKA OTOMATIS: Menentukan ulang status saat diedit
        $data['status'] = $data['stok'] < 5 ? 'Menipis' : 'Tersedia';

        // Mengupdate data di database
        $product->update($data);

        return redirect()->route('produk')->with('success', 'Produk berhasil diperbarui!');
    }

    // 5. Menghapus Data
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('produk')->with('success', 'Produk berhasil dihapus!');
    }

    public function tentang()
    {
        return view('tentang');
    }
}