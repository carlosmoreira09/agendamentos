<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoController;
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

Route::get('/', [AgendamentoController::class, 'agendamento'])->name('homepage');
Route::post("create", [AgendamentoController::class, 'create'])->name("agendamento.create");
Route::get('/edit/{id}', [AgendamentoController::class, 'edit'])->name('agendamento.edit');

Route::get('/remove/{id}', [AgendamentoController::class, 'remove'])->name('agendamento.remove');
