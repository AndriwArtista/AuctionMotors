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
        'user_id'
    ];

    protected $casts = [
        'data_encerramento' => 'datetime',
    ];

    public function lances()
    {
        return $this->hasMany(Lance::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
