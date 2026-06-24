@extends('layouts.app')

@section('page_title', 'Produk Bahan Baku')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Inventori Produk</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Lacak dan kelola item bahan baku beserta jumlah stok.</p>
        </div>
        @if(auth()->user()->role === 'manajer')
            <a href="{{ route('products.create') }}" class="flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-sm font-semibold text-white rounded-xl shadow-lg shadow-indigo-600/20 transition duration-200 cursor-pointer">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Produk
            </a>
        @endif
    </div>

    <!-- Search and Sort Panel -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-4 rounded-2xl shadow-sm dark:shadow-md transition duration-200">
        <form action="{{ route('products.index') }}" method="GET" class="flex items-center w-full md:max-w-md gap-2">
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
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, warna, satuan, kategori..." 
                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-850 rounded-xl text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-xs font-semibold text-white rounded-xl transition duration-200 cursor-pointer shadow-md shadow-indigo-600/10">
                Cari
            </button>
            @if($search)
                <a href="{{ route('products.index', request()->except(['search'])) }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs font-semibold text-slate-650 dark:text-slate-350 rounded-xl transition duration-200">
                    Batal
                </a>
            @endif
        </form>
        
        <div class="flex items-center space-x-2 text-xs text-slate-500 dark:text-slate-400">
            <span>Klik judul kolom tabel untuk mengurutkan.</span>
        </div>
    </div>

    <!-- Product List Card -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-md dark:shadow-xl overflow-hidden transition-colors duration-200">
        <div class="overflow-x-auto">
            @if($products->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    Tidak ada produk yang ditemukan.
                </div>
            @else
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="text-xs uppercase bg-slate-50 dark:bg-slate-950/40 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3 font-semibold">
                                <a href="{{ route('products.index', ['search' => $search, 'sort_by' => 'category_name', 'sort_order' => $sortBy === 'category_name' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>Kategori</span>
                                    @if($sortBy === 'category_name')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 font-semibold">
                                <a href="{{ route('products.index', ['search' => $search, 'sort_by' => 'name', 'sort_order' => $sortBy === 'name' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>Nama Produk</span>
                                    @if($sortBy === 'name')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 font-semibold">
                                <a href="{{ route('products.index', ['search' => $search, 'sort_by' => 'color', 'sort_order' => $sortBy === 'color' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>Warna</span>
                                    @if($sortBy === 'color')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 font-semibold">Satuan</th>
                            <th class="px-6 py-3 font-semibold text-right">
                                <a href="{{ route('products.index', ['search' => $search, 'sort_by' => 'current_stock', 'sort_order' => $sortBy === 'current_stock' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 justify-end hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>Stok Saat Ini</span>
                                    @if($sortBy === 'current_stock')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 bg-white/10 dark:bg-slate-900/10">
                        @foreach($products as $product)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                    {{ $product->category->name }}
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                                    <a href="{{ route('products.show', $product->id) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $product->color }}</td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $product->unit }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="inline-flex items-center space-x-1.5 justify-end">
                                        @if($product->current_stock < 10)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                                                Stok Rendah
                                            </span>
                                        @endif
                                        <span class="font-bold text-slate-800 dark:text-slate-100">{{ number_format($product->current_stock) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('products.show', $product->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-855 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-300 rounded-lg transition duration-200">
                                            Detail
                                        </a>
                                        @if(auth()->user()->role === 'manajer')
                                            <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/20 text-xs font-semibold text-indigo-600 dark:text-indigo-400 rounded-lg transition duration-200">
                                                Ubah
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-xs font-semibold text-rose-600 dark:text-rose-400 rounded-lg transition duration-200 cursor-pointer">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
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
