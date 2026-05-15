<div class="mb-8">
    <h1 class="text-2xl font-black text-gray-900 mb-1">Tell us about your shop</h1>
    <p class="text-gray-400 text-sm">This information will be shown to customers on your store page.</p>
</div>

<form action="{{ route('vendor.onboarding.save1') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf

    <!-- Shop Logo Upload -->
    <div x-data="{ preview: null }">
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
            Shop Logo
        </label>
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 rounded-2xl border-2 border-dashed border-gray-200 overflow-hidden
                        flex items-center justify-center bg-gray-50 shrink-0">
                <template x-if="preview">
                    <img :src="preview" class="w-full h-full object-cover">
                </template>
                <template x-if="!preview">
                    @if($profile?->shop_logo)
                        <img src="{{ asset('storage/' . $profile->shop_logo) }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586"/>
                        </svg>
                    @endif
                </template>
            </div>
            <div>
                <label class="cursor-pointer inline-flex items-center gap-2 bg-indigo-50 text-indigo-600
                              font-semibold text-sm px-4 py-2.5 rounded-xl hover:bg-indigo-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Upload Logo
                    <input type="file" name="shop_logo" class="hidden" accept="image/*"
                           @change="preview = URL.createObjectURL($event.target.files[0])">
                </label>
                <p class="text-xs text-gray-400 mt-1.5">JPG or PNG, max 2MB</p>
            </div>
        </div>
        @error('shop_logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Shop Name -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Shop Name <span class="text-red-400">*</span>
        </label>
        <input type="text" name="shop_name"
               value="{{ old('shop_name', $profile?->shop_name) }}"
               placeholder="e.g. TechZone Electronics"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        @error('shop_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Shop Category -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Primary Category <span class="text-red-400">*</span>
        </label>
        <select name="shop_category"
                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            <option value="">-- Select your main category --</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->name }}"
                {{ old('shop_category', $profile?->shop_category) === $cat->name ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>
        @error('shop_category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Business Type -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
            Business Type <span class="text-red-400">*</span>
        </label>
        <div class="grid grid-cols-2 gap-3">
            @foreach([['individual', '👤', 'Individual', 'Personal seller or freelancer'], ['company', '🏢', 'Company', 'Registered business entity']] as [$val, $emoji, $label, $sub])
            <label class="cursor-pointer">
                <input type="radio" name="business_type" value="{{ $val }}" class="hidden peer"
                       {{ old('business_type', $profile?->business_type ?? 'individual') === $val ? 'checked' : '' }}>
                <div class="peer-checked:border-indigo-600 peer-checked:bg-indigo-50
                            border-2 border-gray-200 rounded-xl p-4 hover:border-indigo-300 transition">
                    <span class="text-2xl block mb-1">{{ $emoji }}</span>
                    <p class="text-sm font-bold text-gray-800">{{ $label }}</p>
                    <p class="text-xs text-gray-400">{{ $sub }}</p>
                </div>
            </label>
            @endforeach
        </div>
        @error('business_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Description -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Shop Description <span class="text-red-400">*</span>
        </label>
        <textarea name="shop_description" rows="4"
                  placeholder="Tell customers what you sell, your speciality, and why they should buy from you... (minimum 20 characters)"
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none
                         focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">{{ old('shop_description', $profile?->shop_description) }}</textarea>
        @error('shop_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <button type="submit"
            class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm
                   hover:bg-indigo-700 active:scale-[0.99] transition-all flex items-center justify-center gap-2">
        Continue to Contact Details
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
    </button>
</form>