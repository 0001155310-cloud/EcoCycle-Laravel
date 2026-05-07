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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->string('email')->unique();
            $table->string('tel')->nullable();
            $table->string('password');

            $table->date('nascimento')->nullable();
            $table->string('estado')->nullable();
            $table->string('genero')->nullable();

            $table->text('interesses')->nullable();
            $table->text('apresentacao')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};