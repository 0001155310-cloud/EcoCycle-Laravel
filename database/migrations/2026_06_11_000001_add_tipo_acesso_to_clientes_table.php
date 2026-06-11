<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreignId('tipo_acesso_id')->nullable()->after('id')->constrained('tipos_acesso');
        });

        DB::table('clientes')->update(['tipo_acesso_id' => DB::table('tipos_acesso')->where('nome', 'cliente')->value('id')]);
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tipo_acesso_id');
        });
    }
};
