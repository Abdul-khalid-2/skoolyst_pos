<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class InventoryLogsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $now = Carbon::now();

        $randomnumber = Str::random(6);
        // Check if test user exists, if not create one
        $userId = DB::table('users')->where('email', 'test' . $randomnumber . '@example.com')->value('id');

        if (!$userId) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Test User',
                'email' => 'test' . $randomnumber . '@example.com',
                'email_verified_at' => $now,
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Generate unique tenant slug and domain
        $tenantSlug = 'tenant-' . Str::random(6);
        $tenantDomain = $tenantSlug . '.example.com';

        // Check if tenant exists, if not create one
        $tenantId = DB::table('tenants')->where('slug', $tenantSlug)->value('id');

        if (!$tenantId) {
            $tenantId = DB::table('tenants')->insertGetId([
                'name' => 'Tenant ' . Str::random(4),
                'slug' => $tenantSlug,
                'domain' => $tenantDomain,
                'database_name' => 'tenant_' . Str::random(8) . '_db',
                'timezone' => 'UTC',
                'currency' => 'USD',
                'locale' => 'en_US',
                'is_active' => true,
                'settings' => null,
                'trial_ends_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Generate unique business name
        $businessName = 'Business ' . Str::random(4);

        // Check if business exists, if not create one
        $businessId = DB::table('businesses')->where('name', $businessName)->value('id');

        if (!$businessId) {
            $businessId = DB::table('businesses')->insertGetId([
                'tenant_id' => $tenantId,
                'name' => $businessName,
                'tax_number' => 'TAX' . mt_rand(100, 999),
                'registration_number' => 'REG' . mt_rand(100, 999),
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->companyEmail,
                'address' => $faker->address,
                'logo_path' => null,
                'receipt_header' => null,
                'receipt_footer' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Generate unique branch code
        $branchCode = 'BR' . mt_rand(100, 999);

        // Check if branch exists, if not create one
        $branchId = DB::table('branches')->where('code', $branchCode)->value('id');

        if (!$branchId) {
            $branchId = DB::table('branches')->insertGetId([
                'tenant_id' => $tenantId,
                'business_id' => $businessId,
                'name' => 'Branch ' . Str::random(4),
                'code' => $branchCode,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->companyEmail,
                'address' => $faker->address,
                'is_main' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Generate unique category code
        $categoryCode = strtoupper(Str::random(4));

        // Check if category exists, if not create one
        $categoryId = DB::table('categories')->where('code', $categoryCode)->value('id');

        if (!$categoryId) {
            $categoryId = DB::table('categories')->insertGetId([
                'tenant_id' => $tenantId,
                'name' => 'Category ' . Str::random(4),
                'code' => $categoryCode,
                'parent_id' => null,
                'description' => $faker->sentence,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Generate unique brand name
        $brandName = 'Brand ' . Str::random(4);

        // Check if brand exists, if not create one
        $brandId = DB::table('brands')->where('name', $brandName)->value('id');

        if (!$brandId) {
            $brandId = DB::table('brands')->insertGetId([
                'tenant_id' => $tenantId,
                'name' => $brandName,
                'description' => $faker->sentence,
                'logo_path' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Generate unique supplier name
        $supplierName = 'Supplier ' . Str::random(4);

        // Check if supplier exists, if not create one
        $supplierId = DB::table('suppliers')->where('name', $supplierName)->value('id');

        if (!$supplierId) {
            $supplierId = DB::table('suppliers')->insertGetId([
                'tenant_id' => $tenantId,
                'name' => $supplierName,
                'contact_person' => $faker->name,
                'email' => $faker->unique()->companyEmail,
                'phone' => $faker->phoneNumber,
                'alternate_phone' => null,
                'address' => $faker->address,
                'tax_number' => 'SUP' . mt_rand(100, 999),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Generate unique product SKU
        $productSku = 'PROD' . mt_rand(100, 999);

        // Check if product exists, if not create one
        $productId = DB::table('products')->where('sku', $productSku)->value('id');

        if (!$productId) {
            $productId = DB::table('products')->insertGetId([
                'tenant_id' => $tenantId,
                'name' => 'Product ' . Str::random(4),
                'sku' => $productSku,
                'barcode' => $faker->ean13,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'supplier_id' => $supplierId,
                'description' => $faker->paragraph,
                'image_paths' => null,
                'status' => 'active',
                'is_taxable' => true,
                'track_inventory' => true,
                'reorder_level' => mt_rand(5, 20),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Generate variant data
        $variantSkus = ['VARIANT-A', 'VARIANT-B'];
        $variantIds = [];

        foreach ($variantSkus as $sku) {
            // Check if variant exists, if not create one
            $variantId = DB::table('product_variants')->where('sku', $sku)->value('id');

            if (!$variantId) {
                $variantId = DB::table('product_variants')->insertGetId([
                    'tenant_id' => $tenantId,
                    'product_id' => $productId,
                    'name' => 'Variant ' . Str::random(4),
                    'sku' => $sku,
                    'barcode' => $faker->ean13,
                    'purchase_price' => $faker->randomFloat(2, 50, 500),
                    'selling_price' => $faker->randomFloat(2, 100, 1000),
                    'current_stock' => 0, // Will be updated by inventory logs
                    'unit_type' => 'pcs',
                    'weight' => $faker->randomFloat(2, 0.5, 5),
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $variantIds[] = $variantId;
            } else {
                $variantIds[] = $variantId;
            }
        }

        // Insert inventory logs with random quantities
        $quantityChanges = [mt_rand(5, 20), mt_rand(5, 20)];

        foreach ($variantIds as $index => $variantId) {
            $newQuantity = $quantityChanges[$index];

            DB::table('inventory_logs')->insert([
                'tenant_id' => $tenantId,
                'product_id' => $productId,
                'variant_id' => $variantId,
                'branch_id' => $branchId,
                'quantity_change' => $newQuantity,
                'new_quantity' => $newQuantity,
                'reference_type' => 'purchase',
                'reference_id' => mt_rand(1, 100),
                'notes' => 'Initial stock - ' . Str::random(10),
                'user_id' => $userId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Update variant stock
            DB::table('product_variants')
                ->where('id', $variantId)
                ->update(['current_stock' => $newQuantity]);
        }

        $this->command->info('Dynamic inventory data seeded successfully!');
        $this->command->info('Tenant Slug: ' . $tenantSlug);
        $this->command->info('Business Name: ' . $businessName);
        $this->command->info('Branch Code: ' . $branchCode);
        $this->command->info('Product SKU: ' . $productSku);
    }
}











































// -- Insert into users
// INSERT INTO users (NAME, email, email_verified_at, PASSWORD, remember_token, created_at, updated_at) 
// VALUES 
// ('John Doe', 'john@example.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW()),
// ('Jane Smith', 'jane@example.com', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW());

// -- Insert into tenants
// INSERT INTO tenants (NAME, slug, domain, database_name, timezone, currency, locale, is_active, settings, trial_ends_at, created_at, updated_at) 
// VALUES 
// ('Tenant A', 'tenant-a', 'tenant-a.example.com', 'tenant_a_db', 'UTC', 'USD', 'en_US', TRUE, NULL, NULL, NOW(), NOW()),
// ('Tenant B', 'tenant-b', 'tenant-b.example.com', 'tenant_b_db', 'UTC', 'USD', 'en_US', TRUE, NULL, NULL, NOW(), NOW());

// -- Insert into businesses (assuming tenant_id 1 and 2 exist)
// INSERT INTO businesses (tenant_id, NAME, tax_number, registration_number, phone, email, address, logo_path, receipt_header, receipt_footer, created_at, updated_at) 
// VALUES 
// (1, 'Business A', 'TAX123', 'REG123', '1234567890', 'business@a.com', '123 Main St', NULL, NULL, NULL, NOW(), NOW()),
// (2, 'Business B', 'TAX456', 'REG456', '0987654321', 'business@b.com', '456 Oak St', NULL, NULL, NULL, NOW(), NOW());

// -- Insert into branches (assuming tenant_id and business_id exist)
// INSERT INTO branches (tenant_id, business_id, NAME, CODE, phone, email, address, is_main, created_at, updated_at) 
// VALUES 
// (1, 1, 'Main Branch', 'MB001', '1112223333', 'branch1@a.com', '123 Main St', TRUE, NOW(), NOW()),
// (1, 1, 'Downtown Branch', 'DT002', '4445556666', 'branch2@a.com', '456 Downtown St', FALSE, NOW(), NOW());

// -- Insert into categories
// INSERT INTO categories (tenant_id, NAME, CODE, parent_id, description, created_at, updated_at) 
// VALUES 
// (1, 'Electronics', 'ELEC', NULL, 'Electronic items', NOW(), NOW()),
// (1, 'Laptops', 'LAP', 1, 'Laptop computers', NOW(), NOW());

// -- Insert into brands
// INSERT INTO brands (tenant_id, NAME, description, logo_path, created_at, updated_at) 
// VALUES 
// (1, 'Brand X', 'Premium electronics', NULL, NOW(), NOW()),
// (1, 'Brand Y', 'Budget electronics', NULL, NOW(), NOW());

// -- Insert into suppliers
// INSERT INTO suppliers (tenant_id, NAME, contact_person, email, phone, alternate_phone, address, tax_number, created_at, updated_at) 
// VALUES 
// (1, 'Supplier A', 'John Supplier', 'supplier@a.com', '1112223333', NULL, '123 Supplier St', 'SUP123', NOW(), NOW()),
// (1, 'Supplier B', 'Jane Supplier', 'supplier@b.com', '4445556666', NULL, '456 Supplier Ave', 'SUP456', NOW(), NOW());

// -- Insert into products
// INSERT INTO products (tenant_id, NAME, sku, barcode, category_id, brand_id, supplier_id, description, image_paths, STATUS, is_taxable, track_inventory, reorder_level, created_at, updated_at) 
// VALUES 
// (1, 'Laptop Pro', 'LP100', '123456789012', 2, 1, 1, 'High-end laptop', NULL, 'active', TRUE, TRUE, 5, NOW(), NOW()),
// (1, 'Keyboard Wireless', 'KB200', '987654321098', 1, 2, 2, 'Wireless keyboard', NULL, 'active', TRUE, TRUE, 10, NOW(), NOW());

// -- Insert into product_variants
// INSERT INTO product_variants (tenant_id, product_id, NAME, sku, barcode, purchase_price, selling_price, current_stock, unit_type, weight, STATUS, created_at, updated_at) 
// VALUES 
// (1, 1, '16GB RAM', 'LP100-16', '123456789013', 800.00, 999.99, 10, 'pcs', 1.5, 'active', NOW(), NOW()),
// (1, 1, '32GB RAM', 'LP100-32', '123456789014', 1000.00, 1299.99, 5, 'pcs', 1.5, 'active', NOW(), NOW());

// -- Insert into inventory_logs
// INSERT INTO inventory_logs (tenant_id, product_id, variant_id, branch_id, quantity_change, new_quantity, reference_type, reference_id, notes, user_id, created_at, updated_at) 
// VALUES 
// (1, 1, 1, 1, 10, 10, 'purchase', 1, 'Initial stock', 1, NOW(), NOW()),
// (1, 1, 2, 1, 5, 5, 'purchase', 1, 'Initial stock', 1, NOW(), NOW());

// -- Insert into customers
// INSERT INTO customers (tenant_id, NAME, email, phone, address, tax_number, credit_limit, balance, customer_group, created_at, updated_at) 
// VALUES 
// (1, 'Customer A', 'customer@a.com', '1112223333', '123 Customer St', 'CUST123', 1000.00, 0.00, 'retail', NOW(), NOW()),
// (1, 'Customer B', 'customer@b.com', '4445556666', '456 Customer Ave', 'CUST456', 2000.00, 0.00, 'wholesale', NOW(), NOW());

// -- Insert into payment_methods
// INSERT INTO payment_methods (tenant_id, NAME, CODE, TYPE, is_active, settings, created_at, updated_at) 
// VALUES 
// (1, 'Cash', 'CASH', 'cash', TRUE, NULL, NOW(), NOW()),
// (1, 'Credit Card', 'CC', 'card', TRUE, NULL, NOW(), NOW());

// -- Insert into sales
// INSERT INTO sales (tenant_id, branch_id, invoice_number, customer_id, user_id, subtotal, tax_amount, discount_amount, shipping_amount, total_amount, amount_paid, change_amount, payment_status, STATUS, notes, sale_date, created_at, updated_at) 
// VALUES 
// (1, 1, 'INV-001', 1, 1, 999.99, 99.99, 0.00, 0.00, 1099.98, 1100.00, 0.02, 'paid', 'completed', 'First sale', NOW(), NOW(), NOW()),
// (1, 1, 'INV-002', 2, 1, 1299.99, 129.99, 0.00, 0.00, 1429.98, 1500.00, 70.02, 'paid', 'completed', 'Second sale', NOW(), NOW(), NOW());

// -- Insert into sale_items
// INSERT INTO sale_items (tenant_id, sale_id, product_id, variant_id, quantity, unit_price, cost_price, tax_rate, tax_amount, discount_rate, discount_amount, total_price, notes, created_at, updated_at) 
// VALUES 
// (1, 1, 1, 1, 1, 999.99, 800.00, 10.00, 99.99, 0.00, 0.00, 1099.98, NULL, NOW(), NOW()),
// (1, 2, 1, 2, 1, 1299.99, 1000.00, 10.00, 129.99, 0.00, 0.00, 1429.98, NULL, NOW(), NOW());

// -- Insert into sale_payments
// INSERT INTO sale_payments (tenant_id, sale_id, payment_method_id, amount, reference, notes, user_id, created_at, updated_at) 
// VALUES 
// (1, 1, 1, 1100.00, 'PAY001', 'Cash payment', 1, NOW(), NOW()),
// (1, 2, 2, 1500.00, 'PAY002', 'Credit card payment', 1, NOW(), NOW());

// -- Insert into returns
// INSERT INTO RETURNS (tenant_id, sale_id, customer_id, user_id, return_number, total_amount, STATUS, reason, return_date, created_at, updated_at) 
// VALUES 
// (1, 1, 1, 1, 'RET001', 1099.98, 'completed', 'Defective product', NOW(), NOW(), NOW()),
// (1, 2, 2, 1, 'RET002', 1429.98, 'pending', 'Wrong item', NOW(), NOW(), NOW());

// -- Insert into return_items
// INSERT INTO return_items (tenant_id, return_id, sale_item_id, quantity, unit_price, total_price, reason, created_at, updated_at) 
// VALUES 
// (1, 1, 1, 1, 999.99, 1099.98, 'Defective', NOW(), NOW()),
// (1, 2, 2, 1, 1299.99, 1429.98, 'Wrong item', NOW(), NOW());

// -- Insert into purchases
// INSERT INTO purchases (tenant_id, supplier_id, branch_id, invoice_number, subtotal, tax_amount, discount_amount, shipping_amount, total_amount, STATUS, notes, purchase_date, expected_delivery_date, created_at, updated_at) 
// VALUES 
// (1, 1, 1, 'PUR-001', 800.00, 80.00, 0.00, 0.00, 880.00, 'received', 'First purchase', NOW(), NOW(), NOW(), NOW()),
// (1, 2, 1, 'PUR-002', 1000.00, 100.00, 0.00, 0.00, 1100.00, 'received', 'Second purchase', NOW(), NOW(), NOW(), NOW());

// -- Insert into purchase_items
// INSERT INTO purchase_items (tenant_id, purchase_id, product_id, variant_id, quantity, quantity_received, unit_price, tax_rate, tax_amount, discount_rate, discount_amount, total_price, notes, created_at, updated_at) 
// VALUES 
// (1, 1, 1, 1, 10, 10, 800.00, 10.00, 80.00, 0.00, 0.00, 880.00, NULL, NOW(), NOW()),
// (1, 2, 1, 2, 5, 5, 1000.00, 10.00, 100.00, 0.00, 0.00, 1100.00, NULL, NOW(), NOW());

// -- Insert into purchase_payments
// INSERT INTO purchase_payments (tenant_id, purchase_id, payment_method_id, amount, reference, notes, user_id, created_at, updated_at) 
// VALUES 
// (1, 1, 1, 880.00, 'PPAY001', 'Cash payment', 1, NOW(), NOW()),
// (1, 2, 2, 1100.00, 'PPAY002', 'Credit card payment', 1, NOW(), NOW());

// -- Insert into accounts
// INSERT INTO accounts (tenant_id, NAME, TYPE, account_number, opening_balance, current_balance, currency, is_default, is_active, description, created_at, updated_at) 
// VALUES 
// (1, 'Cash Account', 'cash', NULL, 10000.00, 10000.00, 'USD', TRUE, TRUE, 'Main cash account', NOW(), NOW()),
// (1, 'Bank Account', 'bank', '123456789', 50000.00, 50000.00, 'USD', FALSE, TRUE, 'Main bank account', NOW(), NOW());

// -- Insert into transactions
// INSERT INTO transactions (tenant_id, account_id, TYPE, amount, reference, description, category, user_id, DATE, created_at, updated_at) 
// VALUES 
// (1, 1, 'income', 1000.00, 'TR001', 'Initial deposit', 'deposit', 1, NOW(), NOW(), NOW()),
// (1, 2, 'expense', 500.00, 'TR002', 'Office supplies', 'supplies', 1, NOW(), NOW(), NOW());

// -- Insert into expense_categories
// INSERT INTO expense_categories (tenant_id, NAME, description, created_at, updated_at) 
// VALUES 
// (1, 'Office Supplies', 'Office expenses', NOW(), NOW()),
// (1, 'Utilities', 'Electricity, water, etc.', NOW(), NOW());

// -- Insert into expenses
// INSERT INTO expenses (tenant_id, expense_category_id, account_id, amount, reference, description, user_id, DATE, created_at, updated_at) 
// VALUES 
// (1, 1, 1, 50.00, 'EXP001', 'Paper and pens', 1, NOW(), NOW(), NOW()),
// (1, 2, 2, 100.00, 'EXP002', 'Electricity bill', 1, NOW(), NOW(), NOW());

// -- Insert into tax_rates
// INSERT INTO tax_rates (tenant_id, NAME, rate, TYPE, is_inclusive, description, created_at, updated_at) 
// VALUES 
// (1, 'VAT', 10.00, 'percentage', FALSE, 'Value Added Tax', NOW(), NOW()),
// (1, 'Sales Tax', 8.00, 'percentage', FALSE, 'Local sales tax', NOW(), NOW());

// -- Insert into daily_sales
// INSERT INTO daily_sales (tenant_id, branch_id, DATE, total_sales, total_amount, total_tax, total_discount, total_profit, created_at, updated_at) 
// VALUES 
// (1, 1, CURDATE(), 2, 2529.96, 229.98, 0.00, 629.98, NOW(), NOW()),
// (1, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 1, 1099.98, 99.99, 0.00, 199.99, NOW(), NOW());

// -- Insert into stock_history
// INSERT INTO stock_history (tenant_id, branch_id, product_id, variant_id, DATE, opening_stock, purchases, sales, adjustments, closing_stock, created_at, updated_at) 
// VALUES 
// (1, 1, 1, 1, CURDATE(), 0, 10, 1, 0, 9, NOW(), NOW()),
// (1, 1, 1, 2, CURDATE(), 0, 5, 1, 0, 4, NOW(), NOW());

// -- Insert into settings
// INSERT INTO settings (tenant_id, KEY, VALUE, created_at, updated_at) 
// VALUES 
// (1, 'company_name', '"Business A"', NOW(), NOW()),
// (1, 'currency', '"USD"', NOW(), NOW());

// -- Insert into notifications
// INSERT INTO notifications (id, tenant_id, TYPE, notifiable_type, notifiable_id, DATA, read_at, created_at, updated_at) 
// VALUES 
// (UUID(), 1, 'App\\Notifications\\SaleCompleted', 'App\\Models\\User', 1, '{"message":"Sale completed"}', NULL, NOW(), NOW()),
// (UUID(), 1, 'App\\Notifications\\LowStock', 'App\\Models\\User', 1, '{"message":"Low stock alert"}', NULL, NOW(), NOW());

// -- Insert into activity_log
// INSERT INTO activity_log (tenant_id, log_name, description, subject_type, subject_id, causer_type, causer_id, properties, created_at, updated_at) 
// VALUES 
// (1, 'default', 'Created a new sale', 'App\\Models\\Sale', 1, 'App\\Models\\User', 1, '{"amount":1099.98}', NOW(), NOW()),
// (1, 'default', 'Updated product', 'App\\Models\\Product', 1, 'App\\Models\\User', 1, '{"changes":{"price":999.99}}', NOW(), NOW());


// -- Insert roles with timestamps
// INSERT INTO `roles` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
// ('superadmin', 'web', NOW(), NOW()),
// ('admin', 'web', NOW(), NOW()),
// ('manager', 'web', NOW(), NOW()),
// ('staff', 'web', NOW(), NOW()),
// ('customer', 'web', NOW(), NOW()),
// ('supplier', 'web', NOW(), NOW()),
// ('accountant', 'web', NOW(), NOW()),
// ('salesperson', 'web', NOW(), NOW()),
// ('inventory_manager', 'web', NOW(), NOW()),
// ('report_viewer', 'web', NOW(), NOW());