<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $featuredProducts = Product::where('status', 'active')
            ->with(['primaryImage', 'category', 'vendor'])
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::whereNull('parent_id')->take(6)->get();

        return view('customer.dashboard', compact('featuredProducts', 'categories'));
    }

    public function shop()
    {
        $products = Product::where('status', 'active')
            ->with(['primaryImage', 'category', 'vendor'])
            ->when(request('search'), fn($q) => 
                $q->where('name', 'like', '%' . request('search') . '%'))
            ->when(request('category'), fn($q) => 
                $q->where('category_id', request('category')))
            ->when(request('min_price'), fn($q) => 
                $q->where('price', '>=', request('min_price')))
            ->when(request('max_price'), fn($q) => 
                $q->where('price', '<=', request('max_price')))
            ->latest()
            ->paginate(12);

        $categories = Category::whereNull('parent_id')->get();

        return view('customer.shop', compact('products', 'categories'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['images', 'category', 'vendor.vendorProfile'])
            ->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('primaryImage')
            ->take(4)
            ->get();

        return view('customer.product', compact('product', 'related'));
    }
}