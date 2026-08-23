@extends('layouts.customer')
@section('title', 'Write a Review')

@section('content')
<div class="max-w-xl mx-auto">

    <!-- Product Card -->
    <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-6 flex items-center gap-4">
        <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 shrink-0">
            @if($orderItem->product->primaryImage)
                <img src="{{ asset('storage/' . $orderItem->product->primaryImage->image_path) }}"
                     class="w-full h-full object-cover">
            @endif
        </div>
        <div>
            <p class="font-bold text-gray-900">{{ $orderItem->product->name }}</p>
            <p class="text-xs text-gray-400">Sold by {{ $orderItem->product->vendor->name }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Order: <span class="font-mono">{{ $orderItem->order->order_number }}</span></p>
        </div>
    </div>

    <!-- Review Form -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h1 class="text-xl font-black text-gray-900 mb-6">Write Your Review</h1>

        <form action="{{ route('customer.review.store', $orderItem) }}"
              method="POST" x-data="{ rating: 0, hover: 0 }">
            @csrf

            <!-- Star Rating -->
            <div class="mb-6">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                    Your Rating <span class="text-red-400">*</span>
                </label>

                <div class="flex items-center gap-2">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button"
                            @click="rating = {{ $i }}"
                            @mouseenter="hover = {{ $i }}"
                            @mouseleave="hover = 0"
                            class="transition-transform hover:scale-110">
                        <svg class="w-10 h-10 transition-colors"
                             :class="(hover || rating) >= {{ $i }} ? 'text-amber-400' : 'text-gray-200'"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </button>
                    @endfor

                    <input type="hidden" name="rating" :value="rating">

                    <!-- Rating Label -->
                    <span class="text-sm font-bold ml-2"
                          :class="{
                              'text-red-500':    rating === 1,
                              'text-orange-500': rating === 2,
                              'text-amber-500':  rating === 3,
                              'text-lime-500':   rating === 4,
                              'text-emerald-500':rating === 5,
                          }"
                          x-text="['', '😞 Poor', '😕 Fair', '😐 Good', '😊 Very Good', '🤩 Excellent!'][rating]">
                    </span>
                </div>
                @error('rating')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Review Title -->
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Review Title
                </label>
                <input type="text" name="title"
                       value="{{ old('title') }}"
                       placeholder="Summarize your experience"
                       maxlength="100"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Comment -->
            <div class="mb-6">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                    Detailed Review
                </label>
                <textarea name="comment" rows="4"
                          placeholder="Share your experience with this product..."
                          maxlength="1000"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none
                                 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <a href="{{ route('customer.orders') }}"
                   class="flex-1 border-2 border-gray-200 text-gray-600 py-3 rounded-xl
                          font-bold text-sm hover:border-gray-300 transition text-center">
                    Cancel
                </a>
                <button type="submit"
                        x-bind:disabled="rating === 0"
                        class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-bold text-sm
                               hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Submit Review ⭐
                </button>
            </div>
        </form>
    </div>
</div>
@endsection