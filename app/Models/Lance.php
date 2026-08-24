<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lance extends Model
{
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
    use SoftDeletes;
}
