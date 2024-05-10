<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\ShopComponent;

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
Route::get('/shop', ShopComponent::class)->name('shop');
Route::get('/cart', CartComponent::class)->name('cart');
Route::get('/checkout', CheckoutComponent::class)->name('checkout');
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


    });



    //user
    Route::group(['prefix' => 'user'], function () {
        Route::group(['middleware' => 'authUser'], function () {
            Route::get('dashboard', \App\Http\Livewire\User\UserDashboardComponent::class)->name('user.dashboard');
        });

    });
});
require __DIR__.'/auth.php';
