@extends('layouts.app')

@section('page_title', __('Detail Pemasok'))

@section('content')
<div class="space-y-8">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white">{{ $supplier->name }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Profil & Riwayat Pasokan Pemasok') }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('suppliers.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs font-semibold text-slate-655 dark:text-slate-300 rounded-xl transition duration-200">
                {{ __('Kembali ke Daftar') }}
            </a>
            @if(auth()->user()->role === 'manajer')
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-xs font-semibold text-white rounded-xl transition duration-200">
                    {{ __('Ubah Info') }}
                </a>
            @endif
        </div>
    </div>

    <!-- Supplier info cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-md dark:shadow-xl transition-colors duration-200">
            <h4 class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">{{ __('Nomor Kontak') }}</h4>
            <p class="mt-2 text-base font-bold text-slate-900 dark:text-white">{{ $supplier->contact }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-md dark:shadow-xl md:col-span-2 transition-colors duration-200">
            <h4 class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">{{ __('Alamat') }}</h4>
            <p class="mt-2 text-sm text-slate-700 dark:text-slate-200 font-medium leading-relaxed">{{ $supplier->address }}</p>
        </div>
    </div>

    <!-- Transaction Logs table -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-md dark:shadow-xl overflow-hidden transition-colors duration-200">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40">
            <h3 class="text-base font-bold text-slate-800 dark:text-white">{{ __('Log Riwayat Pasokan') }}</h3>
        </div>
        <div class="overflow-x-auto">
            @if($supplier->transactions->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    {{ __('Belum ada transaksi pasokan yang tercatat untuk pemasok ini.') }}
                </div>
            @else
                <table class="w-full text-left text-sm text-slate-655 dark:text-slate-300">
                    <thead class="text-xs uppercase bg-slate-50 dark:bg-slate-950/20 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3 font-semibold">{{ __('Tanggal') }}</th>
                            <th class="px-6 py-3 font-semibold">{{ __('Produk') }}</th>
                            <th class="px-6 py-3 font-semibold">{{ __('Tipe') }}</th>
                            <th class="px-6 py-3 font-semibold text-right">{{ __('Jumlah') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 bg-white/10 dark:bg-slate-900/10">
                        @foreach($supplier->transactions as $transaction)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition duration-150">
                                <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
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
                                        {{ $transaction->type === 'return' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20' : '' }}
                                        {{ $transaction->type === 'out' ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20' : '' }}
                                    ">
                                         {{ $transaction->type === 'in' ? __('MASUK') : ($transaction->type === 'return' ? __('RETUR') : __('KELUAR')) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold {{ $transaction->type === 'in' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
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
@endsection
