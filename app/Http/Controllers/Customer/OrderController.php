<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', auth()->id())
            ->with(['orderItems.product.primaryImage', 'orderItems.review'])
            ->latest()
            ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        $order->load([
            'orderItems.product.primaryImage',
            'orderItems.review'
        ]);

        return view('customer.order-detail', compact('order'));
    }
}