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
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('availability');
            $table->string('brand');
            $table->decimal('price', 8, 2);
            $table->decimal('old_price', 8, 2)->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->text('description')->nullable();
            $table->text('details')->nullable();
            $table->foreignId('category_id')->constrained();
            $table->json('colors')->nullable();
            $table->json('sizes')->nullable();
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
