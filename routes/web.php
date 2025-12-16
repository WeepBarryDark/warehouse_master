<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ShippingDocumentController;

// E-commerce public routes
Route::get('/', function () {
    return Inertia::render('ecommerce/Home');
})->name('home');

Route::get('/products', function () {
    return Inertia::render('ecommerce/Products');
})->name('products');

Route::get('/pricing', function () {
    return Inertia::render('ecommerce/Pricing');
})->name('pricing');

Route::get('/about', function () {
    return Inertia::render('ecommerce/About');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('ecommerce/Contact');
})->name('contact');

Route::get('/help', function () {
    return Inertia::render('ecommerce/Help');
})->name('help');

Route::get('/cart', function () {
    return Inertia::render('ecommerce/Cart');
})->name('cart');

// Dashboard for authenticated users
Route::middleware(['auth', 'verified', 'client'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Message Center - Available to all roles
    Route::prefix('dashboard/messages')->name('dashboard.messages.')->middleware('role:message_center')->group(function () {
        Route::get('/', function () {
            return Inertia::render('dashboard/messages/Index');
        })->name('index');
        
        Route::get('/notifications', function () {
            return Inertia::render('dashboard/messages/Notifications');
        })->name('notifications');
    });

    // Account Management - Available to all roles
    Route::prefix('dashboard/account')->name('dashboard.account.')->middleware('role:account')->group(function () {
        Route::get('/profile', function () {
            return Inertia::render('dashboard/account/Profile');
        })->name('profile');
        
        Route::get('/company', function () {
            return Inertia::render('dashboard/account/Company');
        })->name('company');
        
        Route::get('/orders', function () {
            return Inertia::render('dashboard/account/Orders');
        })->name('orders');
        
        Route::get('/deals', function () {
            return Inertia::render('dashboard/account/Deals');
        })->name('deals');
    });

    // Transaction Management - Shop Manager, Admin, Super Admin
    Route::prefix('dashboard/transactions')->name('dashboard.transactions.')->middleware('role:transaction_management')->group(function () {
        Route::get('/orders', function () {
            return Inertia::render('dashboard/transactions/Orders');
        })->name('orders');
        
        Route::get('/backorders', function () {
            return Inertia::render('dashboard/transactions/Backorders');
        })->name('backorders');
        
        Route::get('/invoices', function () {
            return Inertia::render('dashboard/transactions/Invoices');
        })->name('invoices');
    });

    // Warehouse Management - Admin, Super Admin only
    Route::prefix('dashboard/warehouse')->name('dashboard.warehouse.')->middleware('role:warehouse_management')->group(function () {
        Route::get('/stock-records', function () {
            return Inertia::render('dashboard/warehouse/StockRecords');
        })->name('stock_records');
        
        Route::get('/inventory', function () {
            return Inertia::render('dashboard/warehouse/Inventory');
        })->name('inventory');
        
        Route::get('/imported-files', function () {
            return Inertia::render('dashboard/warehouse/ImportedFiles');
        })->name('imported_files');
    });

    // Product Management
    Route::prefix('dashboard/products')->name('dashboard.products.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('dashboard/products/Index');
        })->name('index');

        Route::get('/new', function () {
            return Inertia::render('dashboard/products/New');
        })->name('new');
    });

    // Stock Management
    Route::prefix('dashboard/stock')->name('dashboard.stock.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('dashboard/stock/Index');
        })->name('index');

        Route::get('/new', function () {
            return Inertia::render('dashboard/stock/New');
        })->name('new');

        Route::get('/layout', function () {
            return Inertia::render('dashboard/stock/Layout');
        })->name('layout');
    });

    // Shipping Documents Management
    Route::prefix('dashboard/documents')->name('dashboard.documents.')->group(function () {
        Route::get('/', [ShippingDocumentController::class, 'index'])->name('index');
        Route::get('/create', [ShippingDocumentController::class, 'create'])->name('create');
        Route::post('/', [ShippingDocumentController::class, 'store'])->name('store');
        Route::get('/analytics', [ShippingDocumentController::class, 'analytics'])->name('analytics');
        Route::get('/{document}', [ShippingDocumentController::class, 'show'])->name('show');
        Route::post('/{document}/parse', [ShippingDocumentController::class, 'parse'])->name('parse');
        Route::get('/{document}/download', [ShippingDocumentController::class, 'download'])->name('download');
        Route::delete('/{document}', [ShippingDocumentController::class, 'destroy'])->name('destroy');
    });

    // Message Center - Send Message
    Route::prefix('dashboard/messages')->name('dashboard.messages.')->group(function () {
        Route::get('/send', function () {
            return Inertia::render('dashboard/messages/Send');
        })->name('send');
    });

    // System Settings - Available to all roles
    Route::get('dashboard/settings', function () {
        return Inertia::render('dashboard/Settings');
    })->name('dashboard.settings')->middleware('role:settings');

    // Laravel System Admin Access - Super Admin only
    Route::prefix('dashboard/system')->name('dashboard.system.')->middleware('role:laravel_system_access')->group(function () {
        Route::get('/users', function () {
            return Inertia::render('dashboard/system/Users');
        })->name('users');
        
        Route::get('/clients', function () {
            return Inertia::render('dashboard/system/Clients');
        })->name('clients');
        
        Route::get('/logs', function () {
            return Inertia::render('dashboard/system/Logs');
        })->name('logs');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
