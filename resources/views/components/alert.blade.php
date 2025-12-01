@props(['type' => 'info'])

@php
    $classes = [
        'success' => 'bg-green-50 text-green-800 border-green-200',
        'error' => 'bg-red-50 text-red-800 border-red-200',
        'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
        'info' => 'bg-blue-50 text-blue-800 border-blue-200',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'p-4 mb-4 text-sm rounded-lg border ' . ($classes[$type] ?? $classes['info'])]) }} role="alert">
    {{ $slot }}
</div>

