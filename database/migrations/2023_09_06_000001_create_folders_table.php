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
        Schema::create('folders', function (Blueprint $table) {
            $table->id();

            $table->string('name')
                ->comment('Название категории');

            $table->foreignId('parent_id')
                ->nullable()
                ->comment('ID родительской категории');

            $table->timestamps();

            $table->comment('Категории');
        });

        Schema::table('folders', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('folders')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
