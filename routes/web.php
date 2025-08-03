<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AccountController,
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
    BackupController,
    BranchController,
    BusinessController,
    CustomerReportController,
    ExpenseController,
    IncomeController,
    InventoryReportController,
    PosController,
    SalesReportController,
    ImportExportController,
    OrderController,
    TenantController,
    TransactionController
};
use App\Http\Controllers\InventoryLogController;
use App\Http\Controllers\ProductVariantController;
use App\Models\Supplier;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified', 'role:user|admin|super-admin'])->group(function () {

    Route::get('dashboard', [BackendController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/financial-data', [BackendController::class, 'getFinancialData']);
    Route::get('/dashboard/recent-sales', [BackendController::class, 'getRecentSales']);
    Route::get('/dashboard/top-products', [BackendController::class, 'getTopProducts']);

    Route::get('/dashboard/sales-overview', [BackendController::class, 'getSalesOverview']);
    Route::get('/dashboard/revenue-cost', [BackendController::class, 'getRevenueCost']);
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('/products/{product}/variants_data', [PosController::class, 'variants']);
    Route::get('/products/search/{term}', [PosController::class, 'search']);
    Route::get('/products/barcode/{barcode}', [PosController::class, 'barcode']);
    Route::get('/categories/{category}/products', [PosController::class, 'products']);
    Route::get('/pos_products', [PosController::class, 'posProducts']);
    Route::post('/pos', [PosController::class, 'store'])->name('pos.store');

    Route::resource('sales', SaleController::class);
    Route::post('sales/{sale}/add-payment', [SaleController::class, 'addPayment'])->name('sales.add-payment');
    Route::get('sales/{sale}/invoice', [SaleController::class, 'invoice'])->name('sales.invoice');
    Route::get('sales/{sale}/invoice-pdf', [SaleController::class, 'invoicePdf'])->name('sales.invoice-pdf');


    // Invoices routes
    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
    });

    // Brands routes
    Route::resource('brands', BrandController::class);

    // Stock Transfers routes
    Route::prefix('stock-transfers')->group(function () {
        Route::get('/', [StockTransferController::class, 'index'])->name('stock-transfers.index');
    });

    // Stock Adjustments routes
    Route::prefix('stock-adjustments')->group(function () {
        Route::get('/', [StockAdjustmentController::class, 'index'])->name('stock-adjustments.index');
    });

    // Low Stock Alerts route
    Route::get('low-stock-alerts', [InventoryLogController::class, 'lowStockAlerts'])->name('low-stock-alerts');

    // Purchase Returns routes
    Route::prefix('purchase-returns')->group(function () {
        Route::get('/', [PurchaseOrderController::class, 'returns'])->name('purchase-returns.index');
    });

    // Reports routes
    Route::prefix('reports')->group(function () {
        Route::get('/sales', [SalesReportController::class, 'sales'])->name('reports.sales');
        Route::get('sales/export', [SalesReportController::class, 'exportSalesReport'])->name('reports.sales.export');
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit-loss');
        Route::get('/inventory', [InventoryReportController::class, 'inventory'])->name('reports.inventory');
        Route::get('/customer', [CustomerReportController::class, 'customer'])->name('reports.customer');
        Route::get('/customers/export', [CustomerReportController::class, 'export'])->name('reports.customer.export');
        Route::get('/inventory/export', [InventoryReportController::class, 'export'])->name('reports.inventory.export');
    });
    // Accounts 
    Route::resource('transactions', TransactionController::class);

    // Expenses
    Route::resource('expenses', ExpenseController::class);
    Route::get('expense/categories', [ExpenseController::class, 'categories'])->name('expenses.categories');
    Route::post('expense/categories', [ExpenseController::class, 'categoriesStore'])->name('expense-categories.store');
    Route::delete('expense/categories', [ExpenseController::class, 'categoriesDestroy'])->name('expense-categories.destroy');

    // Expense Category Routes
    Route::prefix('accounting/expense-categories')->name('expense-categories.')->group(function () {
        Route::post('/', [ExpenseController::class, 'expenseCategoryStore'])->name('store');
        Route::put('/{expenseCategory}', [ExpenseController::class, 'expenseCategoryUpdate'])->name('update');
    });

    // Income
    Route::resource('income', IncomeController::class);

    // Accounts
    Route::resource('accounts', AccountController::class);

    // Settings routes
    Route::prefix('settings')->group(function () {
        Route::get('/general', [SettingController::class, 'general'])->name('settings.general');
        Route::get('/pos', [SettingController::class, 'pos'])->name('settings.pos');
        Route::get('/tax', [SettingController::class, 'tax'])->name('settings.tax');
        Route::get('/business', [SettingController::class, 'business'])->name('settings.business');
    });

    // Existing routes below...
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('add_products', [ProductController::class, 'create'])->name('products.create');

    Route::get('categoryes', [CategoryController::class, 'index'])->name('categoryes.index');
    Route::get('add_categoryes', [CategoryController::class, 'create'])->name('categoryes.create');

    Route::get('purchases', [PurchaseOrderController::class, 'index'])->name('purchases.index');
    Route::get('add_purchases', [PurchaseOrderController::class, 'create'])->name('purchases.create');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('add_reports', [ReportController::class, 'create'])->name('reports.create');

    // category 
    Route::resource('categories', CategoryController::class);

    // Products
    Route::resource('products', ProductController::class);
    Route::post('products/upload-image', [ProductController::class, 'uploadImage'])->name('products.upload-image');
    Route::delete('products/remove-image', [ProductController::class, 'removeImage'])->name('products.remove-image');
    Route::get('products/{product}/inventory', [ProductController::class, 'inventory'])->name('products.inventory');

    // Product Variants
    Route::get('products-variants/{product}', [ProductVariantController::class, 'index'])->name('product-variants.index');
    Route::get('products/{product}/variants/create', [ProductVariantController::class, 'create'])->name('product-variants.create');
    Route::post('products/{product}/variants', [ProductVariantController::class, 'store'])->name('product-variants.store');
    Route::get('products/{product}/variants/{variant}/edit', [ProductVariantController::class, 'edit'])
        ->name('product-variants.edit');

    Route::put('products/{product}/variants/{variant}/edit', [ProductVariantController::class, 'update'])->name('product-variants.update');
    Route::delete('product-variants/{variant}', [ProductVariantController::class, 'destroy'])->name('product-variants.destroy');

    Route::get('products/{product}/inventory-history', [ProductController::class, 'inventoryHistory'])
        ->name('products.inventory-history');

    // Inventory Logs
    Route::get('inventory-logs', [InventoryLogController::class, 'index'])->name('inventory-logs.index');
    Route::post('inventory-logs', [InventoryLogController::class, 'store'])->name('inventory-logs.store');
    Route::get('inventory-logs/create', [InventoryLogController::class, 'create'])->name('inventory-logs.create');
    Route::delete('inventory-logs/{id}', [InventoryLogController::class, 'destroy'])->name('inventory-logs.destroy');

    // Inventory Logs
    Route::get('inventory-logs/variants/{product}', [InventoryLogController::class, 'getVariants'])
        ->name('inventory-logs.variants');

    // Users
    Route::resource('users', UserController::class);

    // Customers
    Route::resource('customers', CustomerController::class);
    Route::get('/customers/{customer}/invoice', [CustomerController::class, 'invoice'])->name('customers.invoice');
    Route::get('/customers/{customer}/invoice/download', [CustomerController::class, 'downloadInvoice'])->name('customers.invoice.download');

    // Suppliers
    Route::resource('suppliers', SupplierController::class);

    // Brand
    Route::resource('brands', BrandController::class);
    Route::post('/brands/upload-logo', [BrandController::class, 'uploadLogo'])->name('brands.upload-logo');
    Route::delete('/brands/remove-logo', [BrandController::class, 'removeLogo'])->name('brands.remove-logo');

    // // PurchaseOrder
    Route::resource('purchases', PurchaseOrderController::class)->except(['destroy']);

    // Additional purchase routes
    Route::post('purchases/{purchase}/receive-items', [PurchaseOrderController::class, 'receiveItems'])->name('purchases.receive-items');
    Route::post('purchases/{purchase}/add-payment', [PurchaseOrderController::class, 'addPayment'])->name('purchases.add-payment');
    Route::get('purchases/{purchase}/print', [PurchaseOrderController::class, 'print'])->name('purchases.print');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Website Routes 
    Route::view('/product_details', 'product_details')->name('product_details');
    Route::view('/our_products', 'our_products')->name('our_products');

    // Import/Export Routes
    Route::prefix('import')->group(function () {
        Route::get('/products', [ImportExportController::class, 'showImport'])->name('import.products.view');
        Route::post('/products', [ImportExportController::class, 'import'])->name('import.products');
        Route::get('/template', [ImportExportController::class, 'downloadTemplate'])->name('import.template');
    });

    Route::prefix('export')->group(function () {
        Route::get('/products', [ImportExportController::class, 'showExport'])->name('export.products.view');
        Route::post('/products', [ImportExportController::class, 'export'])->name('export.products');
    });

    Route::get('/database/backup', [BackupController::class, 'databaseBackup'])->name('database.backup');
    Route::get('/remove/backup/{file}', [BackupController::class, 'removeBackup'])->name('remove.backup');
    Route::get('/download/backup/{file}', [BackupController::class, 'downloadBackup'])->name('download.backup');


    // Order Management Routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::post('/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::get('/filter', [OrderController::class, 'filter'])->name('orders.filter');
    });
    Route::get('/allProducts', [OrderController::class, 'allProducts'])->name('allProducts');
});

Route::middleware(['auth', 'verified', 'role:super-admin'])->group(function () {
    // Business
    Route::resource('businesses', BusinessController::class);
    // branches
    Route::resource('branches', BranchController::class);
});

Route::middleware(['auth', 'verified', 'role:admin|super-admin'])->group(function () {


    Route::resource('businesses', BusinessController::class);
    Route::resource('branches', BranchController::class);
});

require __DIR__ . '/auth.php';
