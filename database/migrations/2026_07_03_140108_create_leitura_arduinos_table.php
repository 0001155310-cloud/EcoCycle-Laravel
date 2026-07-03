<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leitura_arduinos', function (Blueprint $table) {
            $table->id();
            $table->string('dispositivo_id');
            $table->string('fornecedor_origem')->nullable(); // Rastreabilidade e controle de origem
            
            // Dados Físicos e Processamento
            $table->decimal('volume_recebido_kg', 8, 2)->default(0);
            $table->decimal('volume_aproveitado_kg', 8, 2)->default(0); // Aumento do % reaproveitado
            $table->decimal('contaminantes_rejeitados_kg', 8, 2)->default(0); // Redução de plásticos/embalagens
            $table->decimal('pecas_por_minuto', 8, 2)->default(0); // Eficiência e capacidade operacional
            
            // Qualidade e Sensores Ambientais
            $table->decimal('umidade', 5, 2)->default(0);
            $table->decimal('temperatura', 5, 2)->default(0);
            $table->decimal('gases_ppm', 8, 2)->default(0); 
            $table->decimal('pureza_composto_percentual', 5, 2)->default(0); // Qualidade do composto final
            
            // Métricas ESG (Calculadas/Registradas)
            $table->decimal('co2_evitado_kg', 8, 2)->default(0); // Redução de gases de efeito estufa
            $table->boolean('conformidade_auditoria')->default(true); // Confiabilidade para relatórios ESG
            
            // Métricas Financeiras (Economia Gerada em R$)
            $table->decimal('custo_triagem_economizado', 10, 2)->default(0); // Redução de triagem manual
            $table->decimal('custo_descarte_evitado', 10, 2)->default(0); // Redução de multas/transporte inadequado
            $table->decimal('valor_gerado_composto', 10, 2)->default(0); // Novas receitas / Valorização
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leitura_arduinos');
    }
};