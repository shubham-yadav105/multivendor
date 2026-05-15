<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users'    => User::where('role', 'customer')->count(),
            'total_vendors'  => User::where('role', 'vendor')->count(),
            'total_products' => Product::count(),
            'total_orders'   => Order::count(),
            'total_revenue'  => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        $pendingVendors = User::where('role', 'vendor')
            ->whereHas('vendorProfile', fn($q) => $q->where('status', 'pending'))
            ->with('vendorProfile')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'pendingVendors'));
    }
}