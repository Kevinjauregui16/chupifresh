<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity'); // Cantidad vendida
            $table->decimal('price', 8, 2); // Precio unitario en el momento de la venta
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_products');
    }
};
