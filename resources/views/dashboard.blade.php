@extends('layouts.app')

@section('page_title', __('Ringkasan Dasbor'))

@section('content')
<div class="space-y-8">

    <!-- Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Products Summary -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-md dark:shadow-xl relative overflow-hidden group hover:border-slate-300 dark:hover:border-slate-700 transition duration-200">
            <div class="absolute -right-4 -bottom-4 text-slate-200 dark:text-slate-800/10 group-hover:scale-110 transition duration-200">
                <svg class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('Total Produk') }}</p>
            <h3 class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $totalProducts }}</h3>
            <div class="mt-4 flex items-center text-xs text-indigo-600 dark:text-indigo-400 font-medium">
                <a href="{{ route('products.index') }}" class="hover:underline flex items-center">
                    {{ __('Lihat daftar') }}
                    <svg class="ml-1 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Low Stock Alerts -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-md dark:shadow-xl relative overflow-hidden group hover:border-slate-300 dark:hover:border-slate-700 transition duration-200">
            <div class="absolute -right-4 -bottom-4 text-slate-200 dark:text-slate-800/10 group-hover:scale-110 transition duration-200">
                <svg class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('Peringatan Stok') }}</p>
            <h3 class="mt-2 text-3xl font-extrabold tracking-tight {{ $lowStockAlerts->count() > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-slate-900 dark:text-slate-300' }}">
                {{ $lowStockAlerts->count() }}
            </h3>
            <div class="mt-4 flex items-center text-xs font-medium">
                <span class="{{ $lowStockAlerts->count() > 0 ? 'text-amber-600 dark:text-amber-400/80' : 'text-slate-500' }}">
                    {{ __('Batas minimum:') }} &lt; {{ $lowStockThreshold }} {{ __('unit') }}
                </span>
            </div>
        </div>

        <!-- Categories Summary -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-md dark:shadow-xl relative overflow-hidden group hover:border-slate-300 dark:hover:border-slate-700 transition duration-200">
            <div class="absolute -right-4 -bottom-4 text-slate-200 dark:text-slate-800/10 group-hover:scale-110 transition duration-200">
                <svg class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
            </div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('Kategori') }}</p>
            <h3 class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $totalCategories }}</h3>
            <div class="mt-4 flex items-center text-xs text-indigo-600 dark:text-indigo-400 font-medium">
                <a href="{{ route('categories.index') }}" class="hover:underline flex items-center">
                    {{ __('Lihat kategori') }}
                    <svg class="ml-1 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Suppliers Summary -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-md dark:shadow-xl relative overflow-hidden group hover:border-slate-300 dark:hover:border-slate-700 transition duration-200">
            <div class="absolute -right-4 -bottom-4 text-slate-200 dark:text-slate-800/10 group-hover:scale-110 transition duration-200">
                <svg class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ __('Pemasok Aktif') }}</p>
            <h3 class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $totalSuppliers }}</h3>
            <div class="mt-4 flex items-center text-xs text-indigo-600 dark:text-indigo-400 font-medium">
                <a href="{{ route('suppliers.index') }}" class="hover:underline flex items-center">
                    {{ __('Lihat pemasok') }}
                    <svg class="ml-1 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Alert / Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Recent Transactions & Low Stock Detail -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Recent Transactions Card -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-md dark:shadow-xl overflow-hidden">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-950/40">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ __('Transaksi Terakhir') }}</h3>
                    <a href="{{ route('transactions.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-semibold flex items-center">
                        {{ __('Semua log mutasi') }}
                        <svg class="ml-1 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                <div class="divide-y divide-slate-200 dark:divide-slate-800 overflow-x-auto">
                    @if($recentTransactions->isEmpty())
                        <div class="p-6 text-center text-sm text-slate-500">
                            {{ __('Belum ada transaksi yang dicatat.') }}
                        </div>
                    @else
                        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                            <thead class="text-xs uppercase bg-slate-100/55 dark:bg-slate-950/20 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">{{ __('Tanggal') }}</th>
                                    <th class="px-6 py-3 font-semibold">{{ __('Produk') }}</th>
                                    <th class="px-6 py-3 font-semibold">{{ __('Tipe') }}</th>
                                    <th class="px-6 py-3 font-semibold text-right">{{ __('Jumlah') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-250 dark:divide-slate-800 bg-white/10 dark:bg-slate-900/30">
                                @foreach($recentTransactions as $transaction)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                            {{ $transaction->transaction_date->format('d-m H:i') }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                                            <a href="{{ route('products.show', $transaction->product_id) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                                {{ $transaction->product->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                {{ $transaction->type === 'in' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : '' }}
                                                {{ $transaction->type === 'out' ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20' : '' }}
                                                {{ $transaction->type === 'return' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20' : '' }}
                                            ">
                                                {{ $transaction->type === 'in' ? __('MASUK') : ($transaction->type === 'out' ? __('KELUAR') : __('RETUR')) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold {{ $transaction->type === 'in' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                            {{ $transaction->type === 'in' ? '+' : '-' }}{{ number_format($transaction->quantity) }} {{ $transaction->product->unit }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right 1 Col: Low Stock Detail Alerts -->
        <div>
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-md dark:shadow-xl overflow-hidden h-full flex flex-col">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center">
                        <svg class="mr-2 h-5 w-5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        {{ __('Stok Menipis') }}
                    </h3>
                </div>
                <div class="p-6 flex-1 overflow-y-auto space-y-4">
                    @if($lowStockAlerts->isEmpty())
                        <div class="text-center py-8 text-sm text-slate-500 flex flex-col items-center justify-center space-y-2">
                            <svg class="h-8 w-8 text-slate-400 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ __('Semua produk memiliki stok yang cukup.') }}</span>
                        </div>
                    @else
                        @foreach($lowStockAlerts as $item)
                            <div class="p-4 bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">
                                        <a href="{{ route('products.show', $item->id) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                            {{ $item->name }}
                                        </a>
                                    </h4>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $item->color }} ({{ $item->unit }})</span>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                                        {{ $item->current_stock }} {{ __('tersisa') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                
                @if(auth()->user()->role === 'admin_gudang')
                    <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40">
                        <a href="{{ route('transactions.create') }}" class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl transition duration-200 shadow-lg shadow-indigo-600/10">
                            {{ __('Catat Barang Masuk / Restock') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
