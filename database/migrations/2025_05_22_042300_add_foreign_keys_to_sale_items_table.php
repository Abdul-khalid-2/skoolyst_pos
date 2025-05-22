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
        Schema::table('sale_items', function (Blueprint $table) {
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['sale_id'])->references(['id'])->on('sales')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['tenant_id'])->references(['id'])->on('tenants')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['variant_id'])->references(['id'])->on('product_variants')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropForeign('sale_items_product_id_foreign');
            $table->dropForeign('sale_items_sale_id_foreign');
            $table->dropForeign('sale_items_tenant_id_foreign');
            $table->dropForeign('sale_items_variant_id_foreign');
        });
    }
};
