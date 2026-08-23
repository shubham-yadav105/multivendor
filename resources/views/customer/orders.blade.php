@extends('layouts.customer')
@section('title', 'My Orders')

@section('content')
<div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-black text-gray-900 mb-6">My Orders</h1>

    {{-- @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-6 flex items-center gap-2">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif --}}

    @forelse($orders as $order)
    @php
        $statusColors = [
            'pending'    => 'bg-amber-100 text-amber-700',
            'processing' => 'bg-blue-100 text-blue-700',
            'shipped'    => 'bg-violet-100 text-violet-700',
            'delivered'  => 'bg-emerald-100 text-emerald-700',
            'cancelled'  => 'bg-red-100 text-red-700',
        ];
    @endphp
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-4">

        <!-- Order Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="flex items-center gap-4">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Order Number</p>
                    <p class="text-sm font-mono font-bold text-gray-800">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Date</p>
                    <p class="text-sm font-semibold text-gray-700">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Total</p>
                    <p class="text-sm font-black text-indigo-600">${{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold px-3 py-1 rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                    {{ ucfirst($order->status) }}
                </span>
                <a href="{{ route('customer.orders.show', $order) }}"
                   class="text-xs bg-indigo-50 text-indigo-600 font-bold px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition">
                    View Details
                </a>
            </div>
        </div>

        <!-- Order Items -->
        <div class="divide-y divide-gray-50">
            @foreach($order->orderItems as $item)
            <div class="flex items-center gap-4 px-6 py-4">
                <!-- Product Image -->
                <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                    @if($item->product->primaryImage)
                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                             class="w-full h-full object-cover">
                    @endif
                </div>

                <!-- Product Info -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->product->name }}</p>
                    <p class="text-xs text-gray-400">Qty: {{ $item->quantity }} · ${{ number_format($item->price, 2) }} each</p>
                </div>

                <!-- Item Status + Review -->
                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-100' }}">
                        {{ ucfirst($item->status) }}
                    </span>

                    @if($item->status === 'delivered')
                        @if($item->review)
                            <!-- Already reviewed -->
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $item->review->rating ? 'text-amber-400' : 'text-gray-200' }}"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                                <span class="text-xs text-gray-400 ml-1">Reviewed</span>
                            </div>
                        @else
                            <!-- Write review button -->
                            <a href="{{ route('customer.review.create', $item) }}"
                               class="flex items-center gap-1.5 text-xs bg-amber-50 text-amber-600
                                      font-bold px-3 py-1.5 rounded-lg hover:bg-amber-100 transition">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Write Review
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="text-center py-24 bg-white rounded-2xl border border-gray-100">
        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
        </svg>
        <h3 class="text-lg font-bold text-gray-700 mb-1">No orders yet</h3>
        <p class="text-sm text-gray-400 mb-5">Start shopping to see your orders here</p>
        <a href="{{ route('shop') }}"
           class="inline-block bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition">
            Browse Shop
        </a>
    </div>
    @endforelse

    @if($orders->hasPages())
    <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</div>
@endsection