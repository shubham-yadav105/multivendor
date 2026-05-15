<div class="mb-8">
    <h1 class="text-2xl font-black text-gray-900 mb-1">Review Your Details</h1>
    <p class="text-gray-400 text-sm">Please review before submitting for admin approval.</p>
</div>

<div class="space-y-4 mb-8">

    <!-- Shop Info -->
    <div class="bg-white border border-gray-100 rounded-2xl p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900">Shop Information</h3>
            <a href="{{ route('vendor.onboarding.step', 1) }}"
               class="text-xs text-indigo-600 font-semibold hover:underline">Edit</a>
        </div>
        <div class="flex items-center gap-4 mb-4">
            @if($profile?->shop_logo)
                <img src="{{ asset('storage/' . $profile->shop_logo) }}"
                     class="w-14 h-14 rounded-xl object-cover border border-gray-100">
            @endif
            <div>
                <p class="font-bold text-gray-900">{{ $profile?->shop_name }}</p>
                <p class="text-xs text-gray-400">{{ $profile?->shop_category }} · {{ ucfirst($profile?->business_type) }}</p>
            </div>
        </div>
        <p class="text-sm text-gray-500 leading-relaxed">{{ $profile?->shop_description }}</p>
    </div>

    <!-- Contact Info -->
    <div class="bg-white border border-gray-100 rounded-2xl p-5">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-gray-900">Contact Details</h3>
            <a href="{{ route('vendor.onboarding.step', 2) }}"
               class="text-xs text-indigo-600 font-semibold hover:underline">Edit</a>
        </div>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Phone</p>
                <p class="font-semibold text-gray-800">+91 {{ $profile?->phone }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">City</p>
                <p class="font-semibold text-gray-800">{{ $profile?->city }}, {{ $profile?->state }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs text-gray-400 mb-0.5">Address</p>
                <p class="font-semibold text-gray-800">{{ $profile?->address }}, {{ $profile?->zip }}</p>
            </div>
        </div>
    </div>

    <!-- Bank Info -->
    <div class="bg-white border border-gray-100 rounded-2xl p-5">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-gray-900">Bank Details</h3>
            <a href="{{ route('vendor.onboarding.step', 3) }}"
               class="text-xs text-indigo-600 font-semibold hover:underline">Edit</a>
        </div>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Bank</p>
                <p class="font-semibold text-gray-800">{{ $profile?->bank_name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">IFSC</p>
                <p class="font-semibold text-gray-800 font-mono">{{ $profile?->bank_ifsc }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Account Holder</p>
                <p class="font-semibold text-gray-800">{{ $profile?->bank_account_name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Account Number</p>
                <p class="font-semibold text-gray-800 font-mono">
                    ****{{ substr($profile?->bank_account_number ?? '0000', -4) }}
                </p>
            </div>
            @if($profile?->gst_number)
            <div class="col-span-2">
                <p class="text-xs text-gray-400 mb-0.5">GST Number</p>
                <p class="font-semibold text-gray-800 font-mono">{{ $profile?->gst_number }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Identity Info -->
    <div class="bg-white border border-gray-100 rounded-2xl p-5">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-gray-900">Identity Proof</h3>
            <a href="{{ route('vendor.onboarding.step', 4) }}"
               class="text-xs text-indigo-600 font-semibold hover:underline">Edit</a>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <p class="text-xs text-gray-400 mb-0.5">Document Type</p>
                <p class="font-semibold text-gray-800">
                    {{ ['aadhar' => 'Aadhaar Card', 'pan' => 'PAN Card', 'passport' => 'Passport'][$profile?->id_type ?? 'aadhar'] }}
                </p>
                <p class="text-xs text-gray-400 mt-2 mb-0.5">Document Number</p>
                <p class="font-semibold text-gray-800 font-mono">{{ $profile?->id_number }}</p>
            </div>
            @if($profile?->id_document)
            <div class="w-20 h-14 rounded-xl overflow-hidden border border-gray-100 shrink-0">
                @if(str_ends_with($profile->id_document, '.pdf'))
                    <div class="w-full h-full bg-red-50 flex items-center justify-center">
                        <span class="text-xs font-bold text-red-500">PDF</span>
                    </div>
                @else
                    <img src="{{ asset('storage/' . $profile->id_document) }}"
                         class="w-full h-full object-cover">
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Agreement -->
<div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-4 mb-6">
    <label class="flex items-start gap-3 cursor-pointer">
        <input type="checkbox" id="agree" class="mt-0.5 text-indigo-600 rounded">
        <p class="text-xs text-amber-800 leading-relaxed">
            I confirm that all information provided is accurate and genuine.
            I agree to ShopX's <span class="font-bold underline">Vendor Terms & Conditions</span>
            and understand that providing false information may result in account suspension.
        </p>
    </label>
</div>

<form action="{{ route('vendor.onboarding.submit') }}" method="POST">
    @csrf
    <div class="flex gap-3">
        <a href="{{ route('vendor.onboarding.step', 4) }}"
           class="flex-1 border-2 border-gray-200 text-gray-600 py-3.5 rounded-xl font-bold text-sm
                  hover:border-gray-300 transition text-center">
            ← Back
        </a>
        <button type="submit" id="submit-btn" disabled
                onclick="document.getElementById('agree').checked ? this.disabled=false : event.preventDefault()"
                class="flex-1 bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm
                       hover:bg-indigo-700 transition flex items-center justify-center gap-2
                       disabled:opacity-50 disabled:cursor-not-allowed">
            🚀 Submit for Approval
        </button>
    </div>
</form>

<script>
    // Enable button when checkbox is checked
    document.getElementById('agree').addEventListener('change', function() {
        document.getElementById('submit-btn').disabled = !this.checked;
    });
</script>