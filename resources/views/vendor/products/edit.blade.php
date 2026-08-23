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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-black text-gray-900">Edit Product</h1>
                <p class="text-xs text-gray-400">{{ $product->name }}</p>
            </div>
        </div>

        <!-- Grid: form (left) + plain div (right) as SIBLINGS -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Left Column — Main Info (this IS the form) -->
            <form id="edit-product-form" action="{{ route('vendor.products.update', $product) }}" method="POST"
                enctype="multipart/form-data" class="lg:col-span-2 space-y-5">
                @csrf @method('PUT')

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
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
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
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @foreach ($category->children as $child)
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
                        <textarea name="description" rows="5" placeholder="Describe your product..."
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
                                    value="{{ old('price', $product->price) }}" placeholder="0.00"
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
                                    value="{{ old('discount_price', $product->discount_price) }}" placeholder="0.00"
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
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
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
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider">
                            Product Images
                        </h3>
                        <span id="image-count-badge"
                            class="text-xs font-semibold px-2 py-1 rounded-full bg-gray-100 text-gray-500">
                            {{ $product->images->where('image_path', '!=', 'placeholder.jpg')->count() }}/8
                        </span>
                    </div>

                    <p class="text-xs text-gray-400 mb-3">
                        Drag images to reorder · Hover an image to set it as main or remove it.
                    </p>

                    <!-- Existing Images -->
                    <div id="current-images-wrap" class="{{ $product->images->where('image_path', '!=', 'placeholder.jpg')->count() ? '' : 'hidden' }} mb-4">
                        <p class="text-xs text-gray-500 font-semibold mb-2">Current Images</p>
                        <div id="image-sort-list" class="grid grid-cols-5 gap-2">
                            @foreach ($product->images as $image)
                                @if ($image->image_path !== 'placeholder.jpg')
                                    <div class="image-tile relative group cursor-grab active:cursor-grabbing"
                                        draggable="true"
                                        data-image-id="{{ $image->id }}">
                                        <div
                                            class="tile-border aspect-square rounded-xl overflow-hidden border
                                            {{ $image->is_primary ? 'border-indigo-500 ring-2 ring-indigo-500 ring-offset-1 is-primary' : 'border-gray-200' }}">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                class="w-full h-full object-cover pointer-events-none">
                                        </div>

                                        <span
                                            class="main-badge absolute -top-1.5 -right-1.5 bg-indigo-600 text-white
                                             text-xs font-bold px-1.5 py-0.5 rounded-full text-[10px] {{ $image->is_primary ? '' : 'hidden' }}">
                                            Main
                                        </span>

                                        <!-- Hover overlay actions -->
                                        <div class="absolute inset-0 rounded-xl bg-black/50 opacity-0 group-hover:opacity-100
                                                    transition flex items-center justify-center gap-2">
                                            <button type="button"
                                                class="set-primary-btn w-7 h-7 rounded-full bg-white/90 hover:bg-white
                                                       flex items-center justify-center {{ $image->is_primary ? 'hidden' : '' }}"
                                                title="Set as main image">
                                                <svg class="w-3.5 h-3.5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.447a1 1 0 00-.363 1.118l1.286 3.957c.3.922-.755 1.688-1.538 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.196-1.538-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.063 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.958z" />
                                                </svg>
                                            </button>
                                            <button type="button"
                                                class="delete-image-btn w-7 h-7 rounded-full bg-white/90 hover:bg-red-50
                                                       flex items-center justify-center"
                                                title="Remove image">
                                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <p id="image-action-error" class="text-red-500 text-xs mb-3 hidden"></p>

                    <!-- Upload New Images -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Add More Images
                        </label>
                        <label class="cursor-pointer block">
                            <input type="file" name="images[]" multiple accept="image/*" class="hidden"
                                id="image-upload">
                            <div id="upload-dropzone"
                                class="border-2 border-dashed border-gray-200 rounded-xl p-6
                                        text-center hover:border-indigo-400 hover:bg-indigo-50 transition">
                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">
                                    Click to upload or drag & drop
                                </p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB each · Max 8 images total</p>
                            </div>
                        </label>

                        <!-- Preview new images -->
                        <div id="preview-container" class="grid grid-cols-5 gap-2 mt-3 hidden">
                        </div>

                        <p id="upload-limit-warning" class="text-red-500 text-xs mt-2 hidden">
                            You can only have 8 images in total. Remove some before adding more.
                        </p>

                        @error('images')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </form>
            <!-- ^ Edit form closes here — it only wraps the LEFT column now -->

            <!-- Right Column — Status, Info & Actions (plain div, NOT a form) -->
            <div class="space-y-5">

                <!-- Status Card -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">
                        Status
                    </h3>
                    <select name="status" form="edit-product-form"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:border-transparent transition">
                        <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>
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

                <!-- Action Buttons — right under Product Info, as intended -->
                <div class="space-y-3">
                    <button type="submit" form="edit-product-form"
                        class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold text-sm
                                   hover:bg-indigo-700 active:scale-[0.99] transition-all">
                        Save Changes
                    </button>
                    <a href="{{ route('vendor.products.index') }}"
                        class="block w-full border-2 border-gray-200 text-gray-600 py-3 rounded-xl
                              font-bold text-sm hover:border-gray-300 transition text-center">
                        Cancel
                    </a>
                    <form action="{{ route('vendor.products.destroy', $product) }}" method="POST"
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
    </div>

    <script>
        const csrfToken = "{{ csrf_token() }}";
        const productId = {{ $product->id }};
        const maxImages = 8;

        const imageUploadInput = document.getElementById('image-upload');
        const previewContainer = document.getElementById('preview-container');
        const countBadge = document.getElementById('image-count-badge');
        const limitWarning = document.getElementById('upload-limit-warning');
        const actionError = document.getElementById('image-action-error');
        const sortList = document.getElementById('image-sort-list');
        const currentImagesWrap = document.getElementById('current-images-wrap');

        function currentImageCount() {
            return sortList ? sortList.querySelectorAll('.image-tile').length : 0;
        }

        function updateCountBadge() {
            const count = currentImageCount();
            countBadge.textContent = count + '/' + maxImages;
            countBadge.classList.toggle('bg-red-50', count >= maxImages);
            countBadge.classList.toggle('text-red-500', count >= maxImages);
            countBadge.classList.toggle('bg-gray-100', count < maxImages);
            countBadge.classList.toggle('text-gray-500', count < maxImages);
        }

        function showActionError(message) {
            actionError.textContent = message;
            actionError.classList.remove('hidden');
            setTimeout(() => actionError.classList.add('hidden'), 4000);
        }

        // ---------- Preview + enforce limit on new uploads ----------
        imageUploadInput.addEventListener('change', function(e) {
            const existing = currentImageCount();
            const files = [...e.target.files];

            if (existing + files.length > maxImages) {
                limitWarning.classList.remove('hidden');
                e.target.value = '';
                previewContainer.innerHTML = '';
                previewContainer.classList.add('hidden');
                return;
            }
            limitWarning.classList.add('hidden');

            previewContainer.innerHTML = '';
            previewContainer.classList.toggle('hidden', files.length === 0);

            files.forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'relative aspect-square rounded-xl overflow-hidden border border-gray-200';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <span class="absolute -top-1 -right-1 bg-emerald-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">New</span>
                    `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });

        // ---------- Delete / Set primary (event delegation) ----------
        if (sortList) {
            sortList.addEventListener('click', async function(e) {
                const tile = e.target.closest('.image-tile');
                if (!tile) return;
                const imageId = tile.dataset.imageId;

                // Delete image
                if (e.target.closest('.delete-image-btn')) {
                    if (!confirm('Remove this image?')) return;

                    try {
                        const res = await fetch(`/vendor/products/${productId}/images/${imageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                        });
                        const data = await res.json();

                        if (!res.ok || !data.success) {
                            showActionError(data.message || 'Could not remove this image.');
                            return;
                        }

                        const wasPrimary = tile.querySelector('.tile-border').classList.contains('is-primary');
                        tile.remove();
                        updateCountBadge();

                        if (currentImageCount() === 0) {
                            currentImagesWrap.classList.add('hidden');
                        }

                        // If we deleted the primary image, mark the first remaining one as Main in the UI
                        if (wasPrimary) {
                            const firstTile = sortList.querySelector('.image-tile');
                            if (firstTile) {
                                firstTile.querySelector('.tile-border').classList.add('is-primary', 'border-indigo-500', 'ring-2', 'ring-indigo-500', 'ring-offset-1');
                                firstTile.querySelector('.tile-border').classList.remove('border-gray-200');
                                firstTile.querySelector('.main-badge').classList.remove('hidden');
                                firstTile.querySelector('.set-primary-btn').classList.add('hidden');
                            }
                        }
                    } catch (err) {
                        showActionError('Something went wrong. Please try again.');
                    }
                    return;
                }

                // Set as primary
                if (e.target.closest('.set-primary-btn')) {
                    try {
                        const res = await fetch(`/vendor/products/${productId}/images/${imageId}/primary`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                        });
                        const data = await res.json();

                        if (!res.ok || !data.success) {
                            showActionError('Could not update the main image.');
                            return;
                        }

                        // Reset all tiles, then mark this one as primary
                        sortList.querySelectorAll('.image-tile').forEach((t) => {
                            t.querySelector('.tile-border').classList.remove('is-primary', 'border-indigo-500', 'ring-2', 'ring-indigo-500', 'ring-offset-1');
                            t.querySelector('.tile-border').classList.add('border-gray-200');
                            t.querySelector('.main-badge').classList.add('hidden');
                            t.querySelector('.set-primary-btn').classList.remove('hidden');
                        });

                        tile.querySelector('.tile-border').classList.add('is-primary', 'border-indigo-500', 'ring-2', 'ring-indigo-500', 'ring-offset-1');
                        tile.querySelector('.tile-border').classList.remove('border-gray-200');
                        tile.querySelector('.main-badge').classList.remove('hidden');
                        tile.querySelector('.set-primary-btn').classList.add('hidden');
                    } catch (err) {
                        showActionError('Something went wrong. Please try again.');
                    }
                }
            });

            // ---------- Drag to reorder ----------
            let dragSrc = null;

            sortList.addEventListener('dragstart', function(e) {
                dragSrc = e.target.closest('.image-tile');
                e.dataTransfer.effectAllowed = 'move';
                dragSrc.classList.add('opacity-40');
            });

            sortList.addEventListener('dragend', function() {
                if (dragSrc) dragSrc.classList.remove('opacity-40');
                dragSrc = null;
            });

            sortList.addEventListener('dragover', function(e) {
                e.preventDefault();
                const target = e.target.closest('.image-tile');
                if (!target || target === dragSrc) return;

                const rect = target.getBoundingClientRect();
                const before = (e.clientX - rect.left) < rect.width / 2;
                sortList.insertBefore(dragSrc, before ? target : target.nextSibling);
            });

            sortList.addEventListener('drop', async function(e) {
                e.preventDefault();
                const order = [...sortList.querySelectorAll('.image-tile')].map(t => t.dataset.imageId);

                try {
                    await fetch(`/vendor/products/${productId}/images/reorder`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ order }),
                    });
                } catch (err) {
                    showActionError('Could not save the new order.');
                }
            });
        }
    </script>

@endsection