<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
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

Route::get('/login', function () {
    return view('Filament.login');
})->name('login');

Route::post('/login',[LoginController::class,'login'])->middleware(['web'])->name('filament.admin.auth.login');

Route::post('/admin/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('filament.admin.auth.logout');

Route::get('/products',[ProductController::class,'index'])->name('products');


