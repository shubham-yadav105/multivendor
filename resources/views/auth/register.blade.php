<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — ShopX</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        <!-- Left Panel -->
        <div
            class="hidden lg:flex bg-gradient-to-br from-indigo-900 via-indigo-800 to-violet-900
                flex-col justify-between p-12 relative overflow-hidden">

            <div class="absolute inset-0 opacity-10"
                style="background-image: radial-gradient(circle, white 1px, transparent 1px);
                    background-size: 25px 25px;">
            </div>

            <!-- Logo -->
            <div class="relative z-10">
                <a href="{{ route('home') }}" class="text-3xl font-black text-white">
                    Shop<span class="text-indigo-300">X</span>
                </a>
            </div>

            <!-- Middle Content -->
            <div class="relative z-10">
                <h2 class="text-4xl font-black text-white leading-tight mb-6">
                    Join thousands of<br>
                    <span class="text-indigo-300">buyers & sellers</span><br>
                    on ShopX
                </h2>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 mb-8">
                    @foreach ([['10K+', 'Products'], ['500+', 'Vendors'], ['50K+', 'Customers']] as [$num, $label])
                        <div class="bg-white/10 rounded-2xl p-4 text-center">
                            <p class="text-2xl font-black text-white">{{ $num }}</p>
                            <p class="text-xs text-indigo-300">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Testimonial -->
                <div class="bg-white/10 rounded-2xl p-5">
                    <p class="text-indigo-100 text-sm italic mb-3">
                        "ShopX helped me grow my business from 0 to ₹2L monthly in just 3 months!"
                    </p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-indigo-400 flex items-center justify-center text-white font-bold text-sm">
                            R</div>
                        <div>
                            <p class="text-white text-xs font-bold">Rahul Sharma</p>
                            <p class="text-indigo-300 text-xs">Electronics Vendor, Mumbai</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom -->
            <div class="relative z-10 flex items-center gap-2 text-indigo-400 text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                256-bit SSL encrypted · Your data is safe with us
            </div>
        </div>

        <!-- Right Panel -->
        <div class="flex items-center justify-center px-6 py-12 bg-gray-50" x-data="{ role: 'customer' }">

            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <a href="{{ route('home') }}" class="text-3xl font-black text-indigo-600">
                        Shop<span class="text-gray-900">X</span>
                    </a>
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-black text-gray-900 mb-1">Create your account</h1>
                    <p class="text-gray-400 text-sm">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">
                            Sign in
                        </a>
                    </p>
                </div>

                <!-- Role Selector -->
                <div class="mb-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                        I want to
                    </p>
                    <div class="grid grid-cols-2 gap-3">

                        <!-- Customer -->
                        <label class="cursor-pointer">
                            <input type="radio" name="role_display" value="customer" class="hidden peer" checked
                                x-on:change="role = 'customer'">
                            <div
                                class="peer-checked:border-indigo-600 peer-checked:bg-indigo-50
                                    border-2 border-gray-200 bg-white rounded-2xl p-4
                                    hover:border-indigo-300 transition-all group">
                                <div
                                    class="w-10 h-10 rounded-xl bg-indigo-50 group-[.peer-checked+&]:bg-indigo-100
                                        flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <p class="font-bold text-gray-900 text-sm">Shop</p>
                                <p class="text-xs text-gray-400 mt-0.5">Buy amazing products</p>
                            </div>
                        </label>

                        <!-- Vendor -->
                        <label class="cursor-pointer">
                            <input type="radio" name="role_display" value="vendor" class="hidden peer"
                                x-on:change="role = 'vendor'">
                            <div
                                class="peer-checked:border-indigo-600 peer-checked:bg-indigo-50
                                    border-2 border-gray-200 bg-white rounded-2xl p-4
                                    hover:border-indigo-300 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <p class="font-bold text-gray-900 text-sm">Sell</p>
                                <p class="text-xs text-gray-400 mt-0.5">Start your own store</p>
                            </div>
                        </label>
                    </div>

                    <!-- Vendor Info Banner -->
                    <div x-show="role === 'vendor'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="mt-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 flex items-start gap-2">
                        <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
                        </svg>
                        <p class="text-xs text-amber-700">
                            You'll complete a <strong>5-step onboarding</strong> after registration to set up your shop
                            and get approved.
                        </p>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Hidden role field -->
                    <input type="hidden" name="role" :value="role">

                    <!-- Name -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Full Name
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
                            required autofocus
                            class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                  transition placeholder-gray-300">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Email Address
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="john@example.com" required
                            class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                  transition placeholder-gray-300">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Password
                        </label>
                        <input type="password" name="password" placeholder="Min. 8 characters" required
                            class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                  transition placeholder-gray-300">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Confirm Password
                        </label>
                        <input type="password" name="password_confirmation" placeholder="Re-enter password" required
                            class="w-full border border-gray-200 bg-white rounded-xl px-4 py-3 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                  transition placeholder-gray-300">
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-sm
                               hover:bg-indigo-700 active:scale-[0.99] transition-all mt-2
                               flex items-center justify-center gap-2">
                        <span x-text="role === 'vendor' ? 'Create Vendor Account' : 'Create Account'"></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>

                    <!-- Terms -->
                    <p class="text-xs text-gray-400 text-center">
                        By creating an account you agree to our
                        <a href="#" class="text-indigo-600 hover:underline">Terms of Service</a>
                        and
                        <a href="#" class="text-indigo-600 hover:underline">Privacy Policy</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>
