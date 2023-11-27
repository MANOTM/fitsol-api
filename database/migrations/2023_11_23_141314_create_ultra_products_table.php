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
        Schema::create('ultra_products', function (Blueprint $table) {
            $table->id();
            $table->string('secondImg');
            $table->text('description');
            $table->integer('size38');
            $table->integer('size39');
            $table->integer('size40');
            $table->integer('size41');
            $table->integer('size42');
            $table->integer('size43');
            $table->foreignId('product_id')->constrained('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ultra_products');
    }
};
