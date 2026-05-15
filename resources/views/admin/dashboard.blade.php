@extends('layouts.admin')
@section('title', 'Dashboard')
@section('subtitle', 'Here\'s what\'s happening in your store')

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">

    @php
    $cards = [
        ['label' => 'Revenue',       'value' => '₹' . number_format($stats['total_revenue'], 2), 'color' => 'indigo',  'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Orders',        'value' => $stats['total_orders'],   'color' => 'violet',  'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label' => 'Pending',       'value' => $stats['pending_orders'], 'color' => 'amber',   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Products',      'value' => $stats['total_products'], 'color' => 'emerald', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
        ['label' => 'Vendors',       'value' => $stats['total_vendors'],  'color' => 'pink',    'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
        ['label' => 'Customers',     'value' => $stats['total_users'],    'color' => 'sky',     'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
    ];
    $colorMap = [
        'indigo'  => ['bg' => 'bg-indigo-50',  'text' => 'text-indigo-600',  'icon' => 'bg-indigo-100'],
        'violet'  => ['bg' => 'bg-violet-50',  'text' => 'text-violet-600',  'icon' => 'bg-violet-100'],
        'amber'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-600',   'icon' => 'bg-amber-100'],
        'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'bg-emerald-100'],
        'pink'    => ['bg' => 'bg-pink-50',    'text' => 'text-pink-600',    'icon' => 'bg-pink-100'],
        'sky'     => ['bg' => 'bg-sky-50',     'text' => 'text-sky-600',     'icon' => 'bg-sky-100'],
    ];
    @endphp

    @foreach($cards as $card)
    @php $c = $colorMap[$card['color']]; @endphp
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 {{ $c['icon'] }} rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 {{ $c['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-black text-gray-900 mb-0.5">{{ $card['value'] }}</p>
        <p class="text-xs text-gray-500 font-medium">{{ $card['label'] }}</p>
    </div>
    @endforeach
</div>

<!-- Two Columns -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-gray-900">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}"
               class="text-xs text-indigo-600 font-semibold hover:underline">View all →</a>
        </div>
        <div class="space-y-3">
            @forelse($recentOrders as $order)
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-400">{{ $order->customer->name }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-sm font-black text-gray-900">₹{{ number_format($order->total_amount, 2) }}</p>
                    @php
                        $statusColors = [
                            'pending'    => 'bg-amber-100 text-amber-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'shipped'    => 'bg-violet-100 text-violet-700',
                            'delivered'  => 'bg-emerald-100 text-emerald-700',
                            'cancelled'  => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">No orders yet</p>
            @endforelse
        </div>
    </div>

   
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold text-gray-900">Pending Vendor Approvals</h3>
            <a href="{{ route('admin.vendors.index', ['status' => 'pending']) }}"
               class="text-xs text-indigo-600 font-semibold hover:underline">View all →</a>
        </div>
        <div class="space-y-3">
            @forelse($pendingVendors as $vendor)
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-black shrink-0">
                    {{ strtoupper(substr($vendor->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $vendor->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $vendor->vendorProfile->shop_name ?? 'N/A' }}</p>
                </div>
                <div class="flex gap-2 shrink-0">
                    <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST">
                        @csrf
                        <button class="text-xs bg-emerald-50 text-emerald-600 font-bold px-3 py-1.5 
                                       rounded-lg hover:bg-emerald-100 transition">
                            Approve
                        </button>
                    </form>
                    <form action="{{ route('admin.vendors.reject', $vendor) }}" method="POST">
                        @csrf
                        <button class="text-xs bg-red-50 text-red-500 font-bold px-3 py-1.5 
                                       rounded-lg hover:bg-red-100 transition">
                            Reject
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">No pending vendors</p>
            @endforelse
        </div>
    </div>
</div>

@endsection