# Routes Configuration

Add these routes to your `routes/web.php` file:

```php
<?php

use App\Http\Controllers\ShippingDocumentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\MessageController;

Route::middleware(['auth'])->prefix('dashboard')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('dashboard.products');
    Route::get('/products/new', [ProductController::class, 'create'])->name('dashboard.products.new');
    Route::post('/products', [ProductController::class, 'store'])->name('dashboard.products.store');

    // Stock
    Route::get('/stock', [StockController::class, 'index'])->name('dashboard.stock');
    Route::get('/stock/new', [StockController::class, 'create'])->name('dashboard.stock.new');
    Route::post('/stock', [StockController::class, 'store'])->name('dashboard.stock.store');
    Route::get('/stock/layout', [StockController::class, 'layout'])->name('dashboard.stock.layout');

    // Shipping Documents
    Route::get('/documents', [ShippingDocumentController::class, 'index'])->name('dashboard.documents');
    Route::get('/documents/create', [ShippingDocumentController::class, 'create'])->name('dashboard.documents.create');
    Route::post('/documents', [ShippingDocumentController::class, 'store'])->name('dashboard.documents.store');
    Route::get('/documents/analytics', [ShippingDocumentController::class, 'analytics'])->name('dashboard.documents.analytics');
    Route::get('/documents/{document}', [ShippingDocumentController::class, 'show'])->name('dashboard.documents.show');
    Route::post('/documents/{document}/parse', [ShippingDocumentController::class, 'parse'])->name('dashboard.documents.parse');
    Route::get('/documents/{document}/download', [ShippingDocumentController::class, 'download'])->name('dashboard.documents.download');
    Route::delete('/documents/{document}', [ShippingDocumentController::class, 'destroy'])->name('dashboard.documents.destroy');

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('dashboard.messages');
    Route::get('/messages/send', [MessageController::class, 'compose'])->name('dashboard.messages.send');
    Route::post('/messages', [MessageController::class, 'store'])->name('dashboard.messages.send');
    Route::get('/messages/notifications', [MessageController::class, 'notifications'])->name('dashboard.messages.notifications');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('dashboard.settings');
});
```

## Important Notes

1. Make sure to import the controllers at the top of the file
2. All routes are protected by the `auth` middleware
3. The routes are prefixed with `/dashboard`
4. Document routes must be registered in this order to avoid conflicts

## Controllers You Need to Create

If you haven't created these controllers yet, run:

```bash
php artisan make:controller ProductController
php artisan make:controller StockController
php artisan make:controller MessageController
php artisan make:controller SettingsController
```

## Policy Registration

Don't forget to register the ShippingDocumentPolicy in `app/Providers/AuthServiceProvider.php`:

```php
use App\Models\ShippingDocument;
use App\Policies\ShippingDocumentPolicy;

protected $policies = [
    ShippingDocument::class => ShippingDocumentPolicy::class,
];
```
