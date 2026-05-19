<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Show review form
    public function create(OrderItem $orderItem)
    {
        // Must own this order item
        if ($orderItem->order->customer_id !== auth()->id()) {
            abort(403);
        }

        // Already reviewed
        if ($orderItem->review) {
            return back()->with('error', 'You already reviewed this product!');
        }

        // Must be delivered
        if ($orderItem->status !== 'delivered') {
            return back()->with('error', 'You can only review delivered products!');
        }

        return view('customer.review.create', compact('orderItem'));
    }

    // Store review
    public function store(Request $request, OrderItem $orderItem)
    {
        if ($orderItem->order->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($orderItem->review) {
            return back()->with('error', 'Already reviewed!');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'title'   => 'nullable|string|max:100',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'product_id'   => $orderItem->product_id,
            'user_id'      => auth()->id(),
            'order_item_id'=> $orderItem->id,
            'rating'       => $request->rating,
            'title'        => $request->title,
            'comment'      => $request->comment,
            'is_approved'  => true,
        ]);

        return redirect()->route('customer.orders')
                         ->with('success', 'Review submitted! Thank you 🎉');
    }
}