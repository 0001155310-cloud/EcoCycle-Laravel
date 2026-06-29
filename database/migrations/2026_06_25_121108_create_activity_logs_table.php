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
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable(); // Quem fez
        $table->string('acao');                           // O que fez (ex: 'Login', 'Update Cliente')
        $table->text('descricao')->nullable();            // Detalhes da ação
        $table->string('ip_address', 45)->nullable();     // IP do usuário
        $table->timestamps();

        // Se sua tabela de usuários se chamar 'clientes', aponte para ela:
        $table->foreign('user_id')->references('id')->on('clientes')->onDelete('set null');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
