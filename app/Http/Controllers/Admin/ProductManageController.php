<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductManageController extends Controller
{
    public function index()
    {
        $products = Product::with(['vendor', 'category', 'primaryImage'])
            ->when(request('status'), fn($q) =>
                $q->where('status', request('status')))
            ->when(request('search'), fn($q) =>
                $q->where('name', 'like', '%' . request('search') . '%'))
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active'
        ]);
        return back()->with('success', 'Product status updated!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted!');
    }
}