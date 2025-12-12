@extends('layouts.app')

@section('title', 'Login - Sistem Pengarsipan PTK')

@section('content')
<div class="flex items-center justify-center min-h-screen relative" style="background: linear-gradient(135deg, rgba(255, 145, 77, 0.8), rgba(255, 94, 20, 0.8)), url('{{ asset('storage/images/bg-latansa.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden" style="box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);">
            <!-- Header -->
            <div class="px-6 pt-6 pb-0 text-center">
                <!-- <h1 class="text-3xl font-bold text-blue-600 mb-1">Sistem Pengarsipan PTK</h1>
                <p class="text-gray-600 text-sm mb-2">Sistem Pengarsipan Pendidikan & Tenaga Kependidikan</p> -->
                <img src="{{ asset('storage/images/logo-latansa.png') }}" alt="Logo" class="w-20 h-20 mx-auto">
            </div>

            <!-- Form -->
            <div class="px-8 pt-2 pb-8">
                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('email') border-red-500 @enderror" 
                               placeholder="nama@email.com" required>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <input type="password" name="password" id="password" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('password') border-red-500 @enderror" 
                               placeholder="••••••••" required>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                        <label for="remember" class="ml-2 text-sm font-medium text-gray-900">Ingat saya</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Masuk
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                <p class="text-xs text-gray-600 text-center">
                    &copy; {{ date('Y') }} Sistem Pengarsipan PTK. Latansa Cendikia.
                </p>
            </div>
        </div>

      
    </div>
</div>
@endsection

