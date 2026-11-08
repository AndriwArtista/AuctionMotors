<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    protected $table = 'notificacoes';

    protected $fillable = [
        'user_id',
        'veiculo_id',
        'tipo',
        'mensagem',
        'lida_em',
    ];

    protected $casts = [
        'lida_em' => 'datetime',
    ];

    public const TIPOS = [
        'lance_recebido' => ['icone' => 'fa-hand-holding-dollar', 'cor' => 'primary'],
        'lance_superado' => ['icone' => 'fa-arrow-trend-up', 'cor' => 'warning'],
        'leilao_vencido' => ['icone' => 'fa-trophy', 'cor' => 'success'],
        'leilao_encerrado' => ['icone' => 'fa-flag-checkered', 'cor' => 'secondary'],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class)->withTrashed();
    }

    public function scopeNaoLidas($query)
    {
        return $query->whereNull('lida_em');
    }

    public function icone(): string
    {
        return self::TIPOS[$this->tipo]['icone'] ?? 'fa-bell';
    }

    public function cor(): string
    {
        return self::TIPOS[$this->tipo]['cor'] ?? 'secondary';
    }
}
