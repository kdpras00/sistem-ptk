@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-4">
    <h1 class="text-3xl font-bold text-white">Dashboard Admin</h1>
    <p class="text-white">Selamat datang, {{ auth()->user()->name }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Total PTK -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total PTK</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_ptk'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Documents -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                    <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Dokumen</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_documents'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Categories -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Kategori</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- PTK by Status -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">PTK Berdasarkan Status Kepegawaian</h2>
        <div class="space-y-3">
            @foreach($ptkByStatus as $status)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ $status->status_kepegawaian }}</span>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">{{ $status->total }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Aktivitas Terbaru</h2>
        <div class="space-y-4">
            @foreach($stats['recent_activities'] as $activity)
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-2 h-2 mt-2 rounded-full bg-blue-600"></div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-900">{{ $activity->description }}</p>
                        <p class="text-xs text-gray-500">{{ $activity->user->name }} • {{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

