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
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('purchases_tenant_id_foreign');
            $table->unsignedBigInteger('supplier_id')->index('purchases_supplier_id_foreign');
            $table->unsignedBigInteger('branch_id')->index('purchases_branch_id_foreign');
            $table->string('invoice_number');
            $table->decimal('subtotal', 12);
            $table->decimal('tax_amount', 12)->default(0);
            $table->decimal('discount_amount', 12)->default(0);
            $table->decimal('shipping_amount', 12)->default(0);
            $table->decimal('total_amount', 12);
            $table->string('status', 20)->default('received');
            $table->text('notes')->nullable();
            $table->timestamp('purchase_date')->useCurrent();
            $table->timestamp('expected_delivery_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
