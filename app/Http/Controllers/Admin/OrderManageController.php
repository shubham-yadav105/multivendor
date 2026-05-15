<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderManageController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'orderItems'])
            ->when(request('status'), fn($q) =>
                $q->where('status', request('status')))
            ->when(request('search'), fn($q) =>
                $q->where('order_number', 'like', '%' . request('search') . '%'))
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'orderItems.product.primaryImage', 'orderItems.product.vendor']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated!');
    }
}