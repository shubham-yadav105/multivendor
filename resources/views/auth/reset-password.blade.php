<x-auth-layout title="Set New Password">

    <x-slot name="panel">
        <h2 class="text-4xl font-black text-white leading-tight mb-6">
            Almost there,<br>
            <span class="text-indigo-300">set a strong password</span>
        </h2>
        <div class="bg-white/10 rounded-2xl p-5 space-y-3">
            @foreach(['At least 8 characters','Mix of letters and numbers','Avoid common passwords'] as $tip)
            <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-indigo-400/30 flex items-center justify-center shrink-0">
                    <svg class="w-3 h-3 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-indigo-100 text-sm">{{ $tip }}</p>
            </div>
            @endforeach
        </div>
    </x-slot>

    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
    </div>
    <div class="mb-8">
        <h1 class="text-2xl font-black text-gray-900 mb-1">Set new password</h1>
        <p class="text-gray-400 text-sm">Choose a strong password for your account.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                   class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-300">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">New Password</label>
            <input type="password" name="password" placeholder="Min. 8 characters" required
                   class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-300">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Confirm Password</label>
            <input type="password" name="password_confirmation" placeholder="Re-enter password" required
                   class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-300">
            @error('password_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-indigo-700 active:scale-[0.99] transition-all flex items-center justify-center gap-2">
            Reset Password
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </button>
    </form>

</x-auth-layout>