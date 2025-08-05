<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id')->nullable();

            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('cost_price', 12);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_rate', 5, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2);

            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('variant_id')->references('id')->on('product_variants');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};


// CREATE TABLE `order_items` (
//   `id` bigint unsigned NOT NULL AUTO_INCREMENT,
//   `tenant_id` bigint unsigned NOT NULL,
//   `order_id` bigint unsigned NOT NULL,
//   `product_id` bigint unsigned NOT NULL,
//   `variant_id` bigint unsigned DEFAULT NULL,
//   `quantity` decimal(10,2) NOT NULL,
//   `unit_price` decimal(12,2) NOT NULL,
//   `cost_price` decimal(12,2) NOT NULL,
//   `tax_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
//   `tax_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
//   `discount_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
//   `discount_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
//   `total_price` decimal(12,2) NOT NULL,
//   `notes` text COLLATE utf8mb4_unicode_ci,
//   `created_at` timestamp NULL DEFAULT NULL,
//   `updated_at` timestamp NULL DEFAULT NULL,
//   PRIMARY KEY (`id`),
//   KEY `order_items_tenant_id_foreign` (`tenant_id`),
//   KEY `order_items_order_id_foreign` (`order_id`),
//   KEY `order_items_product_id_foreign` (`product_id`),
//   KEY `order_items_variant_id_foreign` (`variant_id`),
//   CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
//   CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
//   CONSTRAINT `order_items_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE,
//   CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;