@extends('layouts.admin')
@section('title', 'Vendors')
@section('subtitle', 'Manage all vendors')

@section('content')

<!-- Filters -->
<div class="bg-white rounded-2xl border border-gray-100 p-4 mb-6">
    <form action="{{ route('admin.vendors.index') }}" method="GET" class="flex gap-3 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search vendor name..."
               class="flex-1 min-w-48 border border-gray-200 rounded-xl px-4 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <select name="status"
                class="border border-gray-200 rounded-xl px-4 py-2 text-sm
                       focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Status</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <button type="submit"
                class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition">
            Filter
        </button>
        @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('admin.vendors.index') }}"
           class="text-gray-400 hover:text-gray-600 px-3 py-2 text-sm">Clear</a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Vendor</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Shop</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Joined</th>
                <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($vendors as $vendor)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-black shrink-0">
                            {{ strtoupper(substr($vendor->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $vendor->name }}</p>
                            <p class="text-xs text-gray-400">{{ $vendor->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-700 font-medium">{{ $vendor->vendorProfile->shop_name ?? '—' }}</p>
                </td>
                <td class="px-6 py-4">
                    @php
                        $sp = $vendor->vendorProfile?->status ?? 'none';
                        $colors = ['pending' => 'bg-amber-100 text-amber-700', 'approved' => 'bg-emerald-100 text-emerald-700', 'rejected' => 'bg-red-100 text-red-600'];
                    @endphp
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $colors[$sp] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($sp) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ $vendor->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ ucfirst($vendor->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-400">
                    {{ $vendor->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        @if($vendor->vendorProfile?->status === 'pending')
                        <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST">
                            @csrf
                            <button class="text-xs bg-emerald-50 text-emerald-600 font-bold px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition">
                                Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.vendors.reject', $vendor) }}" method="POST">
                            @csrf
                            <button class="text-xs bg-red-50 text-red-500 font-bold px-3 py-1.5 rounded-lg hover:bg-red-100 transition">
                                Reject
                            </button>
                        </form>
                        @endif

                        @if($vendor->status === 'active')
                        <form action="{{ route('admin.vendors.block', $vendor) }}" method="POST">
                            @csrf
                            <button class="text-xs bg-gray-100 text-gray-600 font-bold px-3 py-1.5 rounded-lg hover:bg-gray-200 transition">
                                Block
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.vendors.unblock', $vendor) }}" method="POST">
                            @csrf
                            <button class="text-xs bg-indigo-50 text-indigo-600 font-bold px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition">
                                Unblock
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">No vendors found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $vendors->links() }}
    </div>
</div>
@endsection