<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arremate extends Model
{
    protected $table = 'arremates';

    protected $fillable = [
        'veiculo_id',
        'user_id',
        'lance_id',
        'valor_final',
        'encerrado_em',
    ];

    protected $casts = [
        'encerrado_em' => 'datetime',
        'valor_final' => 'decimal:2',
    ];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class)->withTrashed();
    }

    // quem venceu o leilao
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lance()
    {
        return $this->belongsTo(Lance::class);
    }
}
