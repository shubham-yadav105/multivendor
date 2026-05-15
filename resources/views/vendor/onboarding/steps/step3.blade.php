<div class="mb-8">
    <h1 class="text-2xl font-black text-gray-900 mb-1">Bank & Payment Details</h1>
    <p class="text-gray-400 text-sm">Your earnings will be transferred to this account.</p>
</div>

<!-- Security Note -->
<div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 mb-6 flex items-start gap-3">
    <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"/>
    </svg>
    <p class="text-xs text-blue-700">
        Your bank details are encrypted with 256-bit SSL and stored securely. We never share your financial information.
    </p>
</div>

<form action="{{ route('vendor.onboarding.save3') }}" method="POST" class="space-y-5">
    @csrf

    <!-- Account Holder Name -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Account Holder Name <span class="text-red-400">*</span>
        </label>
        <input type="text" name="bank_account_name"
               value="{{ old('bank_account_name', $profile?->bank_account_name) }}"
               placeholder="As printed on your passbook"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        @error('bank_account_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Bank Name -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Bank Name <span class="text-red-400">*</span>
        </label>
        <select name="bank_name"
                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            <option value="">Select your bank</option>
            @foreach(['State Bank of India','HDFC Bank','ICICI Bank','Axis Bank','Kotak Mahindra Bank','Punjab National Bank','Bank of Baroda','Canara Bank','IndusInd Bank','Yes Bank','IDFC First Bank','Federal Bank','Union Bank of India','Bank of India','UCO Bank'] as $bank)
            <option value="{{ $bank }}"
                {{ old('bank_name', $profile?->bank_name) === $bank ? 'selected' : '' }}>
                {{ $bank }}
            </option>
            @endforeach
        </select>
        @error('bank_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Account Number -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            Account Number <span class="text-red-400">*</span>
        </label>
        <input type="text" name="bank_account_number"
               value="{{ old('bank_account_number', $profile?->bank_account_number) }}"
               placeholder="Enter your account number"
               maxlength="18"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        @error('bank_account_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- IFSC Code -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            IFSC Code <span class="text-red-400">*</span>
        </label>
        <input type="text" name="bank_ifsc"
               value="{{ old('bank_ifsc', $profile?->bank_ifsc) }}"
               placeholder="e.g. SBIN0001234"
               maxlength="11"
               style="text-transform: uppercase"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono uppercase
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        <p class="text-xs text-gray-400 mt-1">11-character code found on your cheque book</p>
        @error('bank_ifsc') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- GST Number (Optional) -->
    <div>
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
            GST Number
            <span class="text-gray-400 font-normal normal-case ml-1">(Optional)</span>
        </label>
        <input type="text" name="gst_number"
               value="{{ old('gst_number', $profile?->gst_number) }}"
               placeholder="22AAAAA0000A1Z5"
               maxlength="15"
               style="text-transform: uppercase"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono uppercase
                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        <p class="text-xs text-gray-400 mt-1">Required if annual turnover exceeds ₹20 lakhs</p>
        @error('gst_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex gap-3 pt-2">
        <a href="{{ route('vendor.onboarding.step', 2) }}"
           class="flex-1 border-2 border-gray-200 text-gray-600 py-3.5 rounded-xl font-bold text-sm
                  hover:border-gray-300 transition text-center">
            ← Back
        </a>
        <button type="submit"
                class="flex-1 bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm
                       hover:bg-indigo-700 transition flex items-center justify-center gap-2">
            Continue to Identity →
        </button>
    </div>
</form>