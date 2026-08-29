<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanceController;
use App\Http\Controllers\VeiculoController;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-submit', [AuthController::class, 'loginSubmit'])->name('login.submit');
});

Route::middleware(['logged'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [VeiculoController::class, 'index'])->name('veiculos.index');

    Route::get('/veiculos/listar', [VeiculoController::class, 'list'])->name('veiculos.listar');
    Route::get('/veiculos/criar', [VeiculoController::class, 'create'])->name('veiculos.create');
    Route::post('/veiculos', [VeiculoController::class, 'store'])->name('veiculos.store');
    Route::get('/veiculos/{id}/editar', [VeiculoController::class, 'edit'])->name('veiculos.edit');
    Route::put('/veiculos/{id}', [VeiculoController::class, 'update'])->name('veiculos.update');
    Route::delete('/veiculos/{id}', [VeiculoController::class, 'destroy'])->name('veiculos.destroy');

    Route::get('/lances/{veiculo_id}', [LanceController::class, 'index'])->name('lances.create');
    Route::post('/lances/{veiculo_id}', [LanceController::class, 'store'])->name('lances.store');
});