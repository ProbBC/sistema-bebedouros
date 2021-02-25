<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlocoController;
use App\Http\Controllers\BebedouroController;
use App\Http\Controllers\SolicitacaoTrocaController;
use App\Http\Controllers\TrocaFiltroController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [SolicitacaoTrocaController::class, 'index'])
  ->middleware(['auth'])->name('solicitacoes.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/teste', function () {
  return view('layouts.solicitacoes');
});


# Rotas para Blocos
Route::get('/blocos', [BlocoController::class, 'index'])
  ->middleware(['auth'])->name('blocos.index');

Route::delete('/blocos', [BlocoController::class, 'destroy'])
  ->middleware(['auth'])->name('blocos.destroy');

Route::post('/blocos', [BlocoController::class, 'store'])
  ->middleware(['auth'])->name('blocos.store');

Route::put('/blocos/{bloco}', [BlocoController::class, 'update'])
  ->middleware(['auth'])->name('blocos.update');

# Rotas para Bebedouros

Route::get('/bebedouros', [BebedouroController::class, 'index'])
  ->middleware(['auth'])->name('bebedouros.index');

Route::delete('/bebedouros', [BebedouroController::class, 'destroy'])
  ->middleware(['auth'])->name('bebedouros.destroy');

Route::post('/bebedouros', [BebedouroController::class, 'store'])
  ->middleware(['auth'])->name('bebedouros.store');

Route::put('/bebedouros/{bebedouro}', [BebedouroController::class, 'update'])
  ->middleware(['auth'])->name('bebedouros.update');

# Rotas para solicitações de trocas

Route::get('/solicitacoes', [SolicitacaoTrocaController::class, 'index'])
  ->middleware(['auth'])->name('solicitacoes.index');

Route::delete('/solicitacoes', [SolicitacaoTrocaController::class, 'destroy'])
  ->middleware(['auth'])->name('solicitacoes.destroy');

Route::post('/solicitacoes', [SolicitacaoTrocaController::class, 'store'])
  ->middleware(['auth'])->name('solicitacoes.store');

Route::put('/solicitacoes/{solicitacaoTroca}', [SolicitacaoTrocaController::class, 'update'])
  ->middleware(['auth'])->name('solicitacoes.update');

# Rotas para trocas realizadas

Route::get('/trocas', [TrocaFiltroController::class, 'index'])
  ->middleware(['auth'])->name('trocas.index');

Route::delete('/trocas', [TrocaFiltroController::class, 'destroy'])
  ->middleware(['auth'])->name('trocas.destroy');

Route::post('/trocas', [TrocaFiltroController::class, 'store'])
  ->middleware(['auth'])->name('trocas.store');

Route::put('/trocas/{id}', [TrocaFiltroController::class, 'update'])
  ->middleware(['auth'])->name('trocas.update');

/*Route::resource('blocos', BlocoController::class)
  ->middleware('auth');

Route::resource('bebedouros', BebedouroController::class)
  ->middleware('auth');

Route::resource('solicitacao-trocas', SolicitacaoTrocaController::class)
  ->middleware('auth');

Route::resource('troca-filtros', TrocaFiltroController::class)
  ->middleware('auth');*/

require __DIR__.'/auth.php';
