<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted — ShopX</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased min-h-screen flex items-center justify-center px-4">

<div class="max-w-md w-full text-center">

    <!-- Success Animation -->
    <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <h1 class="text-3xl font-black text-gray-900 mb-3">Application Submitted! 🎉</h1>
    <p class="text-gray-500 mb-8 leading-relaxed">
        Your vendor application is now under review. Our team will verify your details and approve your account within <span class="font-bold text-gray-700">24-48 hours</span>.
    </p>

    <!-- Status Timeline -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 text-left mb-6">
        <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">What happens next?</h3>
        <div class="space-y-4">
            @foreach([
                ['✅', 'Application Submitted', 'Your details have been received', true],
                ['⏳', 'Under Review', 'Admin team will verify your information', false],
                ['📧', 'Email Notification', 'You will receive an email once approved', false],
                ['🚀', 'Start Selling', 'Add products and go live!', false],
            ] as [$icon, $label, $sub, $done])
            <div class="flex items-start gap-3">
                <span class="text-lg shrink-0">{{ $icon }}</span>
                <div>
                    <p class="text-sm font-bold {{ $done ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $label }}
                    </p>
                    <p class="text-xs text-gray-400">{{ $sub }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('vendor.dashboard') }}"
           class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-bold text-sm
                  hover:bg-indigo-700 transition">
            Go to Dashboard
        </a>
        <a href="{{ route('home') }}"
           class="flex-1 border-2 border-gray-200 text-gray-600 py-3 rounded-xl font-bold text-sm
                  hover:border-gray-300 transition">
            Browse Shop
        </a>
    </div>

    <p class="text-xs text-gray-400 mt-6">
        Questions? Email us at
        <a href="mailto:support@shopx.com" class="text-indigo-600 font-medium">support@shopx.com</a>
    </p>
</div>

</body>
</html>