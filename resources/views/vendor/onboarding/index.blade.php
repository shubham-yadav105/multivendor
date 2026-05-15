<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Onboarding — ShopX</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased min-h-screen">

<div class="min-h-screen flex">

    <!-- Left Panel -->
    <div class="hidden lg:flex w-80 bg-gradient-to-br from-indigo-900 via-indigo-800 to-violet-900
                flex-col p-8 relative overflow-hidden shrink-0">

        <!-- Pattern -->
        <div class="absolute inset-0 opacity-10"
             style="background-image: radial-gradient(circle, white 1px, transparent 1px);
                    background-size: 25px 25px;"></div>

        <!-- Logo -->
        <div class="relative z-10 mb-12">
            <a href="{{ route('home') }}" class="text-2xl font-black text-white">
                Shop<span class="text-indigo-300">X</span>
            </a>
            <p class="text-indigo-300 text-xs mt-1">Vendor Onboarding</p>
        </div>

        <!-- Steps -->
        <div class="relative z-10 flex-1">
            <h2 class="text-white font-bold text-lg mb-6">Complete your profile</h2>

            @php
            $steps = [
                ['num' => 1, 'label' => 'Shop Information',  'sub' => 'Name, category & description'],
                ['num' => 2, 'label' => 'Contact Details',   'sub' => 'Phone, address & location'],
                ['num' => 3, 'label' => 'Bank Details',      'sub' => 'Account & payment info'],
                ['num' => 4, 'label' => 'Identity Proof',    'sub' => 'KYC verification'],
                ['num' => 5, 'label' => 'Review & Submit',   'sub' => 'Confirm your details'],
            ];
            @endphp

            <div class="space-y-1">
                @foreach($steps as $s)
                @php
                    $done    = $step > $s['num'];
                    $current = $step === $s['num'];
                    $pending = $step < $s['num'];
                @endphp
                <div class="flex items-start gap-4 p-3 rounded-xl transition
                            {{ $current ? 'bg-white/10' : '' }}">

                    <!-- Circle -->
                    <div class="shrink-0 mt-0.5">
                        @if($done)
                        <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        @elseif($current)
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                            <span class="text-indigo-700 font-black text-sm">{{ $s['num'] }}</span>
                        </div>
                        @else
                        <div class="w-8 h-8 rounded-full border-2 border-indigo-600 flex items-center justify-center">
                            <span class="text-indigo-300 font-bold text-sm">{{ $s['num'] }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Label -->
                    <div>
                        <p class="text-sm font-bold
                            {{ $current ? 'text-white' : ($done ? 'text-emerald-300' : 'text-indigo-400') }}">
                            {{ $s['label'] }}
                        </p>
                        <p class="text-xs {{ $current ? 'text-indigo-200' : 'text-indigo-500' }}">
                            {{ $s['sub'] }}
                        </p>
                    </div>
                </div>

                <!-- Connector line -->
                @if(!$loop->last)
                <div class="ml-7 w-0.5 h-3 {{ $done ? 'bg-emerald-500' : 'bg-indigo-700' }}"></div>
                @endif
                @endforeach
            </div>
        </div>

        <!-- Bottom -->
        <div class="relative z-10 mt-8 p-4 bg-white/10 rounded-2xl">
            <p class="text-xs text-indigo-200 font-medium mb-1">🔒 Your data is secure</p>
            <p class="text-xs text-indigo-400">All information is encrypted and used only for verification purposes.</p>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="flex-1 flex flex-col overflow-y-auto">

        <!-- Top Bar -->
        <div class="bg-white border-b border-gray-100 px-8 py-4 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <!-- Mobile Logo -->
                <a href="{{ route('home') }}" class="lg:hidden text-xl font-black text-indigo-600">
                    Shop<span class="text-gray-900">X</span>
                </a>
                <div class="hidden lg:block">
                    <p class="text-sm font-bold text-gray-900">
                        Step {{ $step }} of 5
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ ['', 'Shop Information', 'Contact Details', 'Bank Details', 'Identity Proof', 'Review & Submit'][$step] }}
                    </p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="flex items-center gap-3">
                <div class="w-32 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-600 rounded-full transition-all duration-500"
                         style="width: {{ ($step / 5) * 100 }}%"></div>
                </div>
                <span class="text-xs font-bold text-gray-500">{{ ($step / 5) * 100 }}%</span>
            </div>
        </div>

        <!-- Form Content -->
        <div class="flex-1 flex items-start justify-center px-6 py-10">
            <div class="w-full max-w-xl">

                @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-6">
                    {{ session('error') }}
                </div>
                @endif

                @include('vendor.onboarding.steps.step' . $step)

            </div>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>