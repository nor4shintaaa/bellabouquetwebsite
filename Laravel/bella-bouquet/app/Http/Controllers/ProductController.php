<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('kode_produk', 'like', '%' . $request->cari . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->whereIn('kategori', $request->kategori);
        }

        $products = $query->latest()->paginate(10)->appends($request->query());

        return view('produk.index', compact('products'));
    }

    public function liveSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        $kategori = $request->input('kategori', []);

        $query = Product::query();

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                  ->orWhere('kode_produk', 'like', '%' . $keyword . '%')
                  ->orWhere('kategori', 'like', '%' . $keyword . '%');
            });
        }

        if (!empty($kategori)) {
            $query->whereIn('kategori', $kategori);
        }

        $products = $query->latest()->limit(30)->get();

        $data = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'kode_produk' => $product->kode_produk,
                'nama' => $product->nama,
                'kategori' => $product->kategori,
                'stok' => $product->stok,
                'harga' => number_format($product->harga, 0, ',', '.'),
                'status' => $product->status,
                'gambar_url' => $product->gambar_url
                    ? (str_starts_with($product->gambar_url, 'http')
                        ? $product->gambar_url
                        : asset('storage/' . $product->gambar_url))
                    : null,
                'edit_url' => route('produk.edit', $product->id),
                'delete_url' => url('produk/' . $product->id),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data produk berhasil dicari tanpa reload halaman.',
            'total' => $products->count(),
            'products' => $data,
        ]);
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|unique:products,kode_produk',
            'nama' => 'required|min:3',
            'kategori' => 'required|in:Flower,Snack,Money,Doll',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,png|max:2048'
        ]);

        $validated['status'] = $validated['stok'] < 5 ? 'Menipis' : 'Tersedia';
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('gambar')) {
            $validated['gambar_url'] = $request->file('gambar')->store('produk_images', 'public');
        }

        Product::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $produk)
    {
        return view('produk.show', compact('produk'));
    }

    public function edit(Product $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Product $produk)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|unique:products,kode_produk,' . $produk->id,
            'nama' => 'required|min:3',
            'kategori' => 'required|in:Flower,Snack,Money,Doll',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,png|max:2048'
        ]);

        $validated['status'] = $validated['stok'] < 5 ? 'Menipis' : 'Tersedia';
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('gambar')) {
            if ($produk->gambar_url && !str_starts_with($produk->gambar_url, 'http')) {
                Storage::disk('public')->delete($produk->gambar_url);
            }

            $validated['gambar_url'] = $request->file('gambar')->store('produk_images', 'public');
        }

        $produk->update($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $produk)
    {
        if ($produk->gambar_url && !str_starts_with($produk->gambar_url, 'http')) {
            Storage::disk('public')->delete($produk->gambar_url);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}