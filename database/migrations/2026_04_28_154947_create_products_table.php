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
            $table->double('price');
            $table->double('dos_value');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->foreignId('dosage_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique();
            $table->date('expiry_date');
            $table->integer('stock_quantity');
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
