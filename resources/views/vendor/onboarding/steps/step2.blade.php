<div class="mb-8">
    <h1 class="text-2xl font-black text-gray-900 mb-1">Contact & Location</h1>
    <p class="text-gray-400 text-sm">Used for order pickups and business communication.</p>
</div>

<form action="{{ route('vendor.onboarding.save2') }}" method="POST" class="space-y-5">
    @csrf

    <!-- Phone -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Phone Number <span class="text-red-400">*</span>
        </label>
        <div class="flex gap-2">
            <div class="flex items-center px-3 border border-gray-200 rounded-xl bg-gray-50 text-sm text-gray-500 shrink-0">
                🇮🇳 +91
            </div>
            <input type="tel" name="phone"
                   value="{{ old('phone', $profile?->phone) }}"
                   placeholder="9876543210"
                   maxlength="10"
                   class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Address -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Street Address <span class="text-red-400">*</span>
        </label>
        <input type="text" name="address"
               value="{{ old('address', $profile?->address) }}"
               placeholder="123, MG Road, Near City Mall"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- City + State -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                City <span class="text-red-400">*</span>
            </label>
            <input type="text" name="city"
                   value="{{ old('city', $profile?->city) }}"
                   placeholder="Mumbai"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                State <span class="text-red-400">*</span>
            </label>
            <select name="state"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                <option value="">Select State</option>
                @foreach(['Andhra Pradesh','Assam','Bihar','Delhi','Gujarat','Haryana','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Punjab','Rajasthan','Tamil Nadu','Telangana','Uttar Pradesh','West Bengal'] as $state)
                <option value="{{ $state }}"
                    {{ old('state', $profile?->state) === $state ? 'selected' : '' }}>
                    {{ $state }}
                </option>
                @endforeach
            </select>
            @error('state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- ZIP + Country -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                PIN Code <span class="text-red-400">*</span>
            </label>
            <input type="text" name="zip"
                   value="{{ old('zip', $profile?->zip) }}"
                   placeholder="400001"
                   maxlength="6"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            @error('zip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                Country <span class="text-red-400">*</span>
            </label>
            <input type="text" name="country"
                   value="{{ old('country', $profile?->country ?? 'India') }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm bg-gray-50
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            @error('country') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="flex gap-3 pt-2">
        <a href="{{ route('vendor.onboarding.step', 1) }}"
           class="flex-1 border-2 border-gray-200 text-gray-600 py-3.5 rounded-xl font-bold text-sm
                  hover:border-gray-300 transition text-center">
            ← Back
        </a>
        <button type="submit"
                class="flex-1 bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm
                       hover:bg-indigo-700 transition flex items-center justify-center gap-2">
            Continue to Bank Details →
        </button>
    </div>
</form>