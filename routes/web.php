<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Provider\ProviderServiceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Provider\OrderController as ProviderOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminTeamMemberController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'pages.about')->name('about');

Route::get('/seed/{token}', function (string $token) {
    abort_unless(app()->environment('production'), 404);
    abort_unless($token === env('SEED_TOKEN'), 403);

    Artisan::call('db:seed', ['--force' => true]);

    return response()->json([
        'message' => 'Database seeded.',
        'output' => Artisan::output(),
    ]);
});

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/category/{category:slug}', [ServiceController::class, 'category'])->name('services.category');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/user-home', [HomeController::class, 'userHome'])->name('user.home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'provider' => redirect()->route('provider.services.index'),
            default => redirect()->route('user.home'),
        };
    })->name('dashboard');

    Route::get('/services/{service:slug}/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/services/{service:slug}/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/orders/{order}/payments/paymongo', [PaymentController::class, 'start'])->name('payments.start');
    Route::get('/payments/success', [PaymentController::class, 'success'])->name('payments.success');
    Route::get('/payments/failed', [PaymentController::class, 'failed'])->name('payments.failed');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{service:slug}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{service:slug}/quantity', [CartController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::delete('/cart/{service:slug}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::prefix('provider')->name('provider.')->group(function () {
        Route::get('/services', [ProviderServiceController::class, 'index'])->name('services.index');
        Route::get('/services/create', [ProviderServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [ProviderServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}/edit', [ProviderServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ProviderServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ProviderServiceController::class, 'destroy'])->name('services.destroy');

        Route::get('/orders', [ProviderOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [ProviderOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [ProviderOrderController::class, 'updateStatus'])->name('orders.update-status');
    });

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');

    Route::get('/services', [AdminServiceController::class, 'index'])->name('services.index');
    Route::patch('/services/{service}/toggle', [AdminServiceController::class, 'toggle'])->name('services.toggle');
    Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/team-members', [AdminTeamMemberController::class, 'index'])->name('team-members.index');
    Route::get('/team-members/create', [AdminTeamMemberController::class, 'create'])->name('team-members.create');
    Route::post('/team-members', [AdminTeamMemberController::class, 'store'])->name('team-members.store');
    Route::get('/team-members/{user}/edit', [AdminTeamMemberController::class, 'edit'])->name('team-members.edit');
    Route::put('/team-members/{user}', [AdminTeamMemberController::class, 'update'])->name('team-members.update');
    Route::delete('/team-members/{user}', [AdminTeamMemberController::class, 'destroy'])->name('team-members.destroy');

    Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
});
});

Route::post('/webhooks/paymongo', [PaymentController::class, 'webhook'])->name('webhooks.paymongo');

require __DIR__.'/auth.php';
