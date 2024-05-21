<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\DetailsComponent;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', HomeComponent::class)->name('home.index');
Route::get('/shop/{seller_id}', ShopComponent::class)->name('shop');
Route::get('/cart', CartComponent::class)->name('shop.cart');
Route::get('/product/{slug}', DetailsComponent::class)->name('product.details');
Route::get('/products{category_id}', DetailsComponent::class)->name('product.detailss');
Route::get('/product-category/{slug}', App\Http\Livewire\CategoryComponent::class)->name('product.category');
Route::get('/handle-vnpay-return', [App\Http\Controllers\CheckoutController::class, 'handleVNPayReturn'])->name('vnpay.return');
Route::get('/search', App\Http\Livewire\SearchComponent::class)->name('product.search');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
Route::group(['middleware' => ['userLogin']], function () {
    //admins
    Route::group(['middleware' => 'authAdmin', 'prefix'=> 'admin'], function () {
        Route::get('dashboard', \App\Http\Livewire\Admin\AdminDashboardComponent::class)->name('admin.dashboard');
        Route::get('categories', \App\Http\Livewire\Admin\AdminCategoriesComponent::class)->name('admin.categories');
        Route::get('category/add', \App\Http\Livewire\Admin\AdminCategoryAddComponent::class)->name('admin.category.add');
        Route::get('category/edit/{category_id}', \App\Http\Livewire\Admin\AdminCategoryEditComponent::class)->name('admin.category.edit');
        Route::get('brands', \App\Http\Livewire\Admin\AdminBrandsComponent::class)->name('admin.brands');
        Route::get('brand/add', \App\Http\Livewire\Admin\AdminBrandAddComponent::class)->name('admin.brand.add');
        Route::get('brand/edit/{brand_id}', \App\Http\Livewire\Admin\AdminBrandEditComponent::class)->name('admin.brand.edit');
        Route::get('products', \App\Http\Livewire\Admin\AdminProductComponent::class)->name('admin.products');
        Route::get('product/add', \App\Http\Livewire\Admin\AdminProductAddComponent::class)->name('admin.product.add');
        Route::get('product/edit/{product_id}', \App\Http\Livewire\Admin\AdminProductEditComponent::class)->name('admin.product.edit');
        Route::get('orders', \App\Http\Livewire\Admin\AdminOrdersComponent::class)->name('admin.orders');
        Route::get('order/edit/{order_id}', \App\Http\Livewire\Admin\AdminOrderEditComponent::class)->name('admin.order.edit');
        Route::get('accounts', \App\Http\Livewire\Admin\AdminAccountsComponent::class)->name('admin.accounts');
        Route::get('accounts/add', \App\Http\Livewire\Admin\AdminAccountAddComponent::class)->name('admin.account.add');
        Route::get('accounts/edit/{account_id}', \App\Http\Livewire\Admin\AdminAccountEditComponent::class)->name('admin.account.edit');
    });



    //user
    Route::group(['prefix' => 'user'], function () {
        Route::group(['middleware' => 'authUser'], function () {
            Route::get('dashboard', \App\Http\Livewire\User\UserDashboardComponent::class)->name('user.dashboard');
        });
        Route::get('orders', App\Http\Livewire\User\UserOrdersComponent::class)->name('user.orders');
        Route::get('order-detail/{order_id}', [App\Http\Controllers\OrderController::class, 'show'])->name('user.order_detail');
        Route::post('order-cancel/{order_id}', [App\Http\Controllers\OrderController::class, 'cancel'])->name('user.order_cancel');
        Route::post('place-order', [App\Http\Controllers\CheckoutController::class, 'payment'])->name('user.payment');
        Route::get('wishlist', App\Http\Livewire\WishlistComponent::class)->name('user.wishlist');
        Route::get('checkout', \App\Http\Livewire\User\UserCheckoutComponent::class)->name('user.checkout');
        Route::get('payment-result', App\Http\Livewire\User\UserPaymentResultComponent::class)->name('user.payment_result');
    });
});
require __DIR__.'/auth.php';
