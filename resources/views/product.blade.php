@extends('layouts.public')
@section('title', $product->name)

@section('content')

<!-- Breadcrumb -->
<nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
    <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
    <span>/</span>
    <a href="{{ route('shop') }}" class="hover:text-indigo-600">Shop</a>
    <span>/</span>
    <a href="{{ route('shop', ['category' => $product->category_id]) }}"
       class="hover:text-indigo-600">{{ $product->category->name }}</a>
    <span>/</span>
    <span class="text-gray-700 font-medium truncate">{{ $product->name }}</span>
</nav>

<!-- Product -->
<div class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        <!-- Images -->
        <div x-data="{ active: '{{ $product->images->first()?->image_path }}' }">
            <div class="aspect-square rounded-2xl overflow-hidden bg-gray-50 mb-3">
                @if($product->images->first() && $product->images->first()->image_path !== 'placeholder.jpg')
                    <img :src="'/storage/' + active"
                         class="w-full h-full object-cover transition-all duration-300">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-violet-100 flex items-center justify-center">
                        <svg class="w-20 h-20 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586"/>
                        </svg>
                    </div>
                @endif
            </div>
            @if($product->images->count() > 1) 
            <div class="grid grid-cols-5 gap-2">
                @foreach($product->images as $image)
                @if($image->image_path !== 'placeholder.jpg')
                <button @click="active = '{{ $image->image_path }}'"
                        :class="active === '{{  $image->image_path }}'
                            ? 'ring-2 ring-indigo-500 ring-offset-2'
                            : 'ring-1 ring-gray-200 hover:ring-indigo-300'"
                        class="aspect-square rounded-xl overflow-hidden transition">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover">
                </button>
                @endif
                @endforeach
            </div>
            @endif
        </div>

        <!-- Info -->
        <div class="flex flex-col">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xs bg-indigo-50 text-indigo-600 font-semibold px-3 py-1 rounded-full">
                    {{ $product->category->name }}
                </span>
                @if($product->discount_price)
                <span class="text-xs bg-red-50 text-red-500 font-semibold px-3 py-1 rounded-full">SALE</span>
                @endif
            </div>

            <h1 class="text-2xl font-black text-gray-900 mb-2 leading-tight">{{ $product->name }}</h1>

            <div class="flex items-center gap-2 mb-5">
                <div class="w-6 h-6 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr($product->vendor->name, 0, 1)) }}
                </div>
                <span class="text-sm text-gray-500">
                    Sold by <span class="font-semibold text-gray-700">{{ $product->vendor->name }}</span>
                </span>
            </div>

            <!-- Price -->
            <div class="flex items-end gap-3 mb-6 pb-6 border-b border-gray-100">
                @if($product->discount_price)
                    <span class="text-4xl font-black text-gray-900">₹{{ number_format($product->discount_price, 2) }}</span>
                    <span class="text-lg text-gray-400 line-through mb-1">₹{{ number_format($product->price, 2) }}</span>
                    <span class="text-sm bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-lg mb-1">
                        Save ₹{{ number_format($product->price - $product->discount_price, 2) }}
                    </span>
                @else
                    <span class="text-4xl font-black text-gray-900">₹{{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            @if($product->description)
            <div class="mb-6">
                <h3 class="text-sm font-bold text-gray-900 mb-2">About this product</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $product->description }}</p>
            </div>
            @endif

            <!-- Stock -->
            <div class="flex items-center gap-2 mb-6">
                @if($product->stock > 0)
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <span class="text-sm text-green-600 font-medium">In Stock ({{ $product->stock }} available)</span>
                @else
                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                    <span class="text-sm text-red-500 font-medium">Out of Stock</span>
                @endif
            </div>

            <!-- Add to Cart / Login -->
            @if($product->stock > 0)
                @auth
                <form action="{{ route('customer.cart.add') }}" method="POST" class="flex gap-3 mt-auto">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit"
                            class="flex-1 bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm
                                   hover:bg-indigo-700 active:scale-95 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Add to Cart
                    </button>
                    <a href="{{ route('customer.cart') }}"
                       class="px-5 py-3.5 rounded-xl border-2 border-indigo-600 text-indigo-600
                              font-bold text-sm hover:bg-indigo-50 transition">
                        View Cart
                    </a>
                </form>
                @else
                <!-- Guest — prompt to login -->
                <div class="mt-auto space-y-3">
                    <a href="{{ route('login') }}"
                       class="w-full flex items-center justify-center gap-2 bg-indigo-600 text-white
                              py-3.5 rounded-xl font-bold text-sm hover:bg-indigo-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Login to Add to Cart
                    </a>
                    <p class="text-center text-xs text-gray-400">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">
                            Sign up free
                        </a>
                    </p>
                </div>
                @endauth
            @else
            <button disabled class="w-full bg-gray-100 text-gray-400 py-3.5 rounded-xl font-bold text-sm cursor-not-allowed">
                Out of Stock
            </button>
            @endif

            <!-- Trust Badges -->
            <div class="grid grid-cols-3 gap-3 mt-6 pt-6 border-t border-gray-100">
                @foreach([
                    ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944...', 'Secure Payment'],
                    ['M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10', 'Free Shipping'],
                    ['M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'Easy Returns'],
                ] as [$icon, $label])
                <div class="flex flex-col items-center gap-1 text-center">
                    <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gray-500 font-medium">{{ $label }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($related->count())
<div>
    <h2 class="text-xl font-black text-gray-900 mb-5">You might also like</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($related as $item)
        <a href="{{ route('product.show', $item->slug) }}"
           class="bg-white rounded-2xl border border-gray-100 overflow-hidden
                  hover:shadow-lg hover:-translate-y-1 transition-all group">
            <div class="aspect-square bg-gray-50 overflow-hidden">
                @if($item->primaryImage && $item->primaryImage->image_path !== 'placeholder.jpg')
                    <img src="{{ asset('storage/' . $item->primaryImage->image_path) }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-violet-100"></div>
                @endif
            </div>
            <div class="p-3">
                <h3 class="text-sm font-semibold text-gray-800 line-clamp-1">{{ $item->name }}</h3>
                <p class="text-sm font-black text-indigo-600 mt-1">
                    ₹{{ number_format($item->discount_price ?? $item->price, 2) }}
                </p>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<script src="//unpkg.com/alpinejs" defer></script>
@endsection