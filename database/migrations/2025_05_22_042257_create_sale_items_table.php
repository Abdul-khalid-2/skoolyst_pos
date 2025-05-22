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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('sale_items_tenant_id_foreign');
            $table->unsignedBigInteger('sale_id')->index('sale_items_sale_id_foreign');
            $table->unsignedBigInteger('product_id')->index('sale_items_product_id_foreign');
            $table->unsignedBigInteger('variant_id')->index('sale_items_variant_id_foreign');
            $table->decimal('quantity', 10);
            $table->decimal('unit_price', 12);
            $table->decimal('cost_price', 12);
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
        Schema::dropIfExists('sale_items');
    }
};
