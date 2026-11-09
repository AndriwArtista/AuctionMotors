<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arremates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veiculo_id')->unique()->constrained('veiculos')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('lance_id')->nullable()->constrained('lances')->nullOnDelete();
            $table->decimal('valor_final', 10, 2)->nullable();
            $table->dateTime('encerrado_em');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arremates');
    }
};
