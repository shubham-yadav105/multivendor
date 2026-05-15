<div class="mb-8">
    <h1 class="text-2xl font-black text-gray-900 mb-1">Identity Verification</h1>
    <p class="text-gray-400 text-sm">We need to verify your identity as required by law.</p>
</div>

<form action="{{ route('vendor.onboarding.save4') }}" method="POST"
      enctype="multipart/form-data" class="space-y-5" x-data="{ idType: '{{ old('id_type', $profile?->id_type ?? 'aadhar') }}', preview: null }">
    @csrf

    <!-- ID Type -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
            Document Type <span class="text-red-400">*</span>
        </label>
        <div class="grid grid-cols-3 gap-3">
            @foreach([['aadhar', '🪪', 'Aadhaar Card', '12-digit number'], ['pan', '💳', 'PAN Card', '10-character code'], ['passport', '📘', 'Passport', '8-character number']] as [$val, $emoji, $label, $hint])
            <label class="cursor-pointer">
                <input type="radio" name="id_type" value="{{ $val }}"
                       class="hidden peer"
                       x-model="idType"
                       {{ old('id_type', $profile?->id_type ?? 'aadhar') === $val ? 'checked' : '' }}>
                <div class="peer-checked:border-indigo-600 peer-checked:bg-indigo-50
                            border-2 border-gray-200 rounded-xl p-3 text-center
                            hover:border-indigo-300 transition">
                    <span class="text-xl block mb-1">{{ $emoji }}</span>
                    <p class="text-xs font-bold text-gray-800">{{ $label }}</p>
                    <p class="text-xs text-gray-400">{{ $hint }}</p>
                </div>
            </label>
            @endforeach
        </div>
        @error('id_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- ID Number -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            <span x-text="idType === 'aadhar' ? 'Aadhaar Number' : (idType === 'pan' ? 'PAN Number' : 'Passport Number')"></span>
            <span class="text-red-400">*</span>
        </label>
        <input type="text" name="id_number"
               value="{{ old('id_number', $profile?->id_number) }}"
               :placeholder="idType === 'aadhar' ? '1234 5678 9012' : (idType === 'pan' ? 'ABCDE1234F' : 'A1234567')"
               :maxlength="idType === 'aadhar' ? '14' : (idType === 'pan' ? '10' : '8')"
               style="text-transform: uppercase"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono uppercase
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        @error('id_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Upload Document -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
            Upload Document <span class="text-red-400">*</span>
        </label>

        <label class="cursor-pointer block"
               x-on:dragover.prevent x-on:drop.prevent="
                   let file = $event.dataTransfer.files[0];
                   preview = URL.createObjectURL(file);
               ">
            <input type="file" name="id_document" class="hidden"
                   accept=".jpg,.jpeg,.png,.pdf"
                   @change="preview = URL.createObjectURL($event.target.files[0])">

            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center
                        hover:border-indigo-400 hover:bg-indigo-50 transition">
                <template x-if="!preview">
                    <div>
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm font-semibold text-gray-600">
                            Drop your document here or <span class="text-indigo-600">browse</span>
                        </p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG or PDF — max 5MB</p>
                    </div>
                </template>
                <template x-if="preview">
                    <div>
                        <img :src="preview" class="w-32 h-20 object-cover rounded-xl mx-auto mb-2">
                        <p class="text-xs text-green-600 font-semibold">✅ Document uploaded — click to change</p>
                    </div>
                </template>
            </div>
        </label>

        @if($profile?->id_document && !old('id_document'))
        <p class="text-xs text-emerald-600 mt-1 font-medium">
            ✅ Document already uploaded. Upload new one to replace.
        </p>
        @endif
        @error('id_document') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex gap-3 pt-2">
        <a href="{{ route('vendor.onboarding.step', 3) }}"
           class="flex-1 border-2 border-gray-200 text-gray-600 py-3.5 rounded-xl font-bold text-sm
                  hover:border-gray-300 transition text-center">
            ← Back
        </a>
        <button type="submit"
                class="flex-1 bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm
                       hover:bg-indigo-700 transition flex items-center justify-center gap-2">
            Review & Submit →
        </button>
    </div>
</form>