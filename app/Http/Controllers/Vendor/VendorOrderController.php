<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class VendorOrderController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::where('vendor_id', auth()->id())
            ->with(['order.customer', 'product.primaryImage'])
            ->when(request('status'), fn($q) =>
                $q->where('status', request('status')))
            ->when(request('search'), fn($q) =>
                $q->whereHas('order', fn($q2) =>
                    $q2->where('order_number', 'like', '%' . request('search') . '%')))
            ->latest()
            ->paginate(10);

        return view('vendor.orders.index', compact('orderItems'));
    }

    public function updateStatus(Request $request, OrderItem $orderItem)
    {
        // Make sure vendor owns this order item
        if ($orderItem->vendor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered'
        ]);

        $orderItem->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated!');
    }
}