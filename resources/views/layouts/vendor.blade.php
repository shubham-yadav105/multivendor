<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor — @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col shrink-0 shadow-sm">

        <!-- Logo -->
        <div class="px-6 py-5 border-b border-gray-100">
            <h1 class="text-xl font-black tracking-tight">
                <span class="text-indigo-600">Shop</span><span class="text-gray-900">X</span>
                <span class="text-xs font-medium text-gray-400 ml-2 bg-gray-100 px-2 py-0.5 rounded-full">Vendor</span>
            </h1>
        </div>

        <!-- Shop Info -->
        @php $profile = auth()->user()->vendorProfile; @endphp
        <div class="px-4 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3 bg-indigo-50 rounded-2xl p-3">
                @if($profile?->shop_logo)
                    <img src="{{ asset('storage/' . $profile->shop_logo) }}"
                         class="w-10 h-10 rounded-xl object-cover shrink-0">
                @else
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-black text-sm shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate">
                        {{ $profile?->shop_name ?? 'Setup Your Shop' }}
                    </p>
                    @if($profile)
                    <span class="text-xs font-semibold px-1.5 py-0.5 rounded-md
                        {{ $profile->status === 'approved' ? 'bg-emerald-100 text-emerald-600' : 
                           ($profile->status === 'pending' ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-500') }}">
                        {{ ucfirst($profile->status) }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest px-3 mb-2">Menu</p>

            @php
            $navItems = [
                ['route' => 'vendor.dashboard',      'label' => 'Dashboard',   'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['route' => 'vendor.products.index', 'label' => 'Products',    'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
                ['route' => 'vendor.orders.index',   'label' => 'Orders',      'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['route' => 'vendor.profile.edit',   'label' => 'Shop Profile', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            ];
            @endphp

            @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                      {{ request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*')
                         ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-200'
                         : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                </svg>
                {{ $item['label'] }}
            </a>
            @endforeach
        </nav>

        <!-- User -->
        <div class="px-3 py-4 border-t border-gray-100">
            <div class="flex items-center gap-3 px-3 py-2 mb-1">
                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-black shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm
                               text-gray-400 hover:bg-red-50 hover:text-red-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Topbar -->
        <header class="bg-white border-b border-gray-100 px-8 py-4 flex items-center justify-between shrink-0">
            <div>
                <h2 class="text-lg font-black text-gray-900">@yield('title', 'Dashboard')</h2>
                <p class="text-xs text-gray-400">@yield('subtitle', 'Manage your shop')</p>
            </div>
            <div class="flex items-center gap-3">
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-xs font-medium
                            px-3 py-1.5 rounded-lg flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif
                <a href="{{ route('vendor.products.create') }}"
                   class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl
                          text-sm font-bold hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Product
                </a>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </main>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>