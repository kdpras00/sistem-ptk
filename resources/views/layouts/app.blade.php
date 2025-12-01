<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pengarsipan PTK')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Flowbite CDN -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    
    <!-- SweetAlert2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        /* Fix SweetAlert2 buttons visibility - Tailwind CSS reset override */
        .swal2-styled.swal2-confirm,
        .swal2-styled.swal2-cancel {
            border: 0 !important;
            border-radius: .25em !important;
            background: initial !important;
            background-color: #7066e0 !important;
            color: #fff !important;
            font-size: 1em !important;
            padding: .625em 1.1em !important;
        }
        
        .swal2-styled.swal2-confirm {
            background-color: #ef4444 !important;
        }
        
        .swal2-styled.swal2-cancel {
            background-color: #6b7280 !important;
        }
        
        .swal2-styled.swal2-confirm:hover {
            background-color: #dc2626 !important;
        }
        
        .swal2-styled.swal2-cancel:hover {
            background-color: #4b5563 !important;
        }
    </style>
</head>
<body style="background: linear-gradient(135deg, #ff914d, #ff5e14);">
    <!-- Orange gradient background for all pages -->
    
    <!-- Navbar -->
    @auth
    <nav class="fixed z-30 w-full border-b border-orange-700" style="background: linear-gradient(135deg, #ff914d, #ff5e14);">
        <div class="px-3 lg:px-5 lg:pl-3" style="height: 72px; display: flex; align-items: center;">
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-white rounded-lg sm:hidden hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-300">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                           <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.dashboard') }}" class="flex ml-2 md:mr-24">
                        <span class="self-center text-lg font-semibold whitespace-nowrap text-white">Sistem PTK</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ml-3">
                        <div>
                            <button type="button" class="flex text-sm bg-white rounded-full focus:ring-4 focus:ring-orange-300" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <div class="w-9 h-9 rounded-full bg-orange-700 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow" id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900" role="none">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                    {{ auth()->user()->email }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1" role="none">
                                    {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-6 transition-transform -translate-x-full border-r border-orange-700 sm:translate-x-0" style="background: linear-gradient(180deg, #ff914d, #ff5e14);" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto">
            @include('layouts.partials.sidebar')
        </div>
    </aside>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        <div class="p-4" style="margin-top: 72px;">
            @yield('content')
        </div>
    </div>
    @else
        @yield('content')
    @endauth

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- SweetAlert2 Notifications Handler -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonColor: '#d33'
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: '{{ session('warning') }}',
                showConfirmButton: true,
                confirmButtonColor: '#f39c12'
            });
        @endif

        @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Error!',
                html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                showConfirmButton: true,
                confirmButtonColor: '#d33'
            });
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>

