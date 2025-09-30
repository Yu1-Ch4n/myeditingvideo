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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke User
            $table->foreignId('type_id')->constrained()->onDelete('cascade'); // Relasi ke Category
            $table->string('title');
            $table->string('meta_desc');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->decimal('price', 10, 2); // Harga produk
            $table->decimal('discount', 10, 2); // Harga produk
            $table->integer('stock')->default(0); // Stok produk
            $table->string('sku')->unique()->nullable(); // Stock Keeping Unit, bisa null
            $table->string('image')->nullable(); // Gambar artikel, bisa null
            $table->boolean('status')->default(false); // false = draft, true = published
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
