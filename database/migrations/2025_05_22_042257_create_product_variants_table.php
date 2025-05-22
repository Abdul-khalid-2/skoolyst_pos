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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('product_variants_tenant_id_foreign');
            $table->unsignedBigInteger('product_id')->index('product_variants_product_id_foreign');
            $table->string('name', 100);
            $table->string('sku', 100)->unique();
            $table->string('barcode', 100)->nullable();
            $table->decimal('purchase_price', 12);
            $table->decimal('selling_price', 12);
            $table->integer('current_stock')->default(0);
            $table->string('unit_type', 50)->default('pcs');
            $table->decimal('weight', 10, 3)->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
