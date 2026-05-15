@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)
@section('subtitle', 'Order details and status management')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Orders
        </a>

        <!-- Update Status -->
        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-2">
            @csrf
            <select name="status"
                    class="border border-gray-200 rounded-xl px-4 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                    {{ ucfirst($s) }}
                </option>
                @endforeach
            </select>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition">
                Update Status
            </button>
        </form>
    </div>

    <!-- Order Info -->
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Order Number</p>
            <p class="font-mono font-black text-gray-900">{{ $order->order_number }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Total Amount</p>
            <p class="text-xl font-black text-indigo-600">₹{{ number_format($order->total_amount, 2) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Date Placed</p>
            <p class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>
    </div>

    <!-- Customer + Shipping -->
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-bold text-gray-900 mb-3">Customer</h3>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-black">
                    {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ $order->customer->name }}</p>
                    <p class="text-xs text-gray-400">{{ $order->customer->email }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-bold text-gray-900 mb-3">Shipping Address</h3>
            @php $addr = json_decode($order->shipping_address, true); @endphp
            <p class="text-sm text-gray-700">{{ $addr['name'] ?? '' }}</p>
            <p class="text-sm text-gray-500">{{ $addr['address'] ?? '' }}</p>
            <p class="text-sm text-gray-500">{{ $addr['city'] ?? '' }}, {{ $addr['zip'] ?? '' }}</p>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">Order Items</h3>
        </div>
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-50">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Product</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Vendor</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Qty</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Price</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($order->orderItems as $item)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                @if($item->product->primaryImage)
                                <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                                     class="w-full h-full object-cover">
                                @endif
                            </div>
                            <p class="text-sm font-semibold text-gray-800">{{ $item->product->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->product->vendor->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700 font-medium">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">${{ number_format($item->price, 2) }}</td>
                    <td class="px-6 py-4 text-sm font-black text-gray-900">
                        ₹{{ number_format($item->price * $item->quantity, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t border-gray-100 bg-gray-50">
                    <td colspan="4" class="px-6 py-4 text-sm font-bold text-gray-900 text-right">Total</td>
                    <td class="px-6 py-4 text-base font-black text-indigo-600">
                        ₹{{ number_format($order->total_amount, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection