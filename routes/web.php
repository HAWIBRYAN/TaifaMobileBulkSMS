<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SmsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root (/) to SMS Dashboard
Route::get('/', [SmsDashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('sms.dashboard');

//Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Profile Controls
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Bulk SMS routes
Route::middleware(['auth'])->group(function () {
    Route::get('/sms', [SmsController::class, 'index'])->name('sms.index');
    Route::post('/sms/send', [SmsController::class, 'send'])->name('sms.send');
    Route::post('/sms/callback', [SmsController::class, 'callback'])->name('sms.callback');
});

// Breeze auth routes (already added by Breeze)
require __DIR__.'/auth.php';
