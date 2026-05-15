@extends('layouts.admin')
@section('title', 'Categories')
@section('subtitle', 'Manage product categories')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Add Category Form -->
    <div class="lg:col-span-1 space-y-5">

        <!-- Add Parent Category -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Add Category</h3>

            <form action="{{ route('admin.categories.store') }}" method="POST"
                  enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Category Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g. Electronics"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Parent Category
                        <span class="text-gray-400 font-normal normal-case">(optional — for subcategory)</span>
                    </label>
                    <select name="parent_id"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">None (Top Level)</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Image -->
                <div x-data="{ preview: null }">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Category Image
                    </label>
                    <label class="cursor-pointer block">
                        <input type="file" name="image" class="hidden" accept="image/*"
                               @change="preview = URL.createObjectURL($event.target.files[0])">
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center
                                    hover:border-indigo-400 hover:bg-indigo-50 transition">
                            <template x-if="!preview">
                                <div>
                                    <svg class="w-6 h-6 text-gray-300 mx-auto mb-1" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="text-xs text-gray-400">Click to upload image</p>
                                </div>
                            </template>
                            <template x-if="preview">
                                <img :src="preview" class="w-16 h-16 object-cover rounded-lg mx-auto">
                            </template>
                        </div>
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2.5 rounded-xl font-bold text-sm
                               hover:bg-indigo-700 transition">
                    Add Category
                </button>
            </form>
        </div>

        <!-- Stats -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Overview</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Parent Categories</span>
                    <span class="font-black text-gray-900">{{ $categories->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Subcategories</span>
                    <span class="font-black text-gray-900">
                        {{ $categories->sum(fn($c) => $c->children->count()) }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Total Products</span>
                    <span class="font-black text-gray-900">
                        {{ $categories->sum('products_count') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories List -->
    <div class="lg:col-span-2 space-y-4">

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            ✅ {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            ❌ {{ session('error') }}
        </div>
        @endif

        @forelse($categories as $category)
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
             x-data="{ expanded: false, editing: false }">

            <!-- Parent Category Row -->
            <div class="flex items-center gap-4 p-5">

                <!-- Icon/Image -->
                <div class="w-12 h-12 rounded-xl overflow-hidden bg-indigo-50 shrink-0 flex items-center justify-center">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}"
                             class="w-full h-full object-cover">
                    @else
                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                        </svg>
                    @endif
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-0.5">
                        <p class="font-bold text-gray-900">{{ $category->name }}</p>
                        <span class="text-xs bg-indigo-50 text-indigo-600 font-medium px-2 py-0.5 rounded-full">
                            Parent
                        </span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-gray-400">
                        <span>{{ $category->products_count }} products</span>
                        <span>·</span>
                        <span>{{ $category->children->count() }} subcategories</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2 shrink-0">
                    @if($category->children->count() > 0)
                    <button @click="expanded = !expanded"
                            class="text-xs bg-gray-100 text-gray-600 font-bold px-3 py-1.5
                                   rounded-lg hover:bg-gray-200 transition flex items-center gap-1">
                        <svg class="w-3 h-3 transition-transform" :class="expanded ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <span x-text="expanded ? 'Hide' : 'Subcategories'"></span>
                    </button>
                    @endif

                    <button @click="editing = !editing"
                            class="text-xs bg-indigo-50 text-indigo-600 font-bold px-3 py-1.5
                                   rounded-lg hover:bg-indigo-100 transition">
                        Edit
                    </button>

                    <form action="{{ route('admin.categories.destroy', $category) }}"
                          method="POST"
                          onsubmit="return confirm('Delete {{ $category->name }}? This also deletes all subcategories!')">
                        @csrf @method('DELETE')
                        <button class="text-xs bg-red-50 text-red-500 font-bold px-3 py-1.5
                                       rounded-lg hover:bg-red-100 transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Edit Form -->
            <div x-show="editing" x-transition class="border-t border-gray-100 p-5 bg-gray-50">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST"
                      enctype="multipart/form-data" class="flex gap-3">
                    @csrf @method('PUT')
                    <input type="text" name="name" value="{{ $category->name }}"
                           class="flex-1 border border-gray-200 rounded-xl px-4 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <label class="cursor-pointer flex items-center gap-1.5 bg-white border border-gray-200
                                  rounded-xl px-3 py-2 text-sm text-gray-500 hover:border-indigo-400 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586"/>
                        </svg>
                        Image
                        <input type="file" name="image" class="hidden" accept="image/*">
                    </label>
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition">
                        Save
                    </button>
                    <button type="button" @click="editing = false"
                            class="text-gray-400 hover:text-gray-600 px-3 text-sm">
                        Cancel
                    </button>
                </form>
            </div>

            <!-- Subcategories -->
            <div x-show="expanded" x-transition class="border-t border-gray-100">
                @foreach($category->children as $child)
                <div class="flex items-center gap-4 px-5 py-3 hover:bg-gray-50 transition"
                     x-data="{ editChild: false }">
                    <div class="w-1 h-8 bg-indigo-100 rounded-full shrink-0 ml-4"></div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-700">{{ $child->name }}</p>
                        <p class="text-xs text-gray-400">{{ $child->products->count() }} products</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button @click="editChild = !editChild"
                                class="text-xs bg-indigo-50 text-indigo-600 font-bold px-2.5 py-1
                                       rounded-lg hover:bg-indigo-100 transition">
                            Edit
                        </button>
                        <form action="{{ route('admin.categories.destroy', $child) }}"
                              method="POST"
                              onsubmit="return confirm('Delete {{ $child->name }}?')">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-red-50 text-red-500 font-bold px-2.5 py-1
                                           rounded-lg hover:bg-red-100 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Edit Child -->
                <div x-show="editChild" x-transition
                     class="px-5 pb-3 pl-16 bg-gray-50">
                    <form action="{{ route('admin.categories.update', $child) }}" method="POST"
                          class="flex gap-2">
                        @csrf @method('PUT')
                        <input type="text" name="name" value="{{ $child->name }}"
                               class="flex-1 border border-gray-200 rounded-xl px-3 py-1.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button class="bg-indigo-600 text-white px-3 py-1.5 rounded-xl text-xs font-bold hover:bg-indigo-700 transition">
                            Save
                        </button>
                    </form>
                </div>
                @endforeach

                <!-- Add Subcategory -->
                <div class="px-5 py-3 border-t border-gray-50 pl-16"
                     x-data="{ addSub: false }">
                    <button @click="addSub = !addSub"
                            class="text-xs text-indigo-600 font-semibold hover:underline flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Subcategory
                    </button>
                    <div x-show="addSub" x-transition class="mt-2">
                        <form action="{{ route('admin.categories.store') }}" method="POST"
                              class="flex gap-2">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $category->id }}">
                            <input type="text" name="name" placeholder="Subcategory name"
                                   class="flex-1 border border-gray-200 rounded-xl px-3 py-1.5 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <button class="bg-indigo-600 text-white px-3 py-1.5 rounded-xl text-xs font-bold hover:bg-indigo-700 transition">
                                Add
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
            </svg>
            <p class="text-gray-400 text-sm">No categories yet. Add your first one!</p>
        </div>
        @endforelse
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection