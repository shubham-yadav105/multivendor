@extends('layouts.vendor')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Add New Product</h2>

    <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Product Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Category</label>
            <select name="category_id" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @foreach($category->children as $child)
                        <option value="{{ $child->id }}">— {{ $child->name }}</option>
                    @endforeach
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4"
                class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <!-- Price & Discount -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Price (₹)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2">
                @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Discount Price (₹)</label>
                <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
        </div>

        <!-- Stock -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', 0) }}"
                class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <!-- Images -->
        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Product Images (First = Primary)</label>
            <input type="file" name="images[]" multiple accept="image/*"
                class="w-full border border-gray-300 rounded px-3 py-2">
            @error('images') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Add Product
        </button>
    </form>
</div>

@endsection