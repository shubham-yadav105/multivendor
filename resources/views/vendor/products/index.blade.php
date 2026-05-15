@extends('layouts.vendor')
@section('title', 'My Products')
@section('subtitle', 'Manage your product listings')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h3 class="text-lg font-black text-gray-900">All Products</h3>
        <p class="text-sm text-gray-400">{{ $products->total() }} products listed</p>
    </div>
    <a href="{{ route('vendor.products.create') }}"
       class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2.5
              rounded-xl text-sm font-bold hover:bg-indigo-700 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Product
    </a>
</div>

<!-- Products Table -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
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
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                            @if($product->primaryImage && $product->primaryImage->image_path !== 'placeholder.jpg')
                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-violet-100
                                            flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 line-clamp-1">{{ $product->name }}</p>
                            <p class="text-xs text-gray-400 font-mono">{{ $product->slug }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs bg-indigo-50 text-indigo-600 font-medium px-2.5 py-1 rounded-full">
                        {{ $product->category->name }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-black text-gray-900">₹{{ number_format($product->price, 2) }}</p>
                    @if($product->discount_price)
                    <p class="text-xs text-gray-400 line-through">₹{{ number_format($product->discount_price, 2) }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm font-semibold {{ $product->stock < 5 ? 'text-red-500' : 'text-gray-700' }}">
                        {{ $product->stock }}
                        @if($product->stock < 5)
                        <span class="text-xs text-red-400">(low)</span>
                        @endif
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ $product->status === 'active'
                           ? 'bg-emerald-100 text-emerald-700'
                           : 'bg-red-100 text-red-600' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('vendor.products.edit', $product) }}"
                           class="text-xs bg-indigo-50 text-indigo-600 font-bold px-3 py-1.5
                                  rounded-lg hover:bg-indigo-100 transition">
                            Edit
                        </a>
                        <form action="{{ route('vendor.products.destroy', $product) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-red-50 text-red-500 font-bold px-3 py-1.5
                                          rounded-lg hover:bg-red-100 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center">
                    <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-700 mb-1">No products yet</h3>
                    <p class="text-sm text-gray-400 mb-5">Start adding products to your store</p>
                    <a href="{{ route('vendor.products.create') }}"
                       class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5
                              rounded-xl text-sm font-bold hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add First Product
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($products->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection