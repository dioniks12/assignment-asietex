@extends('layouts.app')

@section('page_title', 'Tambah Produk')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <!-- Header Actions -->
    <div>
        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Tambah Produk Baru</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400">Tambahkan item katalog bahan baku baru ke dalam inventori.</p>
    </div>

    <!-- Creation Card Form -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 lg:p-8 shadow-md dark:shadow-xl transition-colors duration-200">
        <form action="{{ route('products.store') }}" method="POST" class="space-y-6" onsubmit="return confirm('Apakah Anda yakin data produk ini sudah benar?');">
            @csrf

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    Klasifikasi Kategori
                </label>
                <div class="mt-2">
                    <select id="category_id" name="category_id" required
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('category_id')
                    <p class="mt-2 text-xs text-rose-550 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    Nama Produk
                </label>
                <div class="mt-2">
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                           class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border @error('name') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200"
                           placeholder="Contoh: Cotton Combed 30s">
                </div>
                @error('name')
                    <p class="mt-2 text-xs text-rose-550 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color -->
            <div>
                <label for="color" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    Varian Warna
                </label>
                <div class="mt-2">
                    <input id="color" name="color" type="text" required value="{{ old('color') }}"
                           class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border @error('color') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200"
                           placeholder="Contoh: Navy Blue, Jet Black, Raw White">
                </div>
                @error('color')
                    <p class="mt-2 text-xs text-rose-550 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Unit -->
                <div>
                    <label for="unit" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Satuan Ukuran
                    </label>
                    <div class="mt-2">
                        <input id="unit" name="unit" type="text" required value="{{ old('unit') }}"
                               class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border @error('unit') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200"
                               placeholder="Contoh: kg, roll, bale">
                    </div>
                    @error('unit')
                        <p class="mt-2 text-xs text-rose-550 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Initial Stock -->
                <div>
                    <label for="current_stock" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Stok Awal
                    </label>
                    <div class="mt-2">
                        <input id="current_stock" name="current_stock" type="number" min="0" value="{{ old('current_stock', 0) }}"
                               class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border @error('current_stock') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200">
                    </div>
                    @error('current_stock')
                        <p class="mt-2 text-xs text-rose-550 dark:text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end items-center space-x-3 pt-4 border-t border-slate-200 dark:border-slate-800/80">
                <a href="{{ route('products.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs font-semibold text-slate-655 dark:text-slate-300 rounded-xl transition duration-200">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-xs font-semibold text-white rounded-xl shadow-lg shadow-indigo-600/15 transition duration-200 cursor-pointer">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
