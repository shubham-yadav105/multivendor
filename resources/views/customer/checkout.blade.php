@extends('layouts.customer')
@section('title', 'Checkout')

@section('content')
    <div class="max-w-5xl mx-auto">

        <h1 class="text-2xl font-black text-gray-900 mb-8">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            <!-- Shipping + Payment -->
            <div class="lg:col-span-3 space-y-5">

                <!-- Shipping Info -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h2 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span
                            class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-black">1</span>
                        Shipping Information
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">
                                Full Name
                            </label>
                            <input type="text" id="shipping-name" value="{{ auth()->user()->name }}"
                                placeholder="John Doe"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">
                                Email
                            </label>
                            <input type="email" id="shipping-email" value="{{ auth()->user()->email }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">
                                Street Address
                            </label>
                            <input type="text" id="shipping-address" placeholder="123 Main Street"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">
                                City
                            </label>
                            <input type="text" id="shipping-city" placeholder="New York"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">
                                ZIP Code
                            </label>
                            <input type="text" id="shipping-zip" placeholder="10001"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>
                    </div>
                </div>

                <!-- Payment -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h2 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <span
                            class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-black">2</span>
                        Payment Details
                    </h2>

                    <!-- Stripe Card Element -->
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">
                            Card Information
                        </label>
                        <div id="card-element"
                            class="border border-gray-200 rounded-xl px-4 py-3.5 bg-gray-50
                                focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-transparent transition">
                        </div>
                        <p id="card-errors" class="text-red-500 text-xs mt-2"></p>
                    </div>

                    <!-- Test Card Notice -->
                    <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 flex items-start gap-3">
                        <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" />
                        </svg>
                        <div>
                            <p class="text-xs font-semibold text-amber-700">Test Mode</p>
                            <p class="text-xs text-amber-600">Use card: <span class="font-mono font-bold">4242 4242 4242
                                    4242</span> · Any future date · Any CVC</p>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div id="payment-error"
                    class="hidden bg-red-50 border border-red-200 text-red-700 
                                            px-4 py-3 rounded-xl text-sm">
                </div>

                <!-- Pay Button -->
                <button id="pay-btn" onclick="handlePayment()"
                    class="w-full bg-indigo-600 text-white py-4 rounded-xl font-black text-sm
                           hover:bg-indigo-700 active:scale-[0.99] transition-all flex items-center justify-center gap-2
                           disabled:opacity-60 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Pay ₹{{ number_format($total, 2) }} Securely
                </button>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 p-5 sticky top-24">
                    <h3 class="font-bold text-gray-900 mb-4">Order Summary</h3>

                    <div class="space-y-3 mb-4 max-h-72 overflow-y-auto">
                        @foreach ($cartItems as $item)
                            <div class="flex gap-3">
                                <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-50 shrink-0">
                                    @if ($item->product->primaryImage)
                                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}"
                                            class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-400">Qty: {{ $item->quantity }}</p>
                                </div>
                                <p class="text-sm font-bold text-gray-900 shrink-0">
                                    ₹{{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity, 2) }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-gray-500">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Shipping</span>
                            <span class="text-green-600 font-medium">Free</span>
                        </div>
                        <div class="flex justify-between font-black text-gray-900 text-base pt-2 border-t border-gray-100">
                            <span>Total</span>
                            <span>₹{{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Secure Badge -->
                    <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        256-bit SSL encrypted & secured by Stripe
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden form for submission -->
    <form id="payment-form" action="{{ route('customer.checkout.process') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="payment_intent_id" id="payment-intent-id">
        <input type="hidden" name="name" id="form-name">
        <input type="hidden" name="email" id="form-email">
        <input type="hidden" name="address" id="form-address">
        <input type="hidden" name="city" id="form-city">
        <input type="hidden" name="zip" id="form-zip">
    </form>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();

        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '15px',
                    color: '#1f2937',
                    fontFamily: 'ui-sans-serif, system-ui, sans-serif',
                    '::placeholder': {
                        color: '#9ca3af'
                    },
                }
            }
        });

        cardElement.mount('#card-element');

        cardElement.on('change', ({
            error
        }) => {
            document.getElementById('card-errors').textContent = error ? error.message : '';
        });

        async function handlePayment() {
            const btn = document.getElementById('pay-btn');
            const errorDiv = document.getElementById('payment-error');

            // Validate fields
            const name = document.getElementById('shipping-name').value.trim();
            const email = document.getElementById('shipping-email').value.trim();
            const address = document.getElementById('shipping-address').value.trim();
            const city = document.getElementById('shipping-city').value.trim();
            const zip = document.getElementById('shipping-zip').value.trim();

            if (!name || !email || !address || !city || !zip) {
                errorDiv.textContent = 'Please fill in all shipping fields.';
                errorDiv.classList.remove('hidden');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = `<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg> Processing...`;

            errorDiv.classList.add('hidden');

            const {
                paymentIntent,
                error
            } = await stripe.confirmCardPayment(
                '{{ $clientSecret }}', {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name,
                            email
                        }
                    }
                }
            );

            if (error) {
                errorDiv.textContent = error.message;
                errorDiv.classList.remove('hidden');
                btn.disabled = false;
                btn.innerHTML = `Pay ₹{{ number_format($total, 2) }} Securely`;
                return;
            }

            // Fill and submit hidden form
            document.getElementById('payment-intent-id').value = paymentIntent.id;
            document.getElementById('form-name').value = name;
            document.getElementById('form-email').value = email;
            document.getElementById('form-address').value = address;
            document.getElementById('form-city').value = city;
            document.getElementById('form-zip').value = zip;
            document.getElementById('payment-form').submit();
        }
    </script>
@endsection
