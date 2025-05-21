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
};
use App\Models\Supplier;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [BackendController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('admin.dashboard');
Route::get('home', [BackendController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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


// Route::get('customers', [CustomerController::class, 'index'])->middleware(['auth', 'verified'])->name('customers.index');
// Route::get('add_customers', [CustomerController::class, 'create'])->middleware(['auth', 'verified'])->name('customers.create');
// Route::get('users', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('users.index');
// Route::get('add_users', [UserController::class, 'create'])->middleware(['auth', 'verified'])->name('users.create');
// Route::get('suppliers', [SupplierController::class, 'index'])->middleware(['auth', 'verified'])->name('suppliers.index');
// Route::get('add_suppliers', [SupplierController::class, 'create'])->middleware(['auth', 'verified'])->name('suppliers.suppliers');
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

require __DIR__ . '/auth.php';
