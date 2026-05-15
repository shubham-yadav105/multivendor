<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->vendorProfile;

        // Redirect to onboarding if not complete
        if (!$profile || !$profile->onboarding_complete) {
            return redirect()->route('vendor.onboarding');
        }
        
        $vendorId = auth()->id();

        $stats = [
            'total_products'  => Product::where('vendor_id', $vendorId)->count(),
            'active_products' => Product::where('vendor_id', $vendorId)->where('status', 'active')->count(),
            'total_orders'    => OrderItem::where('vendor_id', $vendorId)->distinct('order_id')->count('order_id'),
            'pending_orders'  => OrderItem::where('vendor_id', $vendorId)->where('status', 'pending')->distinct('order_id')->count('order_id'),
            'total_earnings'  => OrderItem::where('vendor_id', $vendorId)
                ->whereHas('order', fn($q) => $q->where('payment_status', 'paid'))
                ->selectRaw('SUM(price * quantity) as total')
                ->value('total') ?? 0,
            'this_month'      => OrderItem::where('vendor_id', $vendorId)
                ->whereHas('order', fn($q) => $q->where('payment_status', 'paid')
                    ->whereMonth('created_at', now()->month))
                ->selectRaw('SUM(price * quantity) as total')
                ->value('total') ?? 0,
        ];

        $recentOrders = OrderItem::where('vendor_id', $vendorId)
            ->with(['order.customer', 'product.primaryImage'])
            ->latest()
            ->take(6)
            ->get();

        $topProducts = Product::where('vendor_id', $vendorId)
            ->withCount('orderItems as sales_count')
            ->with('primaryImage')
            ->orderByDesc('sales_count')
            ->take(5)
            ->get();

        return view('vendor.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}
