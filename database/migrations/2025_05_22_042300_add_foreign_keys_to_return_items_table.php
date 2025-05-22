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
        Schema::table('return_items', function (Blueprint $table) {
            $table->foreign(['return_id'])->references(['id'])->on('returns')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['sale_item_id'])->references(['id'])->on('sale_items')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['tenant_id'])->references(['id'])->on('tenants')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('return_items', function (Blueprint $table) {
            $table->dropForeign('return_items_return_id_foreign');
            $table->dropForeign('return_items_sale_item_id_foreign');
            $table->dropForeign('return_items_tenant_id_foreign');
        });
    }
};
