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
        Schema::table('stock_history', function (Blueprint $table) {
            $table->foreign(['branch_id'])->references(['id'])->on('branches')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['product_id'])->references(['id'])->on('products')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['tenant_id'])->references(['id'])->on('tenants')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['variant_id'])->references(['id'])->on('product_variants')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_history', function (Blueprint $table) {
            $table->dropForeign('stock_history_branch_id_foreign');
            $table->dropForeign('stock_history_product_id_foreign');
            $table->dropForeign('stock_history_tenant_id_foreign');
            $table->dropForeign('stock_history_variant_id_foreign');
        });
    }
};
