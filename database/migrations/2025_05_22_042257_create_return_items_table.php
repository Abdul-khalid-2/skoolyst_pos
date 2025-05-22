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
        Schema::create('return_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('return_items_tenant_id_foreign');
            $table->unsignedBigInteger('return_id')->index('return_items_return_id_foreign');
            $table->unsignedBigInteger('sale_item_id')->index('return_items_sale_item_id_foreign');
            $table->decimal('quantity', 10);
            $table->decimal('unit_price', 12);
            $table->decimal('total_price', 12);
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};
