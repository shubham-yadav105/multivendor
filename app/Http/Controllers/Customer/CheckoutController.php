<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product.primaryImage', 'product.vendor'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(
            fn($item) => ($item->product->discount_price ?? $item->product->price) * $item->quantity
        );

        // Create Stripe PaymentIntent
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount'      => (int)($total * 100),
            'currency'    => 'inr',
            'description' => 'Order payment for ShopX',
            'metadata'    => ['user_id' => auth()->id()],
            'shipping'    => [                        // ← NEW
                'name'    => auth()->user()->name,
                'address' => [
                    'line1'       => 'Not provided',
                    'city'        => 'Not provided',
                    'postal_code' => '000000',
                    'country'     => 'IN',
                ],
            ],
        ]);

        return view('customer.checkout', [
            'cartItems'     => $cartItems,
            'total'         => $total,
            'clientSecret'  => $paymentIntent->client_secret,
            'stripeKey'     => config('services.stripe.key'),
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required',
            'name'              => 'required|string',
            'email'             => 'required|email',
            'address'           => 'required|string',
            'city'              => 'required|string',
            'zip'               => 'required|string',
        ]);

        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart');
        }

        $total = $cartItems->sum(
            fn($item) => ($item->product->discount_price ?? $item->product->price) * $item->quantity
        );

        // Verify payment with Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

        if ($paymentIntent->status !== 'succeeded') {
            return back()->with('error', 'Payment failed. Please try again.');
        }

        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Sorry, insufficient stock for {$item->product->name}.");
            }
        }

        // Create Order
        $order = Order::create([
            'customer_id'        => auth()->id(),
            'order_number'       => 'ORD-' . strtoupper(uniqid()),
            'total_amount'       => $total,
            'payment_status'     => 'paid',
            'stripe_payment_id'  => $request->payment_intent_id,
            'status'             => 'pending',
            'shipping_address'   => json_encode([
                'name'    => $request->name,
                'email'   => $request->email,
                'address' => $request->address,
                'city'    => $request->city,
                'zip'     => $request->zip,
            ]),
        ]);

        // Create Order Items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'vendor_id'  => $item->product->vendor_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->discount_price ?? $item->product->price,
                'status'     => 'pending',
            ]);
            $item->product->decrement('stock', $item->quantity);
        }

        // Clear Cart
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('customer.order.success', $order->order_number);
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('customer_id', auth()->id())
            ->with('orderItems.product.primaryImage')
            ->firstOrFail();

        return view('customer.order-success', compact('order'));
    }
}
