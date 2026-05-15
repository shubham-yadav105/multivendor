@extends('layouts.vendor')
@section('title', 'Edit Product')
@section('subtitle', 'Update your product details')

@section('content')

<div class="max-w-3xl mx-auto">

    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('vendor.products.index') }}"
           class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center
                  hover:bg-gray-100 transition">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-lg font-black text-gray-900">Edit Product</h1>
            <p class="text-xs text-gray-400">{{ $product->name }}</p>
        </div>
    </div>

    <form action="{{ route('vendor.products.update', $product) }}" method="POST"
          enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Left Column — Main Info -->
            <div class="lg:col-span-2 space-y-5">

                <!-- Basic Info Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">
                        Basic Information
                    </h3>

                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Product Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name"
                               value="{{ old('name', $product->name) }}"
                               placeholder="Enter product name"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500
                                      focus:border-transparent transition">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Category <span class="text-red-400">*</span>
                        </label>
                        <select name="category_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500
                                       focus:border-transparent transition">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @foreach($category->children as $child)
                                    <option value="{{ $child->id }}"
                                        {{ old('category_id', $product->category_id) == $child->id ? 'selected' : '' }}>
                                        — {{ $child->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Description
                        </label>
                        <textarea name="description" rows="5"
                                  placeholder="Describe your product..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                                         resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500
                                         focus:border-transparent transition">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Pricing Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">
                        Pricing & Stock
                    </h3>

                    <div class="grid grid-cols-3 gap-4">
                        <!-- Price -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                Price (₹) <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">₹</span>
                                <input type="number" step="0.01" name="price"
                                       value="{{ old('price', $product->price) }}"
                                       placeholder="0.00"
                                       class="w-full border border-gray-200 rounded-xl pl-7 pr-4 py-3 text-sm
                                              focus:outline-none focus:ring-2 focus:ring-indigo-500
                                              focus:border-transparent transition">
                            </div>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Discount Price -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                Sale Price (₹)
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">₹</span>
                                <input type="number" step="0.01" name="discount_price"
                                       value="{{ old('discount_price', $product->discount_price) }}"
                                       placeholder="0.00"
                                       class="w-full border border-gray-200 rounded-xl pl-7 pr-4 py-3 text-sm
                                              focus:outline-none focus:ring-2 focus:ring-indigo-500
                                              focus:border-transparent transition">
                            </div>
                        </div>

                        <!-- Stock -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                Stock <span class="text-red-400">*</span>
                            </label>
                            <input type="number" name="stock"
                                   value="{{ old('stock', $product->stock) }}"
                                   placeholder="0"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500
                                          focus:border-transparent transition">
                            @error('stock')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Images Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">
                        Product Images
                    </h3>

                    <!-- Existing Images -->
                    @if($product->images->count())
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 font-semibold mb-2">Current Images</p>
                        <div class="grid grid-cols-5 gap-2">
                            @foreach($product->images as $image)
                            @if($image->image_path !== 'placeholder.jpg')
                            <div class="relative group">
                                <div class="aspect-square rounded-xl overflow-hidden border
                                            {{ $image->is_primary ? 'border-indigo-500 ring-2 ring-indigo-500 ring-offset-1' : 'border-gray-200' }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         class="w-full h-full object-cover">
                                </div>
                                @if($image->is_primary)
                                <span class="absolute -top-1.5 -right-1.5 bg-indigo-600 text-white
                                             text-xs font-bold px-1.5 py-0.5 rounded-full text-[10px]">
                                    Main
                                </span>
                                @endif
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Images -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Add More Images
                        </label>
                        <label class="cursor-pointer block">
                            <input type="file" name="images[]" multiple
                                   accept="image/*" class="hidden"
                                   id="image-upload">
                            <div class="border-2 border-dashed border-gray-200 rounded-xl p-6
                                        text-center hover:border-indigo-400 hover:bg-indigo-50 transition">
                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">
                                    Click to upload or drag & drop
                                </p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB each</p>
                            </div>
                        </label>

                        <!-- Preview new images -->
                        <div id="preview-container" class="grid grid-cols-5 gap-2 mt-3 hidden">
                        </div>

                        @error('images.*')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Right Column — Status & Actions -->
            <div class="space-y-5">

                <!-- Status Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">
                        Status
                    </h3>
                    <select name="status"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-transparent transition">
                        <option value="active"
                            {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>
                             Active
                        </option>
                        <option value="inactive"
                            {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <!-- Product Info Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">
                        Product Info
                    </h3>
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Created</span>
                            <span class="font-semibold text-gray-700">
                                {{ $product->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Last Updated</span>
                            <span class="font-semibold text-gray-700">
                                {{ $product->updated_at->format('M d, Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Product ID</span>
                            <span class="font-mono font-semibold text-gray-700">#{{ $product->id }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button type="submit"
                            class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold text-sm
                                   hover:bg-indigo-700 active:scale-[0.99] transition-all">
                        Save Changes
                    </button>
                    <a href="{{ route('vendor.products.index') }}"
                       class="block w-full border-2 border-gray-200 text-gray-600 py-3 rounded-xl
                              font-bold text-sm hover:border-gray-300 transition text-center">
                        Cancel
                    </a>
                    <form action="{{ route('vendor.products.destroy', $product) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-50 text-red-500 py-3 rounded-xl font-bold text-sm
                                       hover:bg-red-100 transition border border-red-100">
                            Delete Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Preview new images before upload
document.getElementById('image-upload').addEventListener('change', function(e) {
    const container = document.getElementById('preview-container');
    container.innerHTML = '';
    container.classList.remove('hidden');

    [...e.target.files].forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.className = 'relative aspect-square rounded-xl overflow-hidden border border-gray-200';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover">
                ${index === 0 ? '<span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">New</span>' : ''}
            `;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});
</script>

@endsection