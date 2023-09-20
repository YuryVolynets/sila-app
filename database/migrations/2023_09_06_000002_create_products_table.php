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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name')
                ->comment('Название товара');
            $table->string('description', 1000)
                ->nullable()
                ->comment('Описание товара');
            $table->string('slug')
                ->unique()
                ->comment('ЧПУ товара');
            $table->unsignedInteger('price_raw')
                ->comment('Цена товара, коп');
            $table->unsignedSmallInteger('length_raw')
                ->nullable()
                ->comment('Длина, мм');
            $table->unsignedSmallInteger('width_raw')
                ->nullable()
                ->comment('Ширина, мм');
            $table->unsignedSmallInteger('height_raw')
                ->nullable()
                ->comment('Высота, мм');
            $table->unsignedMediumInteger('weight_raw')
                ->nullable()
                ->comment('Масса, г');

            $table->foreignId('folder_id')
                ->comment('ID категории');

            $table->softDeletes();
            $table->timestamps();

            $table->comment('Товары');
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
