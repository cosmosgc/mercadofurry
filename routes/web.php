<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomStyleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreStyleController;
use Illuminate\Support\Facades\Auth;

Route::resource('stores', StoreController::class);
Route::resource('products', ProductController::class);
Route::resource('custom-styles', CustomStyleController::class);

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get(
        '/stores/{store}/style',
        [StoreStyleController::class, 'edit']
    )->name('stores.style.edit');

    Route::put(
        '/stores/{store}/style',
        [StoreStyleController::class, 'update']
    )->name('stores.style.update');
});


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/users/last-online', function () {
    $user = Auth::user();

    if (
        $user &&
        (
            !$user->last_online_at ||
            $user->last_online_at->diffInMinutes(now()) >= 2
        )
    ) {
        $user->forceFill([
            'last_online_at' => now(),
        ])->save();
    }

    return response()->noContent();
})->middleware('auth')->name('users.last-online');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
