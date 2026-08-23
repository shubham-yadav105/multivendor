<?php

// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\Vendor\ProductController;
// use App\Http\Controllers\Vendor\VendorProfileController;
// use App\Http\Middleware\AdminMiddleware;
// use App\Http\Middleware\CustomerMiddleware;
// use App\Http\Middleware\VendorMiddleware;
// use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;



// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// // Admin Routes
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/dashboard', [AdminMiddleware::class, 'dashboard'])->name('dashboard');
// });



// Route::middleware(['auth', 'vendor'])->prefix('vendor')->name('vendor.')->group(function () {
//     Route::get('/dashboard', [VendorMiddleware::class, 'dashboard'])->name('dashboard');
//     // Profile
//     Route::get('/profile', [VendorProfileController::class, 'edit'])->name('profile.edit');
//     Route::post('/profile', [VendorProfileController::class, 'update'])->name('profile.update');

//     // Products
//     Route::resource('products', ProductController::class);
// });

// Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
//     Route::get('/dashboard', [CustomerMiddleware::class, 'dashboard'])->name('dashboard');
// });

// Route::get('/dashboard', function () {
//     $user = auth()->user();

//     if ($user->isAdmin()) return redirect()->route('admin.dashboard');
//     if ($user->isVendor()) return redirect()->route('vendor.dashboard');
//     return redirect()->route('customer.dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__ . '/auth.php';


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VendorManageController;
use App\Http\Controllers\Admin\OrderManageController;
use App\Http\Controllers\Admin\ProductManageController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorProfileController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Vendor\OnboardingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\OrderController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [HomeController::class, 'product'])->name('product.show');


// Role-based redirect after login
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isVendor()) return redirect()->route('vendor.dashboard');
    return redirect()->route('customer.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    //category
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    // Vendors
    Route::get('/vendors', [VendorManageController::class, 'index'])->name('vendors.index');
    Route::post('/vendors/{user}/approve', [VendorManageController::class, 'approve'])->name('vendors.approve');
    Route::post('/vendors/{user}/reject', [VendorManageController::class, 'reject'])->name('vendors.reject');
    Route::post('/vendors/{user}/block', [VendorManageController::class, 'block'])->name('vendors.block');
    Route::post('/vendors/{user}/unblock', [VendorManageController::class, 'unblock'])->name('vendors.unblock');

    // Orders
    Route::get('/orders', [OrderManageController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderManageController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [OrderManageController::class, 'updateStatus'])->name('orders.status');

    // Products
    Route::get('/products', [ProductManageController::class, 'index'])->name('products.index');
    Route::post('/products/{product}/toggle', [ProductManageController::class, 'toggleStatus'])->name('products.toggle');
    Route::delete('/products/{product}', [ProductManageController::class, 'destroy'])->name('products.destroy');
});

// Vendor Routes
Route::middleware(['auth', 'vendor'])->prefix('vendor')->name('vendor.')->group(function () {

    // Onboarding
    Route::get('/onboarding',                [OnboardingController::class, 'index'])->name('onboarding');
    Route::get('/onboarding/step/{step}',    [OnboardingController::class, 'step'])->name('onboarding.step');
    Route::post('/onboarding/step/1',        [OnboardingController::class, 'saveStep1'])->name('onboarding.save1');
    Route::post('/onboarding/step/2',        [OnboardingController::class, 'saveStep2'])->name('onboarding.save2');
    Route::post('/onboarding/step/3',        [OnboardingController::class, 'saveStep3'])->name('onboarding.save3');
    Route::post('/onboarding/step/4',        [OnboardingController::class, 'saveStep4'])->name('onboarding.save4');
    Route::post('/onboarding/submit',        [OnboardingController::class, 'submit'])->name('onboarding.submit');
    Route::get('/onboarding/submitted',      [OnboardingController::class, 'submitted'])->name('onboarding.submitted');

    // Dashboard
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [VendorProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [VendorProfileController::class, 'update'])->name('profile.update');

    // Products
    Route::resource('products', ProductController::class);

    Route::delete('/products/{product}/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.delete');

    Route::post('/products/{product}/images/{image}/primary', [ProductController::class, 'setPrimaryImage'])->name('products.images.primary');

    Route::post('/products/{product}/images/reorder', [ProductController::class, 'reorderImages'])->name('products.images.reorder');

    // Orders
    Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{orderItem}/status', [VendorOrderController::class, 'updateStatus'])->name('orders.status');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/shop', [CustomerController::class, 'shop'])->name('shop');
    Route::get('/product/{slug}', [CustomerController::class, 'product'])->name('product');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/success/{orderNumber}', [CheckoutController::class, 'success'])->name('order.success');

    // order & review
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/review/{orderItem}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/{orderItem}', [ReviewController::class, 'store'])->name('review.store');
});

require __DIR__ . '/auth.php';
