<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {

            $table->id();

            $table->string('email')->unique();

            $table->string('password');

            $table->string('tel', 20);

            $table->string('endereco');

            $table->char('estado', 2);

            $table->string('cpf', 14)->unique();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};