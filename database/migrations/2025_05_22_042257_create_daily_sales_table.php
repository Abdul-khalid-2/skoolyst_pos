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
        Schema::create('daily_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('branch_id')->index('daily_sales_branch_id_foreign');
            $table->date('date');
            $table->integer('total_sales')->default(0);
            $table->decimal('total_amount', 12)->default(0);
            $table->decimal('total_tax', 12)->default(0);
            $table->decimal('total_discount', 12)->default(0);
            $table->decimal('total_profit', 12)->default(0);
            $table->timestamps();

            $table->unique(['tenant_id', 'branch_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_sales');
    }
};
