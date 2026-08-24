<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    public function lances(){
        return $this->hasMany(Lance::class);
    }
}
