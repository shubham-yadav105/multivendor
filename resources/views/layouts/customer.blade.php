<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopX — @yield('title', 'Shop')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="{{ route('customer.dashboard') }}" 
                   class="text-2xl font-black text-indigo-600 tracking-tight">
                    Shop<span class="text-gray-900">X</span>
                </a>

                <!-- Search Bar -->
                <form action="{{ route('customer.shop') }}" method="GET" 
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
                <div class="flex items-center gap-4">
                    
                    <a href="{{ route('shop') }}"
                        class="hidden md:block text-sm font-medium transition
                                {{ request()->routeIs('shop') ? 'text-indigo-600 font-bold' : 'text-gray-600 hover:text-indigo-600' }}">
                            Shop
                    </a>
                    <!-- Cart Icon -->
                    <a href="{{ route('customer.cart') }}" class="relative group">
                        <div class="p-2 rounded-xl hover:bg-indigo-50 transition">
                            <svg class="w-6 h-6 text-gray-600 group-hover:text-indigo-600 transition" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        @php
                            $cartCount = auth()->check() 
                                ? \App\Models\Cart::where('user_id', auth()->id())->sum('quantity') 
                                : 0;
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs 
                                     font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </a>

                    <!-- User Dropdown -->
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
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('customer.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Orders</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
            </svg>
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
        <div class="max-w-7xl mx-auto px-4 py-8 text-center text-sm text-gray-400">
            © 2025 ShopX. All rights reserved.
        </div>
    </footer>   

    <script src="//unpkg.com/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> --}}
</body>
</html>