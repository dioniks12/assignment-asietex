@extends('layouts.app')

@section('content')
<div class="sm:mx-auto sm:w-full sm:max-w-md">
    <div class="flex justify-center">
        <!-- Modernized decorative logo/icon -->
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-xl shadow-indigo-500/20">
            <svg class="h-8 w-8 text-white animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
    </div>
    <h2 class="mt-6 text-center text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
        {{ __('Masuk ke akun Anda') }}
    </h2>
    <p class="mt-2 text-center text-sm text-slate-500 dark:text-slate-400">
        {{ __('Sistem Inventori Bahan Baku Tekstil') }}
    </p>
</div>

<div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl py-8 px-4 border border-slate-200 dark:border-slate-800/80 shadow-xl dark:shadow-2xl rounded-3xl sm:px-10">
        <form class="space-y-6" action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    {{ __('Alamat Email') }}
                </label>
                <div class="mt-1 relative">
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                           class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border @error('email') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition-all duration-200"
                           placeholder="nama@gmail.com">
                    @error('email')
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @enderror
                </div>
                @error('email')
                    <p class="mt-2 text-xs text-rose-500 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    {{ __('Kata Sandi') }}
                </label>
                <div class="mt-1 relative">
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="block w-full px-4 py-3 bg-white dark:bg-slate-950/80 border @error('password') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @else border-slate-300 dark:border-slate-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 transition-all duration-200"
                           placeholder="••••••••">
                    @error('password')
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @enderror
                </div>
                @error('password')
                    <p class="mt-2 text-xs text-rose-500 dark:text-rose-400 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember me -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-950 rounded transition-all duration-200">
                    <label for="remember" class="ml-2 block text-sm text-slate-500 dark:text-slate-400 font-medium select-none">
                        {{ __('Ingat saya') }}
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-indigo-600/20 cursor-pointer">
                    {{ __('Masuk') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
