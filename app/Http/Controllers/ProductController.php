<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        $allowedSorts = ['name', 'color', 'current_stock', 'category_name'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }

        $query = Product::with('category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('color', 'like', '%' . $search . '%')
                  ->orWhere('unit', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function ($catQuery) use ($search) {
                      $catQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($sortBy === 'category_name') {
            $query->join('categories', 'products.category_id', '=', 'categories.id')
                  ->select('products.*')
                  ->orderBy('categories.name', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->get();

        return view('products.index', compact('products', 'search', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:255'],
            'current_stock' => ['nullable', 'integer', 'min:0'],
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'color.required' => 'Warna wajib diisi.',
            'color.max' => 'Warna tidak boleh lebih dari 255 karakter.',
            'unit.required' => 'Satuan wajib diisi.',
            'unit.max' => 'Satuan tidak boleh lebih dari 255 karakter.',
            'current_stock.integer' => 'Stok awal harus berupa angka.',
            'current_stock.min' => 'Stok awal tidak boleh kurang dari 0.',
        ]);

        $validated['current_stock'] = $validated['current_stock'] ?? 0;

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'transactions.supplier']);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:255'],
            'current_stock' => ['required', 'integer', 'min:0'],
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'color.required' => 'Warna wajib diisi.',
            'color.max' => 'Warna tidak boleh lebih dari 255 karakter.',
            'unit.required' => 'Satuan wajib diisi.',
            'unit.max' => 'Satuan tidak boleh lebih dari 255 karakter.',
            'current_stock.required' => 'Stok saat ini wajib diisi.',
            'current_stock.integer' => 'Stok saat ini harus berupa angka.',
            'current_stock.min' => 'Stok saat ini tidak boleh kurang dari 0.',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diubah.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
