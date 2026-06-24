@extends('layouts.app')

@section('page_title', __('Pemasok Bahan Baku'))

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ __('Daftar Pemasok') }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Kelola pemasok eksternal yang menyuplai stok bahan baku.') }}</p>
        </div>
        @if(auth()->user()->role === 'manajer')
            <a href="{{ route('suppliers.create') }}" class="flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-sm font-semibold text-white rounded-xl shadow-lg shadow-indigo-600/20 transition duration-200 cursor-pointer">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Tambah Pemasok') }}
            </a>
        @endif
    </div>

    <!-- Search and Sort Panel -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-4 rounded-2xl shadow-sm dark:shadow-md transition duration-200">
        <form action="{{ route('suppliers.index') }}" method="GET" class="flex items-center w-full md:max-w-md gap-2">
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
                <input type="text" name="search" value="{{ $search }}" placeholder="{{ __('Cari nama, kontak, atau alamat...') }}" 
                       class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-955 border border-slate-200 dark:border-slate-850 rounded-xl text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-xs font-semibold text-white rounded-xl transition duration-200 cursor-pointer shadow-md shadow-indigo-600/10">
                {{ __('Cari') }}
            </button>
            @if($search)
                <a href="{{ route('suppliers.index', request()->except(['search'])) }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs font-semibold text-slate-650 dark:text-slate-350 rounded-xl transition duration-200">
                    {{ __('Batal') }}
                </a>
            @endif
        </form>
        
        <div class="flex items-center space-x-2 text-xs text-slate-500 dark:text-slate-400">
            <span>{{ __('Klik judul kolom tabel untuk mengurutkan.') }}</span>
        </div>
    </div>

    <!-- Supplier List Card -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-md dark:shadow-xl overflow-hidden transition-colors duration-200">
        <div class="overflow-x-auto">
            @if($suppliers->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    {{ __('Tidak ada pemasok yang ditemukan.') }}
                </div>
            @else
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300" data-lazy-load="true" data-lazy-chunk="5">
                    <thead class="text-xs uppercase bg-slate-50 dark:bg-slate-950/40 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3 font-semibold">
                                <a href="{{ route('suppliers.index', ['search' => $search, 'sort_by' => 'name', 'sort_order' => $sortBy === 'name' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>{{ __('Nama Pemasok') }}</span>
                                    @if($sortBy === 'name')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 font-semibold">
                                <a href="{{ route('suppliers.index', ['search' => $search, 'sort_by' => 'contact', 'sort_order' => $sortBy === 'contact' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>{{ __('Kontak / Telp') }}</span>
                                    @if($sortBy === 'contact')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 font-semibold">
                                <a href="{{ route('suppliers.index', ['search' => $search, 'sort_by' => 'address', 'sort_order' => $sortBy === 'address' && $sortOrder === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center space-x-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <span>{{ __('Alamat') }}</span>
                                    @if($sortBy === 'address')
                                        {!! $sortOrder === 'asc' ? '▲' : '▼' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 font-semibold text-right">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 bg-white/10 dark:bg-slate-900/10">
                        @foreach($suppliers as $supplier)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition duration-150">
                                <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                        {{ $supplier->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $supplier->contact }}</td>
                                <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400 max-w-xs truncate">{{ $supplier->address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('suppliers.show', $supplier->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-300 rounded-lg transition duration-200">
                                            {{ __('Detail') }}
                                        </a>
                                        @if(auth()->user()->role === 'manajer')
                                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/20 text-xs font-semibold text-indigo-600 dark:text-indigo-400 rounded-lg transition duration-200">
                                                {{ __('Ubah') }}
                                            </a>
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline-block delete-form" data-confirm="{{ __('Apakah Anda yakin ingin menghapus pemasok ini?') }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-xs font-semibold text-rose-600 dark:text-rose-400 rounded-lg transition duration-200 cursor-pointer">
                                                    {{ __('Hapus') }}
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
