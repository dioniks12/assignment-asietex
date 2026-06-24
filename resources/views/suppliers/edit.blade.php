@extends('layouts.app')

@section('page_title', __('Ubah Pemasok'))

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <!-- Header Actions -->
    <div>
        <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ __('Ubah Pemasok') }}</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Perbarui informasi kontak dan alamat untuk Pemasok: :name.', ['name' => $supplier->name]) }}</p>
    </div>

    <!-- Edit Card Form -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 lg:p-8 shadow-md dark:shadow-xl transition-colors duration-200">
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="space-y-6" data-confirm="{{ __('Apakah Anda yakin ingin memperbarui data pemasok ini?') }}">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    {{ __('Nama Pemasok') }}
                </label>
                <div class="mt-2 relative">
                    <input id="name" name="name" type="text" required value="{{ old('name', $supplier->name) }}"
                           class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border @error('name') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200"
                           placeholder="{{ __('Contoh: PT Indotex Utama') }}">
                </div>
                @error('name')
                    <p class="mt-2 text-xs text-rose-500 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact -->
            <div>
                <label for="contact" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    {{ __('Kontak / Nomor Telepon') }}
                </label>
                <div class="mt-2 relative">
                    <input id="contact" name="contact" type="text" required value="{{ old('contact', $supplier->contact) }}"
                           class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border @error('contact') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200"
                           placeholder="{{ __('Contoh: +62 812-3456-7890') }}">
                </div>
                @error('contact')
                    <p class="mt-2 text-xs text-rose-500 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    {{ __('Alamat Pemasok') }}
                </label>
                <div class="mt-2 relative">
                    <textarea id="address" name="address" rows="4" required
                              class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border @error('address') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200"
                              placeholder="{{ __('Contoh: Jl. Industri Raya No. 45, Bandung, Jawa Barat') }}">{{ old('address', $supplier->address) }}</textarea>
                </div>
                @error('address')
                    <p class="mt-2 text-xs text-rose-500 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end items-center space-x-3 pt-4 border-t border-slate-200 dark:border-slate-800/80">
                <a href="{{ route('suppliers.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs font-semibold text-slate-655 dark:text-slate-300 rounded-xl transition duration-200">
                    {{ __('Batal') }}
                </a>
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-xs font-semibold text-white rounded-xl shadow-lg shadow-indigo-600/15 transition duration-200 cursor-pointer">
                    {{ __('Perbarui Pemasok') }}
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
