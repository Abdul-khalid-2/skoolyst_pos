<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    ProfileController,
    ProductController,
    CategoryController,
    BackendController,
    CustomerController,
    ReportController,
    SaleController,
    PurchaseOrderController,
    SupplierController,
    UserController,
    InvoiceController,
    BrandController,
    StockTransferController,
    StockAdjustmentController,
    SettingController,
    BackupController
};
use App\Http\Controllers\InventoryLogController;
use App\Http\Controllers\ProductVariantController;
use App\Models\Supplier;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [BackendController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('admin.dashboard');
Route::get('home', [BackendController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Sales routes
Route::prefix('sales')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/create', [SaleController::class, 'create'])->name('sales.create');
    Route::get('/pos', [SaleController::class, 'pos'])->name('pos.index');
});

// Invoices routes
Route::prefix('invoices')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
});

// Brands routes
Route::resource('brands', BrandController::class)->middleware(['auth', 'verified']);

// Stock Transfers routes
Route::prefix('stock-transfers')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [StockTransferController::class, 'index'])->name('stock-transfers.index');
});

// Stock Adjustments routes
Route::prefix('stock-adjustments')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [StockAdjustmentController::class, 'index'])->name('stock-adjustments.index');
});

// Low Stock Alerts route
Route::get('low-stock-alerts', [InventoryLogController::class, 'lowStockAlerts'])->middleware(['auth', 'verified'])->name('low-stock-alerts');

// Purchase Returns routes
Route::prefix('purchase-returns')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'returns'])->name('purchase-returns.index');
});

// Reports routes
Route::prefix('reports')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit-loss');
    Route::get('/customer', [ReportController::class, 'customer'])->name('reports.customer');
});

// Settings routes
Route::prefix('settings')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/general', [SettingController::class, 'general'])->name('settings.general');
    Route::get('/pos', [SettingController::class, 'pos'])->name('settings.pos');
    Route::get('/tax', [SettingController::class, 'tax'])->name('settings.tax');
    Route::get('/business', [SettingController::class, 'business'])->name('settings.business');
});

// Existing routes below...

Route::get('products', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('products.index');
Route::get('add_products', [ProductController::class, 'create'])->middleware(['auth', 'verified'])->name('products.create');

Route::get('categoryes', [CategoryController::class, 'index'])->middleware(['auth', 'verified'])->name('categoryes.index');
Route::get('add_categoryes', [CategoryController::class, 'create'])->middleware(['auth', 'verified'])->name('categoryes.create');

Route::get('purchases', [PurchaseOrderController::class, 'index'])->middleware(['auth', 'verified'])->name('purchases.index');
Route::get('add_purchases', [PurchaseOrderController::class, 'create'])->middleware(['auth', 'verified'])->name('purchases.create');

Route::get('reports', [ReportController::class, 'index'])->middleware(['auth', 'verified'])->name('reports.index');
Route::get('add_reports', [ReportController::class, 'create'])->middleware(['auth', 'verified'])->name('reports.create');

Route::get('sales', [SaleController::class, 'index'])->middleware(['auth', 'verified'])->name('sales.index');
Route::get('add_sales', [SaleController::class, 'create'])->middleware(['auth', 'verified'])->name('sales.create');

// category 
Route::resource('categories', CategoryController::class);


Route::middleware(['auth', 'verified'])->group(function () {
    // Products

    Route::resource('products', ProductController::class);
    Route::post('products/upload-image', [ProductController::class, 'uploadImage'])->name('products.upload-image');
    Route::delete('products/remove-image', [ProductController::class, 'removeImage'])->name('products.remove-image');
    Route::get('products/{product}/inventory', [ProductController::class, 'inventory'])->name('products.inventory');

    // Product Variants
    Route::get('products/{product}/variants', [ProductVariantController::class, 'index'])->name('product-variants.index');
    Route::get('products/{product}/variants/create', [ProductVariantController::class, 'create'])->name('product-variants.create');
    Route::post('products/{product}/variants', [ProductVariantController::class, 'store'])->name('product-variants.store');
    Route::get('products/{product}/variants/{variant}/edit', [ProductVariantController::class, 'edit'])
        ->name('product-variants.edit');

    Route::put('products/{product}/variants/{variant}/edit', [ProductVariantController::class, 'update'])->name('product-variants.update');
    Route::delete('product-variants/{variant}', [ProductVariantController::class, 'destroy'])->name('product-variants.destroy');

    // Inventory Logs
    Route::get('inventory-logs', [InventoryLogController::class, 'index'])->name('inventory-logs.index');
    Route::post('inventory-logs', [InventoryLogController::class, 'store'])->name('inventory-logs.store');
    Route::get('inventory-logs/create', [InventoryLogController::class, 'create'])->name('inventory-logs.create');
    Route::delete('inventory-logs/{id}', [InventoryLogController::class, 'destroy'])->name('inventory-logs.destroy');
});
// Inventory Logs
Route::get('inventory-logs/variants/{product}', [InventoryLogController::class, 'getVariants'])
    ->name('inventory-logs.variants')
    ->middleware(['auth', 'verified']);


// Users
Route::resource('users', UserController::class)->middleware(['auth', 'verified']);

// Customers
Route::resource('customers', CustomerController::class)->middleware(['auth', 'verified']);

// Suppliers
Route::resource('suppliers', SupplierController::class)->middleware(['auth', 'verified']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/backup/store', [BackupController::class, 'store'])->name('backup.store');


require __DIR__ . '/auth.php';
