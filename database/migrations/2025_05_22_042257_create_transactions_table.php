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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('transactions_tenant_id_foreign');
            $table->unsignedBigInteger('account_id')->index('transactions_account_id_foreign');
            $table->string('type');
            $table->decimal('amount', 12);
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('transactions_user_id_foreign');
            $table->timestamp('date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
