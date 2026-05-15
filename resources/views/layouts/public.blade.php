<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopX — @yield('title', 'Discover Amazing Products')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="{{ route('home') }}"
                   class="text-2xl font-black text-indigo-600 tracking-tight">
                    Shop<span class="text-gray-900">X</span>
                </a>

                <!-- Search -->
                <form action="{{ route('shop') }}" method="GET"
                      class="hidden md:flex flex-1 max-w-lg mx-8">
                    <div class="relative w-full">
                        <input type="text" name="search"
                               value="{{ request('search') }}"
                               placeholder="Search products..."
                               class="w-full pl-4 pr-12 py-2.5 rounded-xl border border-gray-200
                                      bg-gray-50 text-sm focus:outline-none focus:ring-2
                                      focus:ring-indigo-500 focus:border-transparent transition">
                        <button type="submit"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Right Side -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('shop') }}"
                       class="hidden md:block text-sm font-medium text-gray-600 hover:text-indigo-600 transition">
                        Shop
                    </a>

                    @auth
                        <!-- Cart -->
                        <a href="{{ route('customer.cart') }}" class="relative group">
                            <div class="p-2 rounded-xl hover:bg-indigo-50 transition">
                                <svg class="w-6 h-6 text-gray-600 group-hover:text-indigo-600 transition"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                            @endphp
                            @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs
                                         font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                            @endif
                        </a>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-gray-100 transition">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                                @if(auth()->user()->isCustomer())
                                <a href="{{ route('customer.dashboard') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    My Dashboard
                                </a>
                                <a href="{{ route('customer.cart') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    My Cart
                                </a>
                                @elseif(auth()->user()->isVendor())
                                <a href="{{ route('vendor.dashboard') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Vendor Panel
                                </a>
                                @elseif(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Admin Panel
                                </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                    @else
                        <!-- Guest Buttons -->
                        <a href="{{ route('login') }}"
                           class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition px-3 py-2">
                            Log in
                        </a>
                        <a href="{{ route('register') }}"
                           class="text-sm font-bold bg-indigo-600 text-white px-4 py-2 rounded-xl
                                  hover:bg-indigo-700 transition">
                            Sign up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-2 md:col-span-1">
                    <h2 class="text-xl font-black text-indigo-600 mb-2">
                        Shop<span class="text-gray-900">X</span>
                    </h2>
                    <p class="text-sm text-gray-400">
                        Discover amazing products from verified vendors worldwide.
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-3">Shop</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('shop') }}" class="hover:text-indigo-600">All Products</a></li>
                        <li><a href="{{ route('shop', ['category' => 1]) }}" class="hover:text-indigo-600">Electronics</a></li>
                        <li><a href="{{ route('shop', ['category' => 2]) }}" class="hover:text-indigo-600">Fashion</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-3">Account</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        @auth
                        <li><a href="{{ route('customer.dashboard') }}" class="hover:text-indigo-600">Dashboard</a></li>
                        @else
                        <li><a href="{{ route('login') }}" class="hover:text-indigo-600">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-indigo-600">Register</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-3">Sell</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('register') }}" class="hover:text-indigo-600">Become a Vendor</a></li>
                        <li><a href="{{ route('vendor.dashboard') }}" class="hover:text-indigo-600">Vendor Panel</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-6 text-center text-xs text-gray-400">
                © {{ date('Y') }} ShopX. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>