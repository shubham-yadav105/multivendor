@extends('layouts.customer')
@section('title', 'Home')

@section('content')

    <!-- Hero Section -->
    <div class="rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 
                p-10 mb-10 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10"
             style="background-image: radial-gradient(circle at 20% 50%, white 1px, transparent 1px);
                    background-size: 30px 30px;"></div>
        <div class="relative z-10 max-w-xl">
            <p class="text-indigo-200 text-sm font-medium mb-2 uppercase tracking-widest">Welcome back</p>
            <h1 class="text-4xl font-black mb-4 leading-tight">
                Discover Amazing<br>Products Today
            </h1>
            <p class="text-indigo-100 mb-6 text-sm">
                Shop from hundreds of verified vendors with the best prices.
            </p>
            <a href="{{ route('customer.shop') }}"
               class="inline-flex items-center gap-2 bg-white text-indigo-600 font-bold 
                      px-6 py-3 rounded-xl hover:bg-indigo-50 transition text-sm">
                Browse Shop
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Categories -->
    <div class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-900">Shop by Category</h2>
            <a href="{{ route('customer.shop') }}" class="text-sm text-indigo-600 hover:underline font-medium">
                View all &rarr;
            </a>
        </div>
        <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
            @foreach($categories as $category)
            <a href="{{ route('customer.shop', ['category' => $category->id]) }}"
               class="flex flex-col items-center gap-2 p-4 bg-white rounded-2xl border border-gray-100 
                      hover:border-indigo-200 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 group-hover:bg-indigo-100 
                            flex items-center justify-center transition">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700 text-center">{{ $category->name }}</span>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <div>
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-900">Featured Products</h2>
            <a href="{{ route('customer.shop') }}" class="text-sm text-indigo-600 hover:underline font-medium">
                View all &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($featuredProducts as $product)
            <a href="{{ route('customer.product', $product->slug) }}"
               class="bg-white rounded-2xl border border-gray-100 overflow-hidden 
                      hover:shadow-lg hover:-translate-y-1 transition-all group">

                <!-- Image -->
                <div class="aspect-square bg-gray-50 overflow-hidden relative">
                    @if($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
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
                    <p class="text-xs text-indigo-600 font-medium mb-1">{{ $product->category->name }}</p>
                    <h3 class="text-sm font-semibold text-gray-800 line-clamp-1 mb-2">{{ $product->name }}</h3>
                    @php $avg = $product->averageRating(); @endphp
                    @if($product->reviewsCount() > 0)
                    <div class="flex items-center gap-1 mb-1">
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-3 h-3 {{ $i <= $avg ? 'text-amber-400' : 'text-gray-200' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-400">({{ $product->reviewsCount() }})</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->discount_price)
                                <span class="text-base font-black text-gray-900">₹{{ number_format($product->discount_price, 2) }}</span>
                                <span class="text-xs text-gray-400 line-through ml-1">₹{{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="text-base font-black text-gray-900">₹{{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <form action="{{ route('customer.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" onclick="event.stopPropagation()"
                                    class="w-8 h-8 bg-indigo-600 text-white rounded-xl flex items-center justify-center hover:bg-indigo-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

@endsection