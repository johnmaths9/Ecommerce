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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('first_name')->nullable();
            $table->string('last_name');
            $table->string('address');
            $table->string('apartment')->nullable();
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->string('country');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('shipping', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('payment_method');
            $table->string('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
