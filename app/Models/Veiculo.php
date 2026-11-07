<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veiculo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'marca',
        'modelo',
        'ano',
        'kilometragem',
        'valor_inicial',
        'data_encerramento',
        'status',
        'user_id'
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
}
