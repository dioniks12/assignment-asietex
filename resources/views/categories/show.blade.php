@extends('layouts.app')

@section('page_title', __('Detail Kategori'))

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white">{{ __('Kategori:') }} {{ $category->name }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Total produk terkait: :count', ['count' => $category->products->count()]) }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs font-semibold text-slate-650 dark:text-slate-300 rounded-xl transition duration-200">
                {{ __('Kembali ke Daftar') }}
            </a>
            @if(auth()->user()->role === 'manajer')
                <a href="{{ route('categories.edit', $category->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-xs font-semibold text-white rounded-xl transition duration-200">
                    {{ __('Ubah') }}
                </a>
            @endif
        </div>
    </div>

    <!-- Products list in this category -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-md dark:shadow-xl overflow-hidden transition-colors duration-200">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40">
            <h3 class="text-base font-bold text-slate-800 dark:text-white">{{ __('Produk Terkait') }}</h3>
        </div>
        <div class="overflow-x-auto">
            @if($category->products->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    {{ __('Belum ada produk dalam kategori ":name".', ['name' => $category->name]) }}
                </div>
            @else
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="text-xs uppercase bg-slate-50 dark:bg-slate-950/20 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3 font-semibold">{{ __('Nama Produk') }}</th>
                            <th class="px-6 py-3 font-semibold">{{ __('Warna') }}</th>
                            <th class="px-6 py-3 font-semibold">{{ __('Satuan') }}</th>
                            <th class="px-6 py-3 font-semibold text-right">{{ __('Stok Saat Ini') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 bg-white/10 dark:bg-slate-900/10">
                        @foreach($category->products as $product)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition duration-150">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                                    <a href="{{ route('products.show', $product->id) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $product->color }}</td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $product->unit }}</td>
                                <td class="px-6 py-4 text-right font-bold text-slate-800 dark:text-slate-200">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ $product->current_stock < 10 ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/10' : 'text-slate-700 dark:text-slate-300' }}">
                                        {{ number_format($product->current_stock) }}
                                    </span>
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
