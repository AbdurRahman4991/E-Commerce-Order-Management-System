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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete()
                  ->index();
            $table->string('sku')->unique();
            $table->string('attribute')->index; // e.g. "size=XL,color=Blue"
            $table->decimal('price', 10, 2)->index;
            $table->integer('stock')->default(0)->index;
            $table->integer('low_stock_threshold', 10, 2)->index;
            $table->timestamps();
             $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
