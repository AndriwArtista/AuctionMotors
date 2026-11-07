<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function veiculosGeral()
    {
       
        $veiculos = Veiculo::all();

     
        $pdf = Pdf::loadView('relatorios.veiculos_geral', compact('veiculos'));

      
        return $pdf->stream('relatorio-veiculos-geral.pdf');
    }
}