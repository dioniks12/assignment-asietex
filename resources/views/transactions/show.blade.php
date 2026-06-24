@extends('layouts.app')

@section('page_title', __('Detail Transaksi'))

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ __('Log Referensi Transaksi') }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('ID:') }} TX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 rounded-xl transition duration-200">
            {{ __('Kembali ke Daftar') }}
        </a>
    </div>

    <!-- Details Card -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 lg:p-8 shadow-md dark:shadow-xl transition-colors duration-200 space-y-6">
        
        <!-- Transaction Date & Type -->
        <div class="flex justify-between items-center border-b border-slate-200 dark:border-slate-800/80 pb-4">
            <div>
                <h4 class="text-xs font-semibold text-slate-500 dark:text-slate-450 uppercase tracking-wider">{{ __('Tanggal & Waktu') }}</h4>
                <p class="mt-1 text-sm font-bold text-slate-755 dark:text-slate-200">{{ $transaction->transaction_date->format('d-m H:i') }}</p>
            </div>
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                    {{ $transaction->type === 'in' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : '' }}
                    {{ $transaction->type === 'out' ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20' : '' }}
                    {{ $transaction->type === 'return' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20' : '' }}
                ">
                    {{ strtoupper($transaction->type === 'in' ? __('Barang Masuk') : ($transaction->type === 'out' ? __('Barang Keluar') : __('Retur'))) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <!-- Product Item -->
            <div>
                <h4 class="text-xs font-semibold text-slate-500 dark:text-slate-450 uppercase tracking-wider">{{ __('Nama Produk') }}</h4>
                <p class="mt-1 text-sm font-bold text-slate-800 dark:text-white">
                    <a href="{{ route('products.show', $transaction->product_id) }}" class="hover:text-indigo-650 dark:hover:text-indigo-400 hover:underline">
                        {{ $transaction->product->name }}
                    </a>
                </p>
                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $transaction->product->color }} ({{ $transaction->product->unit }})</span>
            </div>

            <!-- Quantity -->
            <div class="text-right">
                <h4 class="text-xs font-semibold text-slate-500 dark:text-slate-450 uppercase tracking-wider">{{ __('Jumlah Mutasi') }}</h4>
                <p class="mt-1 text-lg font-extrabold {{ $transaction->type === 'in' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                    {{ $transaction->type === 'in' ? '+' : '-' }}{{ number_format($transaction->quantity) }} {{ $transaction->product->unit }}
                </p>
            </div>
        </div>

        <!-- Supplier -->
        <div class="border-t border-slate-200 dark:border-slate-800/80 pt-4">
            <h4 class="text-xs font-semibold text-slate-500 dark:text-slate-450 uppercase tracking-wider">{{ __('Pemasok Terkait') }}</h4>
            <p class="mt-1 text-sm font-bold text-slate-755 dark:text-slate-200">
                @if($transaction->supplier)
                    <a href="{{ route('suppliers.show', $transaction->supplier_id) }}" class="hover:text-indigo-655 dark:hover:text-indigo-400 hover:underline">
                        {{ $transaction->supplier->name }}
                    </a>
                @else
                    <span class="text-slate-500 dark:text-slate-400 font-medium">{{ __('Tidak ada (Penggunaan internal barang keluar)') }}</span>
                @endif
            </p>
        </div>

        <!-- Notes -->
        <div class="border-t border-slate-200 dark:border-slate-800/80 pt-4">
            <h4 class="text-xs font-semibold text-slate-500 dark:text-slate-450 uppercase tracking-wider">{{ __('Catatan Audit / Alasan') }}</h4>
            <div class="mt-1 p-4 bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800/80 rounded-2xl">
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed italic">{{ $transaction->notes ?? __('Tidak ada catatan yang diberikan untuk log mutasi ini.') }}</p>
            </div>
        </div>
    </div>

</div>
@endsection
