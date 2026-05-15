<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product.primaryImage', 'product.vendor'])
            ->get();

        //  $total = $cartItems->sum(
        //         fn($item) => $item->product->discount_price ?? $item->product->price * $item->quantity
        //  );

        $total = $cartItems->sum(
            fn($item) => ($item->product->discount_price ?? $item->product->price) * $item->quantity
        );

        return view('customer.cart', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
                'quantity'   => 1,
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        $cart->update(['quantity' => max(1, $request->quantity)]);
        return back()->with('success', 'Cart updated!');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Item removed!');
    }
}
