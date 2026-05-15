@extends('layouts.customer')
@section('title', 'Order Confirmed')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@500&display=swap');

    .success-page { font-family: 'DM Sans', sans-serif; }

    .checkmark-ring {
        animation: popIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    @keyframes popIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    .check-path {
        stroke-dasharray: 30;
        stroke-dashoffset: 30;
        animation: drawCheck 0.5s ease 0.4s forwards;
    }
    @keyframes drawCheck {
        to { stroke-dashoffset: 0; }
    }

    .fade-up {
        opacity: 0;
        transform: translateY(18px);
        animation: fadeUp 0.5s ease forwards;
    }
    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .order-number-badge {
        font-family: 'JetBrains Mono', monospace;
        letter-spacing: 0.08em;
    }

    .trust-badge {
        transition: transform 0.2s ease;
    }
    .trust-badge:hover { transform: translateY(-2px); }

    .item-row {
        opacity: 0;
        transform: translateX(-10px);
        animation: slideIn 0.4s ease forwards;
    }
    @keyframes slideIn {
        to { opacity: 1; transform: translateX(0); }
    }

    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        transition: all 0.2s ease;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    }

    .confetti-dot {
        position: absolute;
        width: 6px; height: 6px;
        border-radius: 50%;
        animation: confettiFall 1s ease forwards;
    }
    @keyframes confettiFall {
        0% { opacity: 1; transform: translateY(0) rotate(0deg); }
        100% { opacity: 0; transform: translateY(60px) rotate(360deg); }
    }
</style>

<div class="success-page max-w-xl mx-auto py-10 px-4">

    <!-- Success Hero -->
    <div class="text-center mb-8 fade-up" style="animation-delay: 0.05s">

        <!-- Animated checkmark -->
        <div class="relative inline-block mb-6">
            <!-- Confetti dots -->
            <span class="confetti-dot bg-indigo-400" style="top:-10px;left:10px;animation-delay:0.5s"></span>
            <span class="confetti-dot bg-emerald-400" style="top:-5px;right:8px;animation-delay:0.6s"></span>
            <span class="confetti-dot bg-amber-400" style="top:5px;left:-12px;animation-delay:0.7s"></span>
            <span class="confetti-dot bg-pink-400" style="top:0;right:-14px;animation-delay:0.65s"></span>

            <div class="checkmark-ring w-24 h-24 rounded-full flex items-center justify-center mx-auto"
                 style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); box-shadow: 0 0 0 8px #ecfdf5, 0 0 0 16px #d1fae510;">
                <svg class="w-11 h-11" fill="none" stroke="#059669" viewBox="0 0 24 24" stroke-width="2.5">
                    <path class="check-path" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-1" style="font-family:'DM Serif Display',serif;">
            Order Confirmed!
        </h1>
        <p class="text-gray-500 text-sm mb-4">
            Your order has been placed and is being processed.
        </p>

        <!-- Order number -->
        <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-100
                    text-indigo-700 px-5 py-2.5 rounded-xl mb-1">
            <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span class="order-number-badge text-sm font-semibold">{{ $order->order_number }}</span>
        </div>
        <p class="text-xs text-gray-400 mt-1.5">A confirmation email has been sent to your inbox</p>
    </div>

    <!-- Trust Badges -->
    <div class="fade-up grid grid-cols-3 gap-3 mb-6" style="animation-delay:0.15s">
        <div class="trust-badge bg-white border border-gray-100 rounded-2xl p-3 text-center shadow-sm">
            <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <p class="text-xs font-semibold text-gray-700">Secure</p>
            <p class="text-xs text-gray-400">256-bit SSL</p>
        </div>
        <div class="trust-badge bg-white border border-gray-100 rounded-2xl p-3 text-center shadow-sm">
            <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <p class="text-xs font-semibold text-gray-700">Stripe</p>
            <p class="text-xs text-gray-400">Powered</p>
        </div>
        <div class="trust-badge bg-white border border-gray-100 rounded-2xl p-3 text-center shadow-sm">
            <div class="w-8 h-8 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <p class="text-xs font-semibold text-gray-700">Tracked</p>
            <p class="text-xs text-gray-400">Delivery</p>
        </div>
    </div>

    <!-- Order Items Card -->
    <div class="fade-up bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-4"
         style="animation-delay:0.25s">

        <div class="px-5 py-4 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-semibold text-gray-900 text-sm">Items Ordered</h3>
            <span class="text-xs text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full">
                {{ $order->orderItems->count() }} item{{ $order->orderItems->count() > 1 ? 's' : '' }}
            </span>
        </div>

        <div class="divide-y divide-gray-50">
            @foreach($order->orderItems as $i => $item)
            <div class="item-row flex items-center gap-4 px-5 py-4"
                 style="animation-delay: {{ 0.3 + $i * 0.08 }}s">
                <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-50 shrink-0 ring-1 ring-gray-100">
                    @if($item->product->primaryImage)
                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->product->name }}</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-xs text-gray-400">Qty: {{ $item->quantity }}</span>
                        <span class="w-1 h-1 bg-gray-200 rounded-full"></span>
                        <span class="text-xs text-gray-400">₹{{ number_format($item->price, 2) }} each</span>
                    </div>
                </div>
                <p class="text-sm font-bold text-gray-900 shrink-0">
                    ₹{{ number_format($item->price * $item->quantity, 2) }}
                </p>
            </div>
            @endforeach
        </div>

        <!-- Total -->
        <div class="px-5 py-4 bg-gray-50 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Amount Charged</p>
                <p class="text-lg font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</p>
            </div>
            <div class="flex items-center gap-1.5 bg-emerald-50 text-emerald-700 
                        text-xs font-semibold px-3 py-1.5 rounded-full">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                Payment Successful
            </div>
        </div>
    </div>

    <!-- What's Next -->
    <div class="fade-up bg-indigo-50 border border-indigo-100 rounded-2xl p-5 mb-6"
         style="animation-delay:0.4s">
        <h4 class="text-xs font-semibold text-indigo-700 uppercase tracking-wider mb-3">What happens next?</h4>
        <div class="space-y-3">
            @foreach([
                ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'title' => 'Confirmation Email', 'desc' => 'Check your inbox for order details'],
                ['icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4', 'title' => 'Order Processing', 'desc' => 'Your vendor is preparing your order'],
                ['icon' => 'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0', 'title' => 'Delivery', 'desc' => 'Shipped to your address shortly'],
            ] as $step)
            <div class="flex items-start gap-3">
                <div class="w-7 h-7 bg-white rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-indigo-800">{{ $step['title'] }}</p>
                    <p class="text-xs text-indigo-500">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- CTA Buttons -->
    <div class="fade-up flex gap-3" style="animation-delay:0.5s">
        <a href="{{ route('customer.shop') }}"
           class="btn-primary flex-1 text-white py-3.5 rounded-xl font-semibold text-sm text-center">
            Continue Shopping
        </a>
        <a href="{{ route('customer.dashboard') }}"
           class="flex-1 bg-white border-2 border-gray-200 text-gray-700 py-3.5 rounded-xl 
                  font-semibold text-sm text-center hover:border-indigo-300 hover:text-indigo-600 transition-all">
            My Dashboard
        </a>
    </div>

</div>
@endsection