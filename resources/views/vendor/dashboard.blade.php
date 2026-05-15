@extends('layouts.vendor')
@section('title', 'Dashboard')
@section('subtitle', 'Welcome back, ' . auth()->user()->name)

@section('content')

<!-- Approval Warning -->
@php $profile = auth()->user()->vendorProfile; @endphp
@if(!$profile || $profile->status !== 'approved')
<div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 mb-6 flex items-start gap-3">
    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/>
    </svg>
    <div class="flex-1">
        <p class="text-sm font-bold text-amber-800">
            {{ !$profile ? 'Complete your shop profile' : 'Your shop is pending approval' }}
        </p>
        <p class="text-xs text-amber-600 mt-0.5">
            {{ !$profile ? 'Set up your shop profile so admin can review and approve it.' : 'Admin will review your shop soon. You can still add products.' }}
        </p>
    </div>
    @if(!$profile)
    <a href="{{ route('vendor.profile.edit') }}"
       class="text-xs font-bold bg-amber-500 text-white px-3 py-1.5 rounded-lg hover:bg-amber-600 transition shrink-0">
        Setup Now
    </a>
    @endif
</div>
@endif

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
@php
$cards = [
    ['label' => 'Total Earnings', 'value' => '₹' . number_format($stats['total_earnings'], 2), 'sub' => 'All time',      'color' => 'indigo',  'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['label' => 'This Month',     'value' => '₹' . number_format($stats['this_month'], 2),    'sub' => now()->format('M Y'), 'color' => 'emerald', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
    ['label' => 'Total Orders',   'value' => $stats['total_orders'],                          'sub' => 'Received',      'color' => 'violet',  'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
    ['label' => 'Pending Orders', 'value' => $stats['pending_orders'],                        'sub' => 'Need action',   'color' => 'amber',   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['label' => 'Total Products', 'value' => $stats['total_products'],                        'sub' => 'Listed',        'color' => 'pink',    'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
    ['label' => 'Active Products','value' => $stats['active_products'],                       'sub' => 'Live in shop',  'color' => 'sky',     'icon' => 'M5 13l4 4L19 7'],
];
$colorMap = [
    'indigo'  => ['icon' => 'bg-indigo-100 text-indigo-600'],
    'emerald' => ['icon' => 'bg-emerald-100 text-emerald-600'],
    'violet'  => ['icon' => 'bg-violet-100 text-violet-600'],
    'amber'   => ['icon' => 'bg-amber-100 text-amber-600'],
    'pink'    => ['icon' => 'bg-pink-100 text-pink-600'],
    'sky'     => ['icon' => 'bg-sky-100 text-sky-600'],
];
@endphp

@foreach($cards as $card)
@php $c = $colorMap[$card['color']]; @endphp
<div class="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-md transition">
    <div class="w-9 h-9 {{ $c['icon'] }} rounded-xl flex items-center justify-center mb-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
        </svg>
    </div>
    <p class="text-2xl font-black text-gray-900 mb-0.5">{{ $card['value'] }}</p>
    <p class="text-xs font-semibold text-gray-700">{{ $card['label'] }}</p>
    <p class="text-xs text-gray-400">{{ $card['sub'] }}</p>
</div>
@endforeach
</div>

<!-- Bottom Grid -->
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    <!-- Recent Orders -->
    <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-gray-900">Recent Orders</h3>
            <a href="{{ route('vendor.orders.index') }}"
               class="text-xs text-indigo-600 font-semibold hover:underline">View all →</a>
        </div>

        <div class="space-y-3">
            @forelse($recentOrders as $item)
            @php
                $statusColors = [
                    'pending'    => 'bg-amber-100 text-amber-700',
                    'processing' => 'bg-blue-100 text-blue-700',
                    'shipped'    => 'bg-violet-100 text-violet-700',
                    'delivered'  => 'bg-emerald-100 text-emerald-700',
                ];
            @endphp
            <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition">
                <div class="w-11 h-11 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                    @if($item->product->primaryImage)
                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                             class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->product->name }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $item->order->customer->name }} · 
                        <span class="font-mono">{{ $item->order->order_number }}</span>
                    </p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-sm font-black text-gray-900">
                        ₹{{ number_format($item->price * $item->quantity, 2) }}
                    </p>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center py-10">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                </svg>
                <p class="text-sm text-gray-400">No orders yet</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Top Products -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-gray-900">Top Products</h3>
            <a href="{{ route('vendor.products.index') }}"
               class="text-xs text-indigo-600 font-semibold hover:underline">View all →</a>
        </div>

        <div class="space-y-3">
            @forelse($topProducts as $index => $product)
            <div class="flex items-center gap-3">
                <span class="text-xs font-black text-gray-300 w-4 shrink-0">{{ $index + 1 }}</span>
                <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                    @if($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                             class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</p>
                    <p class="text-xs text-gray-400">{{ $product->sales_count }} sales</p>
                </div>
                <p class="text-sm font-black text-indigo-600 shrink-0">
                    ₹{{ number_format($product->price, 2) }}
                </p>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-8">No products yet</p>
            @endforelse
        </div>

        @if($topProducts->isEmpty())
        <a href="{{ route('vendor.products.create') }}"
           class="mt-4 w-full flex items-center justify-center gap-2 border-2 border-dashed
                  border-gray-200 rounded-xl py-3 text-sm text-gray-400 hover:border-indigo-300
                  hover:text-indigo-500 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add your first product
        </a>
        @endif
    </div>
</div>

@endsection