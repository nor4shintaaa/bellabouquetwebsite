<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //  TUGAS 5 POIN 4: Ambil semua data dengan paginate(10)
    public function index(Request $request)
    {
        $query = Product::query();

        // Fitur Pencarian (Opsional tambahan agar UX tetap bagus)
        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('kode_produk', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('kategori')) {
            $query->whereIn('kategori', $request->kategori);
        }

        // Paginate 10 data per halaman
        $products = $query->latest()->paginate(10)->appends($request->query());

        // Arahkan ke folder produk/index.blade.php
        return view('produk.index', compact('products'));
    }

    //  TUGAS 5 POIN 5: Menampilkan form tambah
    public function create()
    {
        return view('produk.create');
    }

    //  TUGAS 5 POIN 5 & 9: Proses Simpan dengan Validasi & Upload Foto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|unique:products,kode_produk',
            'nama' => 'required|min:3',
            'kategori' => 'required|in:Flower,Snack,Money,Doll',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,png|max:2048' // Validasi Foto (Bonus)
        ]);

        // Atur status otomatis
        $validated['status'] = $validated['stok'] < 5 ? 'Menipis' : 'Tersedia';
        $validated['is_active'] = $request->has('is_active');

        // Proses Upload Foto
        if ($request->hasFile('gambar')) {
            $validated['gambar_url'] = $request->file('gambar')->store('produk_images', 'public');
        }

        Product::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    //  TUGAS 5 POIN 3 & Tips: Route Model Binding untuk halaman Detail
    public function show(Product $produk)
    {
        return view('produk.show', compact('produk'));
    }

    //  TUGAS 5 POIN 6: Menampilkan form edit pre-filled
    public function edit(Product $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    //  TUGAS 5 POIN 6: Proses Update dengan Ignore Unique ID
    public function update(Request $request, Product $produk)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|unique:products,kode_produk,' . $produk->id, // Abaikan ID ini
            'nama' => 'required|min:3',
            'kategori' => 'required|in:Flower,Snack,Money,Doll',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,png|max:2048'
        ]);

        $validated['status'] = $validated['stok'] < 5 ? 'Menipis' : 'Tersedia';
        $validated['is_active'] = $request->has('is_active');

        // Proses Update Foto
        if ($request->hasFile('gambar')) {
            // Hapus foto lama jika ada
            if ($produk->gambar_url && !str_starts_with($produk->gambar_url, 'http')) {
                Storage::disk('public')->delete($produk->gambar_url);
            }
            $validated['gambar_url'] = $request->file('gambar')->store('produk_images', 'public');
        }

        $produk->update($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    //  TUGAS 5 POIN 7: Hapus data
    public function destroy(Product $produk)
    {
        // Hapus file fisik foto jika ada
        if ($produk->gambar_url && !str_starts_with($produk->gambar_url, 'http')) {
            Storage::disk('public')->delete($produk->gambar_url);
        }
        
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}