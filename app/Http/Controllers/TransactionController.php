<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions.
     */
    /**
     * Display a listing of transactions.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'transaction_date');
        $sortOrder = $request->input('sort_order', 'desc');

        $allowedSorts = ['transaction_date', 'quantity', 'type', 'product_name'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'transaction_date';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query = Transaction::with(['product', 'supplier']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('type', 'like', '%' . $search . '%')
                  ->orWhere('notes', 'like', '%' . $search . '%')
                  ->orWhere('transaction_date', 'like', '%' . $search . '%')
                  ->orWhereHas('product', function ($prodQuery) use ($search) {
                      $prodQuery->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('supplier', function ($supQuery) use ($search) {
                      $supQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($sortBy === 'product_name') {
            $query->join('products', 'transactions.product_id', '=', 'products.id')
                  ->select('transactions.*')
                  ->orderBy('products.name', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $transactions = $query->get();
            
        return view('transactions.index', compact('transactions', 'search', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        
        return view('transactions.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created transaction in storage and update product stock.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:in,out,return'],
            'product_id' => ['required', 'exists:products,id'],
            'supplier_id' => ['required_if:type,in,return', 'nullable', 'exists:suppliers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'transaction_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ], [
            'type.required' => __('Tipe transaksi wajib dipilih.'),
            'type.in' => __('Tipe transaksi tidak valid.'),
            'product_id.required' => __('Produk wajib dipilih.'),
            'product_id.exists' => __('Produk tidak valid.'),
            'supplier_id.required_if' => __('Pemasok wajib dipilih untuk transaksi Masuk (IN) atau Retur (RETURN).'),
            'supplier_id.exists' => __('Pemasok tidak valid.'),
            'quantity.required' => __('Jumlah wajib diisi.'),
            'quantity.integer' => __('Jumlah harus berupa angka.'),
            'quantity.min' => __('Jumlah minimal adalah 1.'),
            'transaction_date.required' => __('Tanggal transaksi wajib diisi.'),
            'transaction_date.date' => __('Format tanggal transaksi tidak valid.'),
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Validasi kecukupan stok untuk transaksi keluar ('out') atau retur ('return')
        if (in_array($validated['type'], ['out', 'return'])) {
            if ($product->current_stock < $validated['quantity']) {
                return back()->withErrors([
                    'quantity' => __('Stok tidak mencukupi. Stok saat ini untuk produk ini adalah :stock :unit.', [
                        'stock' => $product->current_stock,
                        'unit' => $product->unit
                    ]),
                ])->withInput();
            }
        }

        // Execute transaction and stock adjustment atomically
        DB::transaction(function () use ($validated, $product) {
            // Create the transaction log
            Transaction::create($validated);

            // Update product stock: increase for 'in', decrease for 'out' and 'return'
            if ($validated['type'] === 'in') {
                $product->current_stock += $validated['quantity'];
            } else {
                $product->current_stock -= $validated['quantity'];
            }
            $product->save();
        });

        return redirect()->route('transactions.index')->with('success', __('Transaksi berhasil dicatat dan stok produk telah diperbarui.'));
    }

    /**
     * Display the specified transaction details.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['product', 'supplier']);
        return view('transactions.show', compact('transaction'));
    }
}
