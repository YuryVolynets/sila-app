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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name')
                ->comment('Имя пользователя');
            $table->string('email')
                ->unique()
                ->comment('Email пользователя');
            $table->string('phone')
                ->comment('Номер телефона пользователя');
            $table->string('password')
                ->comment('Пароль пользователя');

            $table->rememberToken();
            $table->timestamps();

            $table->comment('Пользователи');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
