@extends('layouts.app')

@section('page_title', __('Log Mutasi Stok'))

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ __('Log Mutasi Stok Gudang') }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Daftar lengkap barang masuk, keluar, dan retur bahan baku.') }}</p>
        </div>
        @if(auth()->user()->role === 'admin_gudang')
            <a href="{{ route('transactions.create') }}" class="flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-sm font-semibold text-white rounded-xl shadow-lg shadow-indigo-600/20 transition duration-200 cursor-pointer">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Catat Transaksi') }}
            </a>
        @endif
    </div>

    <!-- Search and Sort Panel -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-4 rounded-2xl shadow-sm dark:shadow-md transition duration-200">
        <form action="{{ route('transactions.index') }}" method="GET" class="flex items-center w-full md:max-w-md gap-2">
            @if(request('sort_by'))
                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
            @endif
            @if(request('sort_order'))
                <input type="hidden" name="sort_order" value="{{ request('sort_order') }}">
            @endif
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ $search }}" placeholder="{{ __('Cari produk, pemasok, tipe, catatan...') }}" 
                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-850 rounded-xl text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-xs font-semibold text-white rounded-xl transition duration-200 cursor-pointer shadow-md shadow-indigo-600/10">
                {{ __('Cari') }}
            </button>
            @if($search)
                <a href="{{ route('transactions.index', request()->except(['search'])) }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs font-semibold text-slate-650 dark:text-slate-350 rounded-xl transition duration-200">
                    {{ __('Batal') }}
                </a>
            @endif
        </form>
        
        <div class="flex items-center space-x-2 text-xs text-slate-500 dark:text-slate-400">
            <span>{{ __('Klik judul kolom tabel untuk mengurutkan.') }}</span>
        </div>
    </div>

    <!-- Transaction Logs List Card -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-md dark:shadow-xl overflow-hidden transition-colors duration-200">
        <div class="overflow-x-auto">
            @if($transactions->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    {{ __('Tidak ada transaksi yang tercatat dalam sistem.') }}
                </div>
            @else
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300" data-lazy-load="true" data-lazy-chunk="5">
                    <thead class="text-xs uppercase bg-slate-50 dark:bg-slate-950/40 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3 font-semibold">
                                <a href="{{ route('transactions.index', ['search' => $search, 'sort_by' => 'transaction_date', 'sort_order' => $sortBy === 'transaction_date' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>{{ __('Tanggal') }}</span>
                                    @if($sortBy === 'transaction_date')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 font-semibold">
                                <a href="{{ route('transactions.index', ['search' => $search, 'sort_by' => 'product_name', 'sort_order' => $sortBy === 'product_name' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>{{ __('Produk') }}</span>
                                    @if($sortBy === 'product_name')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 font-semibold">
                                <a href="{{ route('transactions.index', ['search' => $search, 'sort_by' => 'type', 'sort_order' => $sortBy === 'type' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>{{ __('Tipe') }}</span>
                                    @if($sortBy === 'type')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 font-semibold text-right">
                                <a href="{{ route('transactions.index', ['search' => $search, 'sort_by' => 'quantity', 'sort_order' => $sortBy === 'quantity' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 justify-end hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>{{ __('Jumlah') }}</span>
                                    @if($sortBy === 'quantity')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                             <th class="px-6 py-3 font-semibold">{{ __('Pemasok') }}</th>
                             <th class="px-6 py-3 font-semibold">{{ __('Catatan') }}</th>
                             <th class="px-6 py-3 font-semibold text-right">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 bg-white/10 dark:bg-slate-900/10">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                    {{ $transaction->transaction_date->format('d-m H:i') }}
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">
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
                                <td class="px-6 py-4 text-slate-700 dark:text-slate-200">
                                    @if($transaction->supplier)
                                        <a href="{{ route('suppliers.show', $transaction->supplier_id) }}" class="hover:underline hover:text-indigo-600 dark:hover:text-indigo-400">
                                            {{ $transaction->supplier->name }}
                                        </a>
                                    @else
                                        <span class="text-slate-400 dark:text-slate-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-550 dark:text-slate-400 max-w-xs truncate">{{ $transaction->notes ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('transactions.show', $transaction->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-300 rounded-lg transition duration-200">
                                        {{ __('Detail') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>
@endsection
