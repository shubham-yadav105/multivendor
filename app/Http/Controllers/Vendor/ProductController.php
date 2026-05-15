<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // List vendor's products
    public function index()
    {
        $products = Product::where('vendor_id', auth()->id())
                          ->with(['category', 'primaryImage'])
                          ->latest()
                          ->paginate(10);
        return view('vendor.products.index', compact('products'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('vendor.products.create', compact('categories'));
    }

    // Store new product
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'images'         => 'required|array|min:1',
            'images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::create([
            'vendor_id'      => auth()->id(),
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'slug'           => Str::slug($request->name) . '-' . uniqid(),
            'description'    => $request->description,
            'price'          => $request->price,
            'discount_price' => $request->discount_price,
            'stock'          => $request->stock,
            'status'         => 'active',
        ]);

        // Handle image uploads
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => $index === 0, // first image = primary
            ]);
        }

        return redirect()->route('vendor.products.index')
                         ->with('success', 'Product created successfully!');
    }

    // Show edit form
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('vendor.products.edit', compact('product', 'categories'));
    }
    
    // Update product
    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'price'          => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product->update([
            'name'           => $request->name,
            'category_id'    => $request->category_id,
            'description'    => $request->description,
            'price'          => $request->price,
            'discount_price' => $request->discount_price,
            'stock'          => $request->stock,
            'status'         => $request->status ?? $product->status,
        ]);

        // Add new images if uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('vendor.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);
        $product->delete();
        return redirect()->route('vendor.products.index')
                         ->with('success', 'Product deleted!');
    }

    // Make sure vendor owns this product
    private function authorizeProduct(Product $product)
    {
        if ($product->vendor_id !== auth()->id()) {
            abort(403);
        }
    }
}