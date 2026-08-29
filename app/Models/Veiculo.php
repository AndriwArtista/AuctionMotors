<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veiculo extends Model
{
    use SoftDeletes;

    protected $casts = [
        'data_encerramento' => 'datetime',
    ];

    public function lances()
    {
        return $this->hasMany(Lance::class);
    }
}
