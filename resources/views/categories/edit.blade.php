@extends('layouts.app')

@section('page_title', 'Ubah Kategori')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <!-- Header Actions -->
    <div>
        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Ubah Kategori</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400">Perbarui nama klasifikasi untuk Kategori: {{ $category->name }}.</p>
    </div>

    <!-- Edit Card Form -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 lg:p-8 shadow-md dark:shadow-xl transition-colors duration-200">
        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-6" onsubmit="return confirm('Apakah Anda yakin ingin memperbarui data kategori ini?');">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    Nama Kategori
                </label>
                <div class="mt-2 relative">
                    <input id="name" name="name" type="text" required value="{{ old('name', $category->name) }}"
                           class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border @error('name') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200"
                           placeholder="Contoh: Sutra, Katun, Poliester">
                </div>
                @error('name')
                    <p class="mt-2 text-xs text-rose-500 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end items-center space-x-3 pt-4 border-t border-slate-200 dark:border-slate-800/80">
                <a href="{{ route('categories.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs font-semibold text-slate-650 dark:text-slate-300 rounded-xl transition duration-200">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-xs font-semibold text-white rounded-xl shadow-lg shadow-indigo-600/15 transition duration-200 cursor-pointer">
                    Perbarui Kategori
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
