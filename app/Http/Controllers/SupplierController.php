<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of suppliers.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        $allowedSorts = ['name', 'contact', 'address'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }

        $query = Supplier::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('contact', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

        $suppliers = $query->orderBy($sortBy, $sortOrder)->get();

        return view('suppliers.index', compact('suppliers', 'search', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new supplier.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created supplier in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
        ], [
            'name.required' => __('Nama pemasok wajib diisi.'),
            'name.max' => __('Nama pemasok tidak boleh lebih dari 255 karakter.'),
            'contact.required' => __('Kontak pemasok wajib diisi.'),
            'contact.max' => __('Kontak pemasok tidak boleh lebih dari 255 karakter.'),
            'address.required' => __('Alamat pemasok wajib diisi.'),
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', __('Pemasok berhasil ditambahkan.'));
    }

    /**
     * Display the specified supplier.
     */
    public function show(Supplier $supplier)
    {
        $supplier->load('transactions.product');
        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified supplier.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
        ], [
            'name.required' => __('Nama pemasok wajib diisi.'),
            'name.max' => __('Nama pemasok tidak boleh lebih dari 255 karakter.'),
            'contact.required' => __('Kontak pemasok wajib diisi.'),
            'contact.max' => __('Kontak pemasok tidak boleh lebih dari 255 karakter.'),
            'address.required' => __('Alamat pemasok wajib diisi.'),
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')->with('success', __('Pemasok berhasil diubah.'));
    }

    /**
     * Remove the specified supplier from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', __('Pemasok berhasil dihapus.'));
    }
}
