<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('status', 'active')
            ->with(['primaryImage', 'category', 'vendor'])
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::whereNull('parent_id')
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts', 'categories'));
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

        return view('shop', compact('products', 'categories'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['images', 'category', 'vendor.vendorProfile'])
            ->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->with('primaryImage')
            ->take(4)
            ->get();

        return view('product', compact('product', 'related'));
    }
}