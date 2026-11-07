<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('veiculo_id')->nullable()->constrained('veiculos')->cascadeOnDelete();
            // lance_recebido, lance_superado, leilao_vencido, leilao_encerrado
            $table->string('tipo', 30);
            $table->string('mensagem');
            $table->dateTime('lida_em')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'lida_em']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacoes');
    }
};
