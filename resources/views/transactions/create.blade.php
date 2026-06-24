@extends('layouts.app')

@section('page_title', __('Catat Transaksi'))

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    <!-- Header Actions -->
    <div>
        <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ __('Catat Mutasi Stok') }}</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Catat pergerakan bahan masuk, keluar, atau retur. Jumlah stok akan diperbarui secara otomatis.') }}</p>
    </div>

    <!-- Form Alert for Errors -->
    @if($errors->any())
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl text-sm text-rose-400 font-medium">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Creation Card Form -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 lg:p-8 shadow-md dark:shadow-xl transition-colors duration-200">
        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6" data-confirm="{{ __('Apakah Anda yakin data transaksi ini sudah benar?') }}">
            @csrf

            <!-- Transaction Type -->
            <div>
                <label for="type" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    {{ __('Tipe Transaksi') }}
                </label>
                <div class="mt-2">
                    <select id="type" name="type" required
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200">
                        <option value="" disabled selected>{{ __('Pilih Tipe') }}</option>
                        <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>{{ __('MASUK (Barang Masuk / Restock)') }}</option>
                        <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>{{ __('KELUAR (Barang Keluar / Pemakaian)') }}</option>
                        <option value="return" {{ old('type') == 'return' ? 'selected' : '' }}>{{ __('RETUR (Retur ke Pemasok)') }}</option>
                    </select>
                </div>
            </div>

            <!-- Product -->
            <div>
                <label for="product_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    {{ __('Pilihan Produk') }}
                </label>
                <div class="mt-2">
                    <select id="product_id" name="product_id" required
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200">
                        <option value="" disabled selected>{{ __('Pilih Produk') }}</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-unit="{{ $product->unit }}" data-stock="{{ $product->current_stock }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} ({{ __('Warna:') }} {{ $product->color }} | {{ __('Stok Tersedia:') }} {{ $product->current_stock }} {{ $product->unit }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Supplier (Conditional requirement checked by JS) -->
            <div id="supplier-wrapper" class="transition-opacity duration-200">
                <label for="supplier_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    {{ __('Pemasok') }}
                </label>
                <div class="mt-2">
                    <select id="supplier_id" name="supplier_id"
                            class="block w-full px-4 py-3 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200">
                        <option value="" disabled selected>{{ __('Pilih Pemasok') }}</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="mt-1 text-xs text-slate-500 font-medium">{{ __('Wajib diisi untuk tipe transaksi MASUK dan RETUR.') }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        {{ __('Jumlah') }}
                    </label>
                    <div class="mt-2 relative">
                        <input id="quantity" name="quantity" type="number" min="1" required value="{{ old('quantity') }}"
                               class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200"
                               placeholder="{{ __('Contoh: 50') }}">
                    </div>
                </div>

                <!-- Transaction Date -->
                <div>
                    <label for="transaction_date" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        {{ __('Tanggal Transaksi') }}
                    </label>
                    <div class="mt-2">
                        <input id="transaction_date" name="transaction_date" type="datetime-local" required value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}"
                               class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200">
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    {{ __('Catatan / Keterangan') }}
                </label>
                <div class="mt-2">
                    <textarea id="notes" name="notes" rows="3"
                              class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition duration-200"
                              placeholder="{{ __('Contoh: Restock benang katun, perintah produksi #104') }}">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end items-center space-x-3 pt-4 border-t border-slate-200 dark:border-slate-800/80">
                <a href="{{ route('transactions.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 rounded-xl transition duration-200">
                    {{ __('Batal') }}
                </a>
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-xs font-semibold text-white rounded-xl shadow-lg shadow-indigo-600/15 transition duration-200 cursor-pointer">
                    {{ __('Simpan Transaksi') }}
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const supplierWrapper = document.getElementById('supplier-wrapper');
        const supplierSelect = document.getElementById('supplier_id');

        function adjustSupplierField() {
            if (typeSelect.value === 'out') {
                supplierWrapper.style.opacity = '0.35';
                supplierSelect.disabled = true;
                supplierSelect.required = false;
                // Don't require supplier for outbound
            } else {
                supplierWrapper.style.opacity = '1';
                supplierSelect.disabled = false;
                supplierSelect.required = true;
            }
        }

        typeSelect.addEventListener('change', adjustSupplierField);
        adjustSupplierField(); // initial run
    });
</script>
@endsection
