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
    //admin
    Route::group(['middleware' => 'authAdmin', 'prefix'=> 'admin'], function () {
        Route::get('dashboard', \App\Http\Livewire\Admin\AdminDashboardComponent::class)->name('admin.dashboard');

    });



    //user
    Route::group(['prefix' => 'user'], function () {
        Route::group(['middleware' => 'authUser'], function () {
            Route::get('dashboard', \App\Http\Livewire\User\UserDashboardComponent::class)->name('user.dashboard');
        });

    });
});
require __DIR__.'/auth.php';
