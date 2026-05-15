@extends('layouts.public')
@section('title', 'Page Not Found')

@section('content')
<div class="min-h-96 flex items-center justify-center text-center py-20">
    <div>
        <p class="text-8xl font-black text-indigo-100 mb-4">404</p>
        <h1 class="text-2xl font-black text-gray-900 mb-2">Page Not Found</h1>
        <p class="text-gray-400 text-sm mb-8">The page you're looking for doesn't exist.</p>
        <div class="flex items-center justify-center gap-3">
            <a href="{{ route('home') }}"
               class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-700 transition">
                Go Home
            </a>
            <a href="{{ route('shop') }}"
               class="border-2 border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl font-bold text-sm hover:border-indigo-300 transition">
                Browse Shop
            </a>
        </div>
    </div>
</div>
@endsection