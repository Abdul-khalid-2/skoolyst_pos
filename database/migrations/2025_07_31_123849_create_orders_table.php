<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->json('walk_in_customer_info')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('order_number')->unique();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);

            $table->string('status')->default('draft'); // draft, confirmed, completed, cancelled
            $table->string('source')->default('pos'); // pos, online, phone, etc.
            $table->string('storage_type')->default('session'); // session or database

            $table->text('notes')->nullable();
            $table->timestamp('expires_at')->nullable(); // for session-based orders

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};


// CREATE TABLE `orders` (
//   `id` bigint unsigned NOT NULL AUTO_INCREMENT,
//   `tenant_id` bigint unsigned NOT NULL,
//   `branch_id` bigint unsigned NOT NULL,
//   `customer_id` bigint unsigned DEFAULT NULL,
//   `walk_in_customer_info` json DEFAULT NULL,
//   `user_id` bigint unsigned DEFAULT NULL,
//   `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
//   `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
//   `tax_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
//   `discount_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
//   `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
//   `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
//   `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pos',
//   `storage_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'session',
//   `notes` text COLLATE utf8mb4_unicode_ci,
//   `expires_at` timestamp NULL DEFAULT NULL,
//   `created_at` timestamp NULL DEFAULT NULL,
//   `updated_at` timestamp NULL DEFAULT NULL,
//   `deleted_at` timestamp NULL DEFAULT NULL,
//   PRIMARY KEY (`id`),
//   UNIQUE KEY `orders_order_number_unique` (`order_number`),
//   KEY `orders_tenant_id_foreign` (`tenant_id`),
//   KEY `orders_branch_id_foreign` (`branch_id`),
//   KEY `orders_customer_id_foreign` (`customer_id`),
//   KEY `orders_user_id_foreign` (`user_id`),
//   CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
//   CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
//   CONSTRAINT `orders_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
//   CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;