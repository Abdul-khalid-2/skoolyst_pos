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
        Schema::create('returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('returns_tenant_id_foreign');
            $table->unsignedBigInteger('sale_id')->index('returns_sale_id_foreign');
            $table->unsignedBigInteger('customer_id')->nullable()->index('returns_customer_id_foreign');
            $table->unsignedBigInteger('user_id')->nullable()->index('returns_user_id_foreign');
            $table->string('return_number')->unique();
            $table->decimal('total_amount', 12);
            $table->string('status', 20)->default('pending');
            $table->text('reason');
            $table->timestamp('return_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
