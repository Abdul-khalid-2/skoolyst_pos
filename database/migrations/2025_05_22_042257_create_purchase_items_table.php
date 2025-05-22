<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('purchase_items_tenant_id_foreign');
            $table->unsignedBigInteger('purchase_id')->index('purchase_items_purchase_id_foreign');
            $table->unsignedBigInteger('product_id')->index('purchase_items_product_id_foreign');
            $table->unsignedBigInteger('variant_id')->index('purchase_items_variant_id_foreign');
            $table->decimal('quantity', 10);
            $table->decimal('quantity_received', 10)->default(0);
            $table->decimal('unit_price', 12);
            $table->decimal('tax_rate', 5)->default(0);
            $table->decimal('tax_amount', 12)->default(0);
            $table->decimal('discount_rate', 5)->default(0);
            $table->decimal('discount_amount', 12)->default(0);
            $table->decimal('total_price', 12);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
