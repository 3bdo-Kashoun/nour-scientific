<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

Route::get('/', function () {
    return view('home');
});
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/news', [EventsController::class, 'index'])->name('news.index');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/events', [PageController::class, 'events'])->name('events');

Route::post('/register',[RegisterController::class,'register'])->name('register');

Route::get('/register', function () {
    return view('Filament.register');
})->name('register.view');

Route::post('/register/check-email', [RegisterController::class, 'checkEmail'])->name('register.check-email');

Route::get('/login', function () {
    return view('Filament.login');
})->name('login');

Route::post('/login',[LoginController::class,'login'])->middleware(['web'])->name('filament.admin.auth.login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('/products',[ProductController::class,'index'])->name('products');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // مسارات الملف الشخصي والطلبات السابقة
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'updateInfo'])->name('profile.update-info');
    Route::post('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::get('/profile/orders/{order}', [\App\Http\Controllers\ProfileController::class, 'orderDetails'])->name('profile.order-details');
});


