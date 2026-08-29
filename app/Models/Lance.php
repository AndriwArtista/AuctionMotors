<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Lance extends Model
{
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
