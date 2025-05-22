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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('inventory_logs_tenant_id_foreign');
            $table->unsignedBigInteger('product_id')->index('inventory_logs_product_id_foreign');
            $table->unsignedBigInteger('variant_id')->index('inventory_logs_variant_id_foreign');
            $table->unsignedBigInteger('branch_id')->index('inventory_logs_branch_id_foreign');
            $table->integer('quantity_change');
            $table->integer('new_quantity');
            $table->string('reference_type');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('inventory_logs_user_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
