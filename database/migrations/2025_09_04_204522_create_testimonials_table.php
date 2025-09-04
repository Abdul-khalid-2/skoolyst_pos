<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('customer_name', 255);
            $table->string('customer_position', 255)->nullable();
            $table->string('company', 255)->nullable();
            $table->integer('rating')->default(5);
            $table->text('testimonial');
            $table->boolean('is_active')->default(true);
            $table->string('avatar_path', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};