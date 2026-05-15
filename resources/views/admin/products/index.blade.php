@extends('layouts.admin')
@section('title', 'Products')
@section('subtitle', 'Monitor all vendor products')

@section('content')

<!-- Filters -->
<div class="bg-white rounded-2xl border border-gray-100 p-4 mb-6">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search products..."
               class="flex-1 border border-gray-200 rounded-xl px-4 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <select name="status" class="border border-gray-200 rounded-xl px-4 py-2 text-sm
                                     focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition">
            Filter
        </button>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Vendor</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Price</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock</th>
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                            @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                 class="w-full h-full object-cover">
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-gray-800 line-clamp-1">{{ $product->name }}</p>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $product->vendor->name }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs bg-indigo-50 text-indigo-600 font-medium px-2.5 py-1 rounded-full">
                        {{ $product->category->name }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</p>
                    @if($product->discount_price)
                    <p class="text-xs text-gray-400 line-through">₹{{ number_format($product->discount_price, 2) }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm font-semibold {{ $product->stock < 5 ? 'text-red-500' : 'text-gray-700' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ $product->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <form action="{{ route('admin.products.toggle', $product) }}" method="POST">
                            @csrf
                            <button class="text-xs bg-gray-100 text-gray-600 font-bold px-3 py-1.5 rounded-lg hover:bg-gray-200 transition">
                                {{ $product->status === 'active' ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-red-50 text-red-500 font-bold px-3 py-1.5 rounded-lg hover:bg-red-100 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-400">No products found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
</div>
@endsection