<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// 1. IMPORTANTE: Adicione esta linha para importar o seu Controller
use App\Http\Controllers\Api\LeituraController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 2. CORREÇÃO: Rota aberta (sem o middleware do sanctum) para o Arduino conseguir acessar
Route::post('/leituras', [LeituraController::class, 'store']);