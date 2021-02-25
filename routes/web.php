<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('gerenciamentoCampeonato', [App\Http\Controllers\GerenciamentoCampeonatoController::class, 'index'])->name('gerenciamentoCampeonato');

Route::get('gerenciamentoCampeonato/criarCampeonato', [App\Http\Controllers\GerenciamentoCampeonatoController::class, 'criarCampeonato'])->name('gerenciamentoCampeonato.criarCampeonato');

Route::post('gerenciamentoCampeonato/gravarCampeonato', [App\Http\Controllers\GerenciamentoCampeonatoController::class, 'gravarCampeonato'])->name('gerenciamentoCampeonato.gravarCampeonato');

Route::get('campeonato/inscricaoTime/{id}', [App\Http\Controllers\InscricaoCampeonatoController::class, 'create'])->name('inscricaoTime');

Route::post('campeonato/inscricaoTime/gravar', [App\Http\Controllers\InscricaoCampeonatoController::class, 'store'])->name('inscricao.store');



