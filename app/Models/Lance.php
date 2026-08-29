<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Lance extends Model
{
    protected $table = 'lances';
    protected $fillable = [
        'valor_ofertado',
        'nome_licitante',
        'veiculo_id',
        'user_id',
    ];
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
