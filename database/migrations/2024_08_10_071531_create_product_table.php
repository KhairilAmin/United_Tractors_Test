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
        Schema::create('product', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_category_id');
            $table->string('name');
            $table->integer('price');
            $table->string('image');
            $table->timestamps();
            $table->softDeletes('deleted_at');
            $table->foreign('product_category_id')->references('id')->on('category_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
