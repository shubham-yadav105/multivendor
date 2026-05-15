@extends('layouts.public')
@section('title', 'Shop')

@section('content')
<div class="flex gap-8">

    <!-- Sidebar -->
    <aside class="hidden md:block w-60 shrink-0">
        <form action="{{ route('shop') }}" method="GET">
            <div class="bg-white rounded-2xl border border-gray-100 p-5 sticky top-24">
                <h3 class="font-bold text-gray-900 mb-4">Filters</h3>

                <!-- Category -->
                <div class="mb-5">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 block">
                        Category
                    </label>
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="category" value=""
                                   {{ !request('category') ? 'checked' : '' }} class="text-indigo-600">
                            <span class="text-sm text-gray-700 group-hover:text-indigo-600">All</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="category" value="{{ $cat->id }}"
                                   {{ request('category') == $cat->id ? 'checked' : '' }} class="text-indigo-600">
                            <span class="text-sm text-gray-700 group-hover:text-indigo-600">{{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range -->
                <div class="mb-5">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 block">
                        Price Range
                    </label>
                    <div class="flex gap-2">
                        <input type="number" name="min_price" placeholder="Min"
                               value="{{ request('min_price') }}"
                               class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <input type="number" name="max_price" placeholder="Max"
                               value="{{ request('max_price') }}"
                               class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition">
                    Apply Filters
                </button>
                @if(request()->hasAny(['category','min_price','max_price','search']))
                <a href="{{ route('shop') }}" class="block text-center text-xs text-gray-400 hover:text-red-500 mt-2">
                    Clear filters
                </a>
                @endif
            </div>
        </form>
    </aside>

    <!-- Products -->
    <div class="flex-1">
        <div class="flex items-center justify-between mb-5">
            <p class="text-sm text-gray-500">
                Showing <span class="font-bold text-gray-800">{{ $products->total() }}</span> products
            </p>
        </div>

        @if($products->count())
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($products as $product)
            <a href="{{ route('product.show', $product->slug) }}"
               class="bg-white rounded-2xl border border-gray-100 overflow-hidden
                      hover:shadow-lg hover:-translate-y-1 transition-all group">

                <div class="aspect-square bg-gray-50 overflow-hidden relative">
                    @if($product->primaryImage && $product->primaryImage->image_path !== 'placeholder.jpg')
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-violet-100 flex items-center justify-center">
                            <svg class="w-12 h-12 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586"/>
                            </svg>
                        </div>
                    @endif
                    @if($product->discount_price)
                    <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-lg">
                        SALE
                    </span>
                    @endif
                </div>

                <div class="p-4">
                    <p class="text-xs text-indigo-500 font-medium mb-1">{{ $product->category->name }}</p>
                    <h3 class="text-sm font-semibold text-gray-800 line-clamp-1 mb-1">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-400 mb-3">by {{ $product->vendor->name }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->discount_price)
                                <span class="font-black text-gray-900">₹{{ number_format($product->discount_price, 2) }}</span>
                                <span class="text-xs text-gray-400 line-through ml-1">${{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="font-black text-gray-900">₹{{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
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
                                  justify-center hover:bg-indigo-700 transition"
                           title="Login to add to cart">
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
        <div class="mt-8">{{ $products->links() }}</div>
        @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">No products found</h3>
            <p class="text-sm text-gray-400">Try adjusting your filters</p>
        </div>
        @endif
    </div>
</div>
@endsection