<x-auth-layout title="Reset Password">

    <x-slot name="panel">
        <h2 class="text-4xl font-black text-white leading-tight mb-6">
            No worries,<br>
            <span class="text-indigo-300">it happens to everyone</span>
        </h2>
        <div class="space-y-4">
            @foreach([['1','Enter your email','We\'ll find your account instantly'],['2','Check your inbox','A reset link arrives in seconds'],['3','Set new password','Pick something strong']] as [$s,$t,$d])
            <div class="flex items-center gap-4 bg-white/10 rounded-2xl px-4 py-3">
                <div class="w-8 h-8 rounded-full bg-indigo-400/40 flex items-center justify-center text-white font-black text-sm shrink-0">{{ $s }}</div>
                <div>
                    <p class="text-white text-sm font-bold">{{ $t }}</p>
                    <p class="text-indigo-300 text-xs">{{ $d }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </x-slot>

    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
        </svg>
    </div>
    <div class="mb-8">
        <h1 class="text-2xl font-black text-gray-900 mb-1">Forgot your password?</h1>
        <p class="text-gray-400 text-sm">Enter your email and we'll send a reset link right away.</p>
    </div>

    @if(session('status'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required autofocus
                   class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-300">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-indigo-700 active:scale-[0.99] transition-all flex items-center justify-center gap-2">
            Send Reset Link
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </button>
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-indigo-600 transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Sign In
            </a>
        </div>
    </form>

</x-auth-layout>