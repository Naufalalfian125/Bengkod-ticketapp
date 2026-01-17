@php
    $path = public_path('assets/logo.svg');
    $attributes = $attributes->merge(['class' => 'bg-blue-600 text-white rounded-full p-2']);
@endphp

@if(file_exists($path))
    {!! preg_replace('/<svg/i', '<svg ' . $attributes, file_get_contents($path), 1) !!}
@else
    <img src="{{ asset('assets/logo.svg') }}" {{ $attributes }} alt="Logo">
@endif
