<x-auth-layout title="Verify Email">

    <x-slot name="panel">
        <h2 class="text-4xl font-black text-white leading-tight mb-6">
            One last step,<br>
            <span class="text-indigo-300">verify your email</span>
        </h2>
        <div class="bg-white/10 rounded-2xl p-5">
            <p class="text-indigo-100 text-sm italic mb-3">"Verifying your email keeps your account safe and ensures you never miss an order update."</p>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-400 flex items-center justify-center text-white font-bold text-sm">S</div>
                <div>
                    <p class="text-white text-xs font-bold">ShopX Security Team</p>
                    <p class="text-indigo-300 text-xs">Keeping your account safe</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </div>
    <div class="mb-8">
        <h1 class="text-2xl font-black text-gray-900 mb-1">Check your inbox</h1>
        <p class="text-gray-400 text-sm">We sent a verification link to your email. Click it to activate your account.</p>
    </div>

    @if(session('status') == 'verification-link-sent')
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-indigo-700 active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                Resend Verification Email
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full border-2 border-gray-200 text-gray-500 py-3.5 rounded-xl font-semibold text-sm hover:border-red-300 hover:text-red-500 transition-all">
                Log Out
            </button>
        </form>
    </div>

</x-auth-layout>