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
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id')->index('expenses_tenant_id_foreign');
            $table->unsignedBigInteger('expense_category_id')->index('expenses_expense_category_id_foreign');
            $table->unsignedBigInteger('account_id')->index('expenses_account_id_foreign');
            $table->decimal('amount', 12);
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('expenses_user_id_foreign');
            $table->timestamp('date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
