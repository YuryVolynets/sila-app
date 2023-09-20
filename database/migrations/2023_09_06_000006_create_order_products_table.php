<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();

            $table->string('name')
                ->comment('Название товара');
            $table->unsignedInteger('price_raw')
                ->comment('Цена товара, коп.');
            $table->unsignedSmallInteger('number')
                ->comment('Количество товара');

            $table->foreignId('order_id')
                ->comment('ID заказа')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
