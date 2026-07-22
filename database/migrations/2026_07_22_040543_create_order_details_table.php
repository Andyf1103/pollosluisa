<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('inventario_id')->constrained('inventories')->onDelete('cascade');
            $table->integer('cantidad')->default(1);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};