<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProductViewController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
});
Route::middleware('auth')->group(function () {
    Route::get('/my-licenses', [App\Http\Controllers\LicenseController::class, 'index'])->name('licenses.index');
    Route::post('/licenses/{license}/start', [App\Http\Controllers\LicenseController::class, 'start'])->name('licenses.start');
    Route::post('/licenses/{license}/stop', [App\Http\Controllers\LicenseController::class, 'stop'])->name('licenses.stop');
});
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductViewController::class, 'index'])->name('products.index');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports');
});
Route::post('/licenses/purchase', [App\Http\Controllers\LicenseController::class, 'purchase'])->name('licenses.purchase');

