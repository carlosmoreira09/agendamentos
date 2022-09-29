<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\PacientesController;
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


Route::get('/pacientes', [PacientesController::class, 'pacientes'])->name('pacientes');
Route::get('/pacientes/edit/{id}', [PacientesController::class, 'pacientes'])->name('paciente.edit');
Route::get('/pacientes/remove/{id}', [PacientesController::class, 'pacientes'])->name('paciente.remove');

