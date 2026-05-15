@extends('layouts.customer')
@section('title', 'My Cart')

@section('content')
<div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-black text-gray-900 mb-6">My Cart</h1>

    @if($cartItems->count())
    <div class="flex flex-col lg:flex-row gap-6">

        <!-- Cart Items -->
        <div class="flex-1 space-y-3">
            @foreach($cartItems as $item)
            <div class="bg-white rounded-2xl border border-gray-100 p-4 flex gap-4">

                <!-- Image -->
                <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-50 shrink-0">
                    @if($item->product->primaryImage)
                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-100"></div>
                    @endif
                </div>

                <!-- Details -->
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800 text-sm">{{ $item->product->name }}</h3>
                    <p class="text-xs text-gray-400 mb-2">by {{ $item->product->vendor->name }}</p>
                    <div class="flex items-center justify-between">
                        <span class="font-black text-indigo-600">
                            ₹{{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity, 2) }}
                        </span>

                        <!-- Quantity -->
                        <form action="{{ route('customer.cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}"
                                    class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 
                                           flex items-center justify-center text-gray-600 font-bold transition">
                                −
                            </button>
                            <span class="w-6 text-center text-sm font-semibold">{{ $item->quantity }}</span>
                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                    class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 
                                           flex items-center justify-center text-gray-600 font-bold transition">
                                +
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Remove -->
                <form action="{{ route('customer.cart.remove', $item) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="text-gray-300 hover:text-red-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </form>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="w-full lg:w-72 shrink-0">
            <div class="bg-white rounded-2xl border border-gray-100 p-5 sticky top-24">
                <h3 class="font-bold text-gray-900 mb-4">Order Summary</h3>

                <div class="space-y-2 mb-4 text-sm">
                    <div class="flex justify-between text-gray-500">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Shipping</span>
                        <span class="text-green-600 font-medium">Free</span>
                    </div>
                    <div class="border-t border-gray-100 pt-2 flex justify-between font-black text-gray-900">
                        <span>Total</span>
                        <span>₹{{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <a href="{{ route('customer.checkout') }}"
                   class="block w-full bg-indigo-600 text-white text-center py-3 rounded-xl 
                          font-bold text-sm hover:bg-indigo-700 transition">
                    Proceed to Checkout &rarr;
                </a>

                <a href="{{ route('customer.shop') }}"
                   class="block text-center text-sm text-gray-400 hover:text-gray-600 mt-3">
                    &larr; Continue Shopping
                </a>
            </div>
        </div>
    </div>

    @else
    <div class="text-center py-24 bg-white rounded-2xl border border-gray-100">
        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        <h3 class="text-lg font-bold text-gray-700 mb-1">Your cart is empty</h3>
        <p class="text-sm text-gray-400 mb-5">Looks like you haven't added anything yet</p>
        <a href="{{ route('customer.shop') }}"
           class="inline-block bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition">
            Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection