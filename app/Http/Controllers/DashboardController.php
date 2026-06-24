<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view with summaries.
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();
        
        // Define low stock alert threshold (e.g. less than 10 units)
        $lowStockThreshold = 10;
        $lowStockAlerts = Product::where('current_stock', '<', $lowStockThreshold)->get();
        
        $recentTransactions = Transaction::with(['product', 'supplier'])
            ->orderBy('transaction_date', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'lowStockAlerts',
            'recentTransactions',
            'lowStockThreshold'
        ));
    }
}
