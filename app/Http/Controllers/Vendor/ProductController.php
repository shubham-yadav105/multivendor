<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // List vendor's products
    public function index()
    {
        $products = Product::where('vendor_id', auth()->id())->with(['category', 'primaryImage'])->latest()->paginate(10);
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
            'images'         => 'required|array|min:1|max:8',
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
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('vendor.products.index')->with('success', 'Product created successfully!');
    }

    // Show edit form
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        $categories = Category::whereNull('parent_id')->with('children')->get();

        // Load images ordered by sort_order so drag-reorder is reflected
        $product->load(['images' => function ($query) {
            $query->orderBy('sort_order')->orderBy('id');
        }]);

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $currentCount = $product->images()->count();
        $newCount = $request->hasFile('images') ? count($request->file('images')) : 0;

        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'price'          => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Enforce max 8 images total (existing + new)
        if (($currentCount + $newCount) > 8) {
            return back()->withErrors([
                'images' => 'A product can have a maximum of 8 images. You currently have ' . $currentCount . '.',
            ])->withInput();
        }

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
            $maxSortOrder = $product->images()->max('sort_order') ?? -1;
            $hasPrimary = $product->images()->where('is_primary', true)->exists();

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    // If product had no primary image yet, make the first new upload primary
                    'is_primary' => !$hasPrimary && $index === 0,
                    'sort_order' => $maxSortOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('vendor.products.index')->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);
        $product->delete();
        return redirect()->route('vendor.products.index')->with('success', 'Product deleted!');
    }

    // Delete a single product image (AJAX)
    public function deleteImage(Product $product, ProductImage $image)
    {
        $this->authorizeProduct($product);

        if ($image->product_id !== $product->id) {
            abort(403);
        }

        // Don't allow deleting the last remaining image
        if ($product->images()->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'A product must have at least one image.',
            ], 422);
        }

        $wasPrimary = $image->is_primary;

        if ($image->image_path !== 'placeholder.jpg') {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        // Promote another image to primary if the deleted one was primary
        if ($wasPrimary) {
            $next = $product->images()->orderBy('sort_order')->orderBy('id')->first();
            if ($next) {
                $next->update(['is_primary' => true]);
            }
        }

        return response()->json(['success' => true]);
    }

    // Set an image as the primary/main image (AJAX)
    public function setPrimaryImage(Product $product, ProductImage $image)
    {
        $this->authorizeProduct($product);

        if ($image->product_id !== $product->id) {
            abort(403);
        }

        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return response()->json(['success' => true]);
    }

    // Save new drag-and-drop order of images (AJAX)
    public function reorderImages(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:product_images,id',
        ]);

        foreach ($request->order as $index => $imageId) {
            ProductImage::where('id', $imageId)
                ->where('product_id', $product->id)
                ->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    // Make sure vendor owns this product
    private function authorizeProduct(Product $product)
    {
        if ($product->vendor_id !== auth()->id()) {
            abort(403);
        }
    }
}