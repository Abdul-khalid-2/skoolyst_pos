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
        Schema::create('stock_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('branch_id')->index('stock_history_branch_id_foreign');
            $table->unsignedBigInteger('product_id')->index('stock_history_product_id_foreign');
            $table->unsignedBigInteger('variant_id')->index('stock_history_variant_id_foreign');
            $table->date('date');
            $table->integer('opening_stock')->default(0);
            $table->integer('purchases')->default(0);
            $table->integer('sales')->default(0);
            $table->integer('adjustments')->default(0);
            $table->integer('closing_stock')->default(0);
            $table->timestamps();

            $table->unique(['tenant_id', 'branch_id', 'product_id', 'variant_id', 'date'], 'stock_history_unique_record');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_history');
    }
};
