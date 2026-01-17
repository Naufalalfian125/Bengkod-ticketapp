<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function (): View {
    return view('welcome');
});

Route::middleware('auth')->group(function (): void {
    // Dashboard route for regular users
    Route::get('/dashboard', function (): View {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Password update route
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

    // Event Routes for users
    Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('event.index');
    Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('event.show');

    // Order Routes
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('order.index');
    Route::post('/events/{event}/order', [\App\Http\Controllers\OrderController::class, 'store'])->name('order.store');

    // Logout route
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware('admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Kategori Routes
        Route::resource('kategori', \App\Http\Controllers\Admin\KategoriController::class);
        
        // Event Routes
        Route::resource('event', \App\Http\Controllers\Admin\EventController::class);
        
        // Tiket Routes (nested under event)
        Route::get('event/{event}/tiket', [\App\Http\Controllers\Admin\TiketController::class, 'index'])->name('tiket.index');
        Route::get('event/{event}/tiket/create', [\App\Http\Controllers\Admin\TiketController::class, 'create'])->name('tiket.create');
        Route::post('event/{event}/tiket', [\App\Http\Controllers\Admin\TiketController::class, 'store'])->name('tiket.store');
        Route::get('event/{event}/tiket/{tiket}/edit', [\App\Http\Controllers\Admin\TiketController::class, 'edit'])->name('tiket.edit');
        Route::put('event/{event}/tiket/{tiket}', [\App\Http\Controllers\Admin\TiketController::class, 'update'])->name('tiket.update');
        Route::delete('event/{event}/tiket/{tiket}', [\App\Http\Controllers\Admin\TiketController::class, 'destroy'])->name('tiket.destroy');
        
        // Order Routes
        Route::get('order', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('order.index');
    });

require __DIR__ . '/auth.php';

