@extends('layouts.public')
@section('title', 'Home')

@section('content')

<!-- Hero -->
<div class="rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-violet-600
            p-10 md:p-16 mb-12 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle, white 1px, transparent 1px);
                background-size: 30px 30px;"></div>
    <div class="relative z-10 max-w-xl">
        <span class="text-indigo-200 text-xs font-bold uppercase tracking-widest mb-3 block">
             New arrivals every week
        </span>
        <h1 class="text-4xl md:text-5xl font-black mb-4 leading-tight">
            Shop Smarter,<br>Live Better
        </h1>
        <p class="text-indigo-100 mb-8 text-base">
            Discover thousands of products from verified vendors. Best prices guaranteed.
        </p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('shop') }}"
               class="inline-flex items-center gap-2 bg-white text-indigo-600 font-bold
                      px-6 py-3 rounded-xl hover:bg-indigo-50 transition text-sm">
                Browse All Products
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            @guest
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-2 bg-indigo-700 text-white font-bold
                      px-6 py-3 rounded-xl hover:bg-indigo-800 transition text-sm border border-indigo-400">
                Create Free Account
            </a>
            @endguest
        </div>
    </div>
</div>

<!-- Trust Badges -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
    @php
    $badges = [
        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'label' => 'Secure Payments',   'sub' => 'Protected by Stripe'],
        ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10',                                                                                                                                                                      'label' => 'Free Shipping',     'sub' => 'On all orders'],
        ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',                                                                                                               'label' => 'Easy Returns',      'sub' => '30-day policy'],
        ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',             'label' => 'Verified Vendors',  'sub' => 'Quality guaranteed'],
    ];
    @endphp
    @foreach($badges as $badge)
    <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $badge['icon'] }}"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold text-gray-900">{{ $badge['label'] }}</p>
            <p class="text-xs text-gray-400">{{ $badge['sub'] }}</p>
        </div>
    </div>
    @endforeach
</div>

<!-- Categories -->
<div class="mb-12">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-2xl font-black text-gray-900">Shop by Category</h2>
            <p class="text-sm text-gray-400 mt-0.5">Find exactly what you're looking for</p>
        </div>
        <a href="{{ route('shop') }}" class="text-sm text-indigo-600 font-semibold hover:underline">
            View all →
        </a>
    </div>
    <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
        @foreach($categories as $category)
        <a href="{{ route('shop', ['category' => $category->id]) }}"
           class="flex flex-col items-center gap-2 p-4 bg-white rounded-2xl border border-gray-100
                  hover:border-indigo-200 hover:shadow-md hover:-translate-y-0.5 transition-all group">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 group-hover:bg-indigo-100 flex items-center justify-center transition">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-700 text-center leading-tight">
                {{ $category->name }}
            </span>
        </a>
        @endforeach
    </div>
</div>

<!-- Featured Products -->
<div class="mb-12">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-2xl font-black text-gray-900">Featured Products</h2>
            <p class="text-sm text-gray-400 mt-0.5">Handpicked just for you</p>
        </div>
        <a href="{{ route('shop') }}" class="text-sm text-indigo-600 font-semibold hover:underline">
            View all →
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($featuredProducts as $product)
        <a href="{{ route('product.show', $product->slug) }}"
           class="bg-white rounded-2xl border border-gray-100 overflow-hidden
                  hover:shadow-lg hover:-translate-y-1 transition-all group">

            <!-- Image -->
            <div class="aspect-square bg-gray-50 overflow-hidden relative">
                @if($product->primaryImage && $product->primaryImage->image_path !== 'placeholder.jpg')
                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-violet-100 flex items-center justify-center">
                        <svg class="w-12 h-12 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/>
                        </svg>
                    </div>
                @endif
                @if($product->discount_price)
                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-lg">
                    SALE
                </span>
                @endif
            </div>

            <!-- Info -->
            <div class="p-3">
                <p class="text-xs text-indigo-500 font-medium mb-1">{{ $product->category->name }}</p>
                <h3 class="text-sm font-semibold text-gray-800 line-clamp-1 mb-2">{{ $product->name }}</h3>
                <div class="flex items-center justify-between">
                    <div>
                        @if($product->discount_price)
                            <span class="font-black text-gray-900">₹{{ number_format($product->discount_price, 2) }}</span>
                            <span class="text-xs text-gray-400 line-through ml-1">₹{{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="font-black text-gray-900">₹{{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                    <!-- Add to cart requires login -->
                    @auth
                    <form action="{{ route('customer.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" onclick="event.stopPropagation()"
                                class="w-8 h-8 bg-indigo-600 text-white rounded-xl flex items-center
                                       justify-center hover:bg-indigo-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" onclick="event.stopPropagation()"
                       class="w-8 h-8 bg-indigo-600 text-white rounded-xl flex items-center
                              justify-center hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </a>
                    @endauth
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>

<!-- CTA Banner -->
@guest
<div class="bg-gradient-to-r from-gray-900 to-indigo-900 rounded-2xl p-10 text-center text-white">
    <h2 class="text-3xl font-black mb-3">Ready to start shopping?</h2>
    <p class="text-gray-300 mb-6 text-sm">Create a free account and get access to exclusive deals.</p>
    <div class="flex items-center justify-center gap-3">
        <a href="{{ route('register') }}"
           class="bg-indigo-500 text-white font-bold px-8 py-3 rounded-xl hover:bg-indigo-400 transition text-sm">
            Create Free Account
        </a>
        <a href="{{ route('login') }}"
           class="bg-white/10 text-white font-bold px-8 py-3 rounded-xl hover:bg-white/20 transition text-sm border border-white/20">
            Log In
        </a>
    </div>
</div>
@endguest

@endsection