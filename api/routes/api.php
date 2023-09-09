<?php

use App\Http\Controllers\VendaController;
use App\Http\Controllers\VendedorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('vendedor')->group(function () {
    Route::post('/', [VendedorController::class, 'criarNovoVendedor']);
    Route::get('/', [VendedorController::class, 'listarTodosVendedores']);
});

Route::prefix('venda')->group(function () {
    Route::post('/', [VendaController::class, 'lancarNovaVenda']);
});
