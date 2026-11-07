<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    protected $hidden = [
        'senha',
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];

    public function lances()
    {
        return $this->hasMany(Lance::class);
    }

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }

    // leiloes que o usuario venceu
    public function arremates()
    {
        return $this->hasMany(Arremate::class);
    }
}
