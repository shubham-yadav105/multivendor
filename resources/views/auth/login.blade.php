<x-auth-layout title="Sign In">

    <x-slot name="panel">
        <h2 class="text-4xl font-black text-white leading-tight mb-6">
            Welcome back to<br>
            <span class="text-indigo-300">your marketplace</span>
        </h2>
        <div class="grid grid-cols-3 gap-4 mb-8">
            @foreach ([['10K+', 'Products'], ['500+', 'Vendors'], ['50K+', 'Customers']] as [$num, $label])
                <div class="bg-white/10 rounded-2xl p-4 text-center">
                    <p class="text-2xl font-black text-white">{{ $num }}</p>
                    <p class="text-xs text-indigo-300">{{ $label }}</p>
                </div>
            @endforeach
        </div>
        <div class="bg-white/10 rounded-2xl p-5">
            <p class="text-indigo-100 text-sm italic mb-3">"I shop on ShopX every week — deals are unbeatable!"</p>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-400 flex items-center justify-center text-white font-bold text-sm">P</div>
                <div>
                    <p class="text-white text-xs font-bold">Priya Mehta</p>
                    <p class="text-indigo-300 text-xs">Regular Customer, Pune</p>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Right side form --}}
    <div class="mb-8">
        <h1 class="text-2xl font-black text-gray-900 mb-1">Welcome back</h1>
        <p class="text-gray-400 text-sm">Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Sign up free</a>
        </p>
    </div>

    @if(session('status'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required autofocus
                   class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-300">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-indigo-600 font-semibold hover:underline">Forgot password?</a>
                @endif
            </div>
            <input type="password" name="password" placeholder="Your password" required
                   class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition placeholder-gray-300">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
            <label for="remember_me" class="text-sm text-gray-600 cursor-pointer">Remember me for 30 days</label>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-indigo-700 active:scale-[0.99] transition-all flex items-center justify-center gap-2">
            Sign In to ShopX
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </button>
    </form>

</x-auth-layout>