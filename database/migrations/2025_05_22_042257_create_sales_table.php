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
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('sales_tenant_id_foreign');
            $table->unsignedBigInteger('branch_id')->index('sales_branch_id_foreign');
            $table->string('invoice_number')->unique();
            $table->unsignedBigInteger('customer_id')->nullable()->index('sales_customer_id_foreign');
            $table->unsignedBigInteger('user_id')->nullable()->index('sales_user_id_foreign');
            $table->decimal('subtotal', 12);
            $table->decimal('tax_amount', 12)->default(0);
            $table->decimal('discount_amount', 12)->default(0);
            $table->decimal('shipping_amount', 12)->default(0);
            $table->decimal('total_amount', 12);
            $table->decimal('amount_paid', 12);
            $table->decimal('change_amount', 12)->default(0);
            $table->string('payment_status', 20)->default('paid');
            $table->string('status', 20)->default('completed');
            $table->text('notes')->nullable();
            $table->timestamp('sale_date')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
