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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->uuid()
                ->unique()
                ->comment('UUID заказа');
            $table->string('email')
                ->comment('Email пользователя');
            $table->string('phone')
                ->comment('Номер телефона пользователя');

            $table->foreignId('user_id')
                ->nullable()
                ->comment('ID пользователя')
                ->constrained()
                ->nullOnDelete();

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
