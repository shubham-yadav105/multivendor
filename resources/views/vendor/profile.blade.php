@extends('layouts.vendor')
@section('title', 'Shop Profile')
@section('subtitle', 'Manage your shop details')

@section('content')
<div class="max-w-2xl mx-auto">

    <!-- Status Banner -->
    @if($profile)
    @php
        $banners = [
            'pending'  => ['bg' => 'bg-amber-50 border-amber-200',  'text' => 'text-amber-800',  'sub' => 'text-amber-600',  'msg' => 'Your shop is under review. Admin will approve it soon.'],
            'approved' => ['bg' => 'bg-emerald-50 border-emerald-200','text' => 'text-emerald-800','sub' => 'text-emerald-600','msg' => 'Your shop is live! Customers can see your products.'],
            'rejected' => ['bg' => 'bg-red-50 border-red-200',       'text' => 'text-red-800',    'sub' => 'text-red-600',    'msg' => 'Your shop was rejected. Update your info and resubmit.'],
        ];
        $b = $banners[$profile->status] ?? $banners['pending'];
    @endphp
    <div class="border {{ $b['bg'] }} rounded-2xl px-5 py-4 mb-6">
        <p class="text-sm font-bold {{ $b['text'] }}">
            Shop Status: {{ ucfirst($profile->status) }}
        </p>
        <p class="text-xs {{ $b['sub'] }} mt-0.5">{{ $b['msg'] }}</p>
    </div>
    @endif

    <!-- Profile Form -->
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

        <!-- Logo Header -->
        <div class="h-24 bg-gradient-to-r from-indigo-500 to-violet-600 relative">
            <div class="absolute -bottom-8 left-6">
                @if($profile?->shop_logo)
                    <img src="{{ asset('storage/' . $profile->shop_logo) }}"
                         class="w-16 h-16 rounded-2xl border-4 border-white object-cover shadow-lg">
                @else
                    <div class="w-16 h-16 rounded-2xl border-4 border-white bg-indigo-600
                                flex items-center justify-center text-white text-2xl font-black shadow-lg">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
        </div>

        <div class="pt-12 p-6">
            <form action="{{ route('vendor.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Shop Logo -->
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Shop Logo
                    </label>
                    <div class="flex items-center gap-3">
                        <label class="cursor-pointer flex items-center gap-2 border border-dashed border-gray-300
                                      rounded-xl px-4 py-2.5 text-sm text-gray-500 hover:border-indigo-400
                                      hover:text-indigo-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload Logo
                            <input type="file" name="shop_logo" class="hidden" accept="image/*">
                        </label>
                        <span class="text-xs text-gray-400">JPG, PNG up to 2MB</span>
                    </div>
                    @error('shop_logo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Shop Name -->
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Shop Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="shop_name"
                           value="{{ old('shop_name', $profile?->shop_name) }}"
                           placeholder="My Awesome Shop"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    @error('shop_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                        Shop Description
                    </label>
                    <textarea name="shop_description" rows="4"
                              placeholder="Tell customers what you sell and why they should buy from you..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                     focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                     resize-none transition">{{ old('shop_description', $profile?->shop_description) }}</textarea>
                    @error('shop_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account Info (readonly) -->
                <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-xl">
                    <div>
                        <p class="text-xs text-gray-500 font-semibold mb-1">Account Name</p>
                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold mb-1">Email</p>
                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold text-sm
                               hover:bg-indigo-700 active:scale-[0.99] transition-all">
                    Save Shop Profile
                </button>
            </form>
        </div>
    </div>
</div>
@endsection