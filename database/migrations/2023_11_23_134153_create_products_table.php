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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->string('name');
            $table->string('brind');
            $table->float('price');
            $table->string('color');
            $table->enum('genre', ['men', 'women', 'kids']);
            $table->integer('discount')->default(0);
            $table->integer('stock')->default(0);
            $table->string('mainImg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
