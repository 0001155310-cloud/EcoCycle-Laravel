<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leituras_arduino', function (Blueprint $table) {
            $table->id();
            $table->string('dispositivo_id')->default('estacao-01')->comment('ID do ESP32/Arduino');
            $table->float('temperatura')->nullable()->comment('Temperatura em °C');
            $table->float('umidade')->nullable()->comment('Umidade relativa em %');
            $table->float('peso')->nullable()->comment('Peso da bombona em kg');
            $table->float('ph')->nullable()->comment('pH do material orgânico');
            $table->float('gas')->nullable()->comment('Concentração de gás (ppm)');
            $table->string('status_contaminacao')->default('nao_analisado')
                  ->comment('aprovado | contaminado | inspecao | nao_analisado');
            $table->boolean('plastico_detectado')->default(false);
            $table->string('origem_cliente')->nullable()->comment('Nome/ID do cliente que entregou');
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leituras_arduino');
    }
};
