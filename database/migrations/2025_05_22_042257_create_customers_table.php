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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('customers_tenant_id_foreign');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 20);
            $table->string('address')->nullable();
            $table->string('tax_number')->nullable();
            $table->decimal('credit_limit', 12)->default(0);
            $table->decimal('balance', 12)->default(0);
            $table->string('customer_group', 50)->default('retail');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
