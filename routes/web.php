<?php

use App\Livewire\Admin\AdminAddCategoryComponent;
use App\Livewire\Admin\AdminAddCouponsComponent;
use App\Livewire\Admin\AdminAddHomeSliderComponent;
use App\Livewire\Admin\AdminAddProductComponent;
use App\Livewire\Admin\AdminCategoryComponent;
use App\Livewire\Admin\AdminCouponsComponent;
use App\Livewire\Admin\AdminDashboardComponent;
use App\Livewire\Admin\AdminEditCategoryComponent;
use App\Livewire\Admin\AdminEditCouponsComponent;
use App\Livewire\Admin\AdminEditHomeSliderComponent;
use App\Livewire\Admin\AdminEditProductComponent;
use App\Livewire\Admin\AdminHomeCategoryComponent;
use App\Livewire\Admin\AdminHomeSliderComponent;
use App\Livewire\Admin\AdminProductComponent;
use App\Livewire\Admin\AdminSaleComponent;
use App\Livewire\CartComponent;
use App\Livewire\CategoryComponent;
use App\Livewire\CheckoutComponent;
use App\Livewire\DetailsComponent;
use App\Livewire\HomeComponent;
use App\Livewire\SearchComponent;
use App\Livewire\ShopComponent;
use App\Livewire\ThankYouComponent;
use App\Livewire\User\UserDashboardComponent;
use App\Livewire\WishlistComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeComponent::class)->name('home');
Route::get('/shop', ShopComponent::class)->name('shop');
Route::get('/cart', CartComponent::class)->name('product.cart');
Route::get('/checkout', CheckoutComponent::class)->name('checkout');
Route::get('/product/{slug}', DetailsComponent::class)->name('product.details');
Route::get('/product-category/{category_slug}', CategoryComponent::class)->name('product.category');
Route::get('/search', SearchComponent::class)->name('product.search');
Route::get('/wishlist',WishlistComponent::class)->name('product.wishlist');

Route::get('/thank-you',ThankYouComponent::class)->name('thankyou');

/* Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); */

//User or Customer
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/user/dashboard', UserDashboardComponent::class)->name('user.dashboard');
});

//Admin
Route::middleware(['auth:sanctum', 'verified','authadmin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboardComponent::class)->name('admin.dashboard');
    
    Route::get('/admin/categories',AdminCategoryComponent::class)->name('admin.categories');
    Route::get('/admin/category/add',AdminAddCategoryComponent::class)->name('admin.addcategory');
    Route::get('/admin/category/edit/{category_slug}',AdminEditCategoryComponent::class)->name('admin.editcategory');
    
    Route::get('/admin/products',AdminProductComponent::class)->name('admin.products');
    Route::get('/admin/product/add', AdminAddProductComponent::class)->name('admin.addproduct');
    Route::get('/admin/product/edit/{product_slug}', AdminEditProductComponent::class)->name('admin.editproduct');
    
    Route::get('/admin/slider',AdminHomeSliderComponent::class)->name('admin.homeslider');
    Route::get('/admin/slider/add', AdminAddHomeSliderComponent::class)->name('admin.addhomeslider');
    Route::get('/admin/slider/edit/{slide_id}', AdminEditHomeSliderComponent::class)->name('admin.edithomeslider');

    Route::get('/admin/home-categories', AdminHomeCategoryComponent::class)->name('admin.homecategories');

    Route::get('/admin/sale',AdminSaleComponent::class)->name('admin.sale');

    Route::get('/admin/coupons',AdminCouponsComponent::class)->name('admin.coupons');
    Route::get('/admin/coupons/add', AdminAddCouponsComponent::class)->name('admin.addcoupon');
    Route::get('/admin/coupons/edit/{coupon_id}', AdminEditCouponsComponent::class)->name('admin.editcoupon');
});