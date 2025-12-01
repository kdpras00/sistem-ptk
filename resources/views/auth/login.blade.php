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
                        <div class="relative">
                            <input type="password" name="password" id="password" 
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 @error('password') border-red-500 @enderror" 
                                   placeholder="••••••••" required>
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-5 flex items-center pr-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.753 5.753A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.574 2.59M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.574 2.59M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <script>
                        function togglePassword() {
                            const passwordInput = document.getElementById('password');
                            const eyeIcon = document.getElementById('eye-icon');
                            const eyeSlashIcon = document.getElementById('eye-slash-icon');
                            
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                                eyeIcon.classList.add('hidden');
                                eyeSlashIcon.classList.remove('hidden');
                            } else {
                                passwordInput.type = 'password';
                                eyeIcon.classList.remove('hidden');
                                eyeSlashIcon.classList.add('hidden');
                            }
                        }
                    </script>

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

