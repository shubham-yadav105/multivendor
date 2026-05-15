@extends('layouts.vendor')
@section('title', 'My Orders')
@section('subtitle', 'Orders placed for your products')

@section('content')

<!-- Filters -->
<div class="bg-white rounded-2xl border border-gray-100 p-4 mb-6">
    <form action="{{ route('vendor.orders.index') }}" method="GET" class="flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order number..." class="flex-1 min-w-48 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <select name="status" class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Status</option>
            @foreach(['pending','processing','shipped','delivered'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                {{ ucfirst($s) }}
            </option>
            @endforeach
        </select>
        <button class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition">
            Filter
        </button>
        @if(request()->hasAny(['search','status']))
        <a href="{{ route('vendor.orders.index') }}" class="text-gray-400 hover:text-gray-600 px-3 py-2 text-sm">
            Clear
        </a>
        @endif
    </form>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Order</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Qty</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Earnings</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Update</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($orderItems as $item)
            @php
                $statusColors = [
                    'pending'    => 'bg-amber-100 text-amber-700',
                    'processing' => 'bg-blue-100 text-blue-700',
                    'shipped'    => 'bg-violet-100 text-violet-700',
                    'delivered'  => 'bg-emerald-100 text-emerald-700',
                ];
            @endphp
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                            @if($item->product->primaryImage)
                                <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-gray-800 line-clamp-1 max-w-32">
                            {{ $item->product->name }}
                        </p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-mono font-bold text-gray-700">{{ $item->order->order_number }}</p>
                    <p class="text-xs text-gray-400">{{ $item->created_at->format('M d, Y') }}</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-semibold text-gray-800">{{ $item->order->customer->name }}</p>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-700">
                    × {{ $item->quantity }}
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-black text-indigo-600">
                        ₹{{ number_format($item->price * $item->quantity, 2) }}
                    </p>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <form action="{{ route('vendor.orders.status', $item) }}" method="POST" class="flex items-center justify-end gap-2">
                        @csrf
                        <select name="status"
                                class="border border-gray-200 rounded-lg px-2 py-1.5 text-xs
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @foreach(['pending','processing','shipped','delivered'] as $s)
                            <option value="{{ $s }}" {{ $item->status === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                            @endforeach
                        </select>
                        <button class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-700 transition">
                            Save
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-16 text-center">
                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    </svg>
                    <p class="text-sm text-gray-400">No orders yet</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $orderItems->links() }}
    </div>
</div>
@endsection