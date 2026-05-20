<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $skipIncrement = $request->session()->pull('skip_visit_increment', false);

        if (!$skipIncrement) {
            $visitCount = $request->session()->get('dashboard_visit_count', 0) + 1;

            if (!$request->session()->has('dashboard_first_visit')) {
                $request->session()->put('dashboard_first_visit', now()->translatedFormat('d F Y H:i:s'));
            }

            $request->session()->put('dashboard_visit_count', $visitCount);
            $request->session()->put('dashboard_last_visit', now()->translatedFormat('d F Y H:i:s'));
        }

        $visitData = [
            'count' => $request->session()->get('dashboard_visit_count', 0),
            'first' => $request->session()->get('dashboard_first_visit', '-'),
            'last' => $request->session()->get('dashboard_last_visit', '-'),
        ];


        $products = Product::all();

        $totalProduk = $products->count();

        $totalInventaris = $products->sum(function ($product) {
            return $product->harga * $product->stok;
        });

        $stokMenipis = $products->where('stok', '<', 5)->count();

        $terjual = 124;

        $stats = [
            [
                'label' => 'Total Produk',
                'value' => $totalProduk,
                'icon' => 'package',
            ],
            [
                'label' => 'Total Nilai Inventaris',
                'value' => 'Rp ' . number_format($totalInventaris, 0, ',', '.'),
                'icon' => 'dollar-sign',
            ],
            [
                'label' => 'Stok Menipis (< 5)',
                'value' => $stokMenipis,
                'icon' => 'alert-circle',
                'alert' => true,
            ],
            [
                'label' => 'Terjual (Bulan Ini)',
                'value' => $terjual,
                'icon' => 'trending-up',
            ],
        ];

        $recentProducts = Product::latest()->take(3)->get();

        return view('dashboard', compact('stats', 'recentProducts', 'visitData'));
    }



    public function resetKunjungan(Request $request)
    {
        $request->session()->forget([
            'dashboard_visit_count',
            'dashboard_first_visit',
            'dashboard_last_visit',
        ]);

        $request->session()->put('skip_visit_increment', true);

        return redirect()->route('dashboard')->with('success', 'Hitungan kunjungan berhasil direset!');
    }



    public function produk(Request $request)
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

        if (view()->exists('produk.index')) {
            $products = $query->latest()->paginate(10)->appends($request->query());
            return view('produk.index', compact('products'));
        }

        $products = $query->latest()->get();

        return view('produk', compact('products'));
    }

    public function create()
    {
        $view = view()->exists('produk.create') ? 'produk.create' : 'produk_form';

        return view($view);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:products,kode_produk',
            'nama' => 'required',
            'kategori' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar_url' => 'nullable|url',
        ]);

        $data = $request->all();

        $data['status'] = $data['stok'] < 5 ? 'Menipis' : 'Tersedia';

        Product::create($data);

        return redirect()
            ->route($this->produkRedirectRoute())
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $view = view()->exists('produk.edit') ? 'produk.edit' : 'produk_form';

        return view($view, compact('product'))->with('produk', $product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'kode_produk' => 'required|unique:products,kode_produk,' . $product->id,
            'nama' => 'required',
            'kategori' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar_url' => 'nullable|url',
        ]);

        $data = $request->all();

        $data['status'] = $data['stok'] < 5 ? 'Menipis' : 'Tersedia';

        $product->update($data);

        return redirect()
            ->route($this->produkRedirectRoute())
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Product::destroy($id);

        return redirect()
            ->route($this->produkRedirectRoute())
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function tentang()
    {
        return view('tentang');
    }

    private function produkRedirectRoute()
    {
        return Route::has('produk') ? 'produk' : 'produk.index';
    }
}