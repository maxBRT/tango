<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('game_id')->constrained()->cascadeOnDelete();
            $table->string('client_id');
            $table->timestamps();

            $table->unique(['game_id', 'client_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
