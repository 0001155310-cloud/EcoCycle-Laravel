<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_acesso', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        DB::table('tipos_acesso')->insert([
            ['nome' => 'cliente', 'descricao' => 'Cliente comum'],
            ['nome' => 'admin', 'descricao' => 'Administrador'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_acesso');
    }
};
