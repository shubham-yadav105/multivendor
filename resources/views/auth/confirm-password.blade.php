<x-auth-layout title="Confirm Password">

    <x-slot name="panel">
        <h2 class="text-4xl font-black text-white leading-tight mb-6">
            Secure area,<br>
            <span class="text-indigo-300">confirm your identity</span>
        </h2>
        <div class="bg-white/10 rounded-2xl p-5">
            <div class="flex items-center gap-3 mb-3">
                <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <p class="text-white text-sm font-bold">Why are we asking this?</p>
            </div>
            <p class="text-indigo-200 text-xs">This area contains sensitive information. We ask for your password once per session to make sure it's really you.</p>
        </div>
    </x-slot>

    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
    </div>
    <div class="mb-8">
        <h1 class="text-2xl font-black text-gray-900 mb-1">Confirm your password</h1>
        <p class="text-gray-400 text-sm">This is a secure area. Please confirm your password to continue.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Password</label>
            <input type="password" name="password" placeholder="Your current password" required
                   class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-300">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-indigo-700 active:scale-[0.99] transition-all flex items-center justify-center gap-2">
            Confirm & Continue
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </button>
    </form>

</x-auth-layout>