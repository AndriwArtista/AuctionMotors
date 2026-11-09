<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veiculo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'marca',
        'modelo',
        'ano',
        'kilometragem',
        'valor_inicial',
        'data_encerramento',
        'status',
        'user_id',
        'categoria_id',
    ];

    protected $casts = [
        'data_encerramento' => 'datetime',
        'valor_inicial' => 'decimal:2',
        'user_id' => 'integer',
    ];

    public function lances()
    {
        return $this->hasMany(Lance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class)->withTrashed();
    }

    public function arremate()
    {
        return $this->hasOne(Arremate::class);
    }

    public function estaAberto(): bool
    {
        return $this->status === 'aberto' && $this->data_encerramento->isFuture();
    }

    public function maiorLance(): float
    {
        return (float) ($this->lances()->max('valor_ofertado') ?? $this->valor_inicial);
    }

    public function valorMinimoLance(): float
    {
        return round($this->maiorLance() + 0.01, 2);
    }
}
