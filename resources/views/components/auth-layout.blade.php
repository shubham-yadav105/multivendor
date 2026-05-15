<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — ShopX</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        <!-- Left Panel -->
        <div class="hidden lg:flex bg-gradient-to-br from-indigo-900 via-indigo-800 to-violet-900
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

            <!-- Dynamic Middle Content (passed per page) -->
            <div class="relative z-10">
                {{ $panel }}
            </div>

            <!-- Bottom -->
            <div class="relative z-10 flex items-center gap-2 text-indigo-400 text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                256-bit SSL encrypted · Your data is safe with us
            </div>
        </div>

        <!-- Right Panel -->
        <div class="flex items-center justify-center px-6 py-12 bg-gray-50">
            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <a href="{{ route('home') }}" class="text-3xl font-black text-indigo-600">
                        Shop<span class="text-gray-900">X</span>
                    </a>
                </div>

                <!-- Page content (form) -->
                {{ $slot }}
            </div>
        </div>

    </div>

    <script src="//unpkg.com/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
</body>
</html>