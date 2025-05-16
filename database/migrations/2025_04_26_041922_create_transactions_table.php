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
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->foreignId('account_id')->constrained()->onDelete('restrict');
            $table->string('type'); // income, expense, transfer
            $table->decimal('amount', 12, 2);
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('date')->useCurrent();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
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
