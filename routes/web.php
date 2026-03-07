<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Provider\ProviderServiceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Provider\OrderController as ProviderOrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'pages.about')->name('about');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'provider' => redirect()->route('provider.services.index'),
            default => view('dashboard'),
        };
    })->name('dashboard');
});

Route::middleware(['auth', 'role:provider'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {
        Route::get('/services', [ProviderServiceController::class, 'index'])->name('services.index');
        Route::get('/services/create', [ProviderServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [ProviderServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}/edit', [ProviderServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ProviderServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ProviderServiceController::class, 'destroy'])->name('services.destroy');
    });

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    });



require __DIR__.'/auth.php';