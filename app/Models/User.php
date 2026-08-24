<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];
    
    public function lances()
    {
        return $this->hasMany(Lance::class);
    }
}
