<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\MedicosController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\PrevisionesController;
use App\Http\Controllers\CitasPacientesController;
use App\Http\Controllers\ResumenesCitasController;
use App\Http\Controllers\AgendaMedicosController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/informacion', [HomeController::class, 'informacion'])->name('home.info');
Route::get('/sobre', [HomeController::class, 'sobreNosotros'])->name('home.sobre');

// Pacientes
Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
Route::get('/pacientes/create', [PacientesController::class, 'create'])->name('pacientes.create');
Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
Route::get('/pacientes/{paciente}/edit', [PacientesController::class, 'edit'])->name('pacientes.edit');
Route::put('/pacientes/{paciente}', [PacientesController::class, 'update'])->name('pacientes.update');
Route::delete('/pacientes/{paciente}', [PacientesController::class, 'destroy'])->name('pacientes.destroy');
Route::get('/pacientes/{paciente}', [PacientesController::class, 'show'])->name('pacientes.show');

// Médicos
Route::get('/medicos', [MedicosController::class, 'index'])->name('medicos.index');
Route::get('/medicos/create', [MedicosController::class, 'create'])->name('medicos.create');
Route::post('/medicos', [MedicosController::class, 'store'])->name('medicos.store');
Route::get('/medicos/{medico}/edit', [MedicosController::class, 'edit'])->name('medicos.edit');
Route::put('/medicos/{medico}', [MedicosController::class, 'update'])->name('medicos.update');
Route::delete('/medicos/{medico}', [MedicosController::class, 'destroy'])->name('medicos.destroy');
Route::get('/medicos/{medico}', [MedicosController::class, 'show'])->name('medicos.show');

// Especialidades
Route::get('/especialidades', [EspecialidadesController::class, 'index'])->name('especialidades.index');
Route::get('/especialidades/create', [EspecialidadesController::class, 'create'])->name('especialidades.create');
Route::post('/especialidades', [EspecialidadesController::class, 'store'])->name('especialidades.store');
Route::get('/especialidades/{especialidad}/edit', [EspecialidadesController::class, 'edit'])->name('especialidades.edit');
Route::put('/especialidades/{especialidad}', [EspecialidadesController::class, 'update'])->name('especialidades.update');
Route::delete('/especialidades/{especialidad}', [EspecialidadesController::class, 'destroy'])->name('especialidades.destroy');
Route::get('/especialidades/{especialidad}', [EspecialidadesController::class, 'show'])->name('especialidades.show');

// Previsiones
Route::get('/previsiones', [PrevisionesController::class, 'index'])->name('previsiones.index');
Route::get('/previsiones/create', [PrevisionesController::class, 'create'])->name('previsiones.create');
Route::post('/previsiones', [PrevisionesController::class, 'store'])->name('previsiones.store');
Route::get('/previsiones/{prevision}/edit', [PrevisionesController::class, 'edit'])->name('previsiones.edit');
Route::put('/previsiones/{prevision}', [PrevisionesController::class, 'update'])->name('previsiones.update');
Route::delete('/previsiones/{prevision}', [PrevisionesController::class, 'destroy'])->name('previsiones.destroy');
Route::get('/previsiones/{prevision}', [PrevisionesController::class, 'show'])->name('previsiones.show');

// Citas
Route::get('/citas', [CitasPacientesController::class, 'index'])->name('citas.index');
Route::post('/citas/buscar', [CitasPacientesController::class, 'buscar'])->name('citas.buscar');

Route::get('/citas/registrar-paciente', [CitasPacientesController::class, 'registrarPaciente'])->name('citas.registrarPaciente');
Route::post('/citas/guardar-paciente', [CitasPacientesController::class, 'guardarPaciente'])->name('citas.guardarPaciente');

Route::get('/citas/modificar', [CitasPacientesController::class, 'buscarPorRut'])->name('citas.buscarPorRut');
Route::post('/citas/modificar', [CitasPacientesController::class, 'mostrarCitaActu'])->name('citas.mostrarCitaActu');

Route::get('/citas/cancelar',[CitasPacientesController::class, 'cancelarPorRut'])->name('citas.cancelarPorRut');
Route::post('/citas/cancelar',[CitasPacientesController::class, 'mostrarCancelar'])->name('citas.mostrarCancelar');

Route::get('/citas/reservar', [CitasPacientesController::class, 'create'])->name('citas.create');
Route::post('/citas/reservar', [CitasPacientesController::class, 'store'])->name('citas.store');
Route::get('/citas/{cita}/edit', [CitasPacientesController::class, 'edit'])->name('citas.edit');
Route::put('/citas/{cita}', [CitasPacientesController::class, 'update'])->name('citas.update');
Route::delete('/citas/{cita}', [CitasPacientesController::class, 'destroy'])->name('citas.destroy');
Route::get('/citas/{cita}', [CitasPacientesController::class, 'show'])->name('citas.show');

// Resumen de Citas
Route::get('/resumen-citas', [ResumenesCitasController::class, 'index'])->name('resumenCitas.index');
Route::get('/resumen-citas/create', [ResumenesCitasController::class, 'create'])->name('resumenCitas.create');
Route::post('/resumen-citas', [ResumenesCitasController::class, 'store'])->name('resumenCitas.store');
Route::get('/resumen-citas/{resumenCita}/edit', [ResumenesCitasController::class, 'edit'])->name('resumenCitas.edit');
Route::put('/resumen-citas/{resumenCita}', [ResumenesCitasController::class, 'update'])->name('resumenCitas.update');
Route::delete('/resumen-citas/{resumenCita}', [ResumenesCitasController::class, 'destroy'])->name('resumenCitas.destroy');
Route::get('/resumen-citas/{resumenCita}', [ResumenesCitasController::class, 'show'])->name('resumenCitas.show');

// Agenda de Médicos
Route::get('/agenda-medicos', [AgendaMedicosController::class, 'index'])->name('agendaMedicos.index');
Route::get('/agenda-medicos/create', [AgendaMedicosController::class, 'create'])->name('agendaMedicos.create');
Route::post('/agenda-medicos', [AgendaMedicosController::class, 'store'])->name('agendaMedicos.store');
Route::get('/agenda-medicos/{agendaMedico}/edit', [AgendaMedicosController::class, 'edit'])->name('agendaMedicos.edit');
Route::put('/agenda-medicos/{agendaMedico}', [AgendaMedicosController::class, 'update'])->name('agendaMedicos.update');
Route::delete('/agenda-medicos/{agendaMedico}', [AgendaMedicosController::class, 'destroy'])->name('agendaMedicos.destroy');
Route::get('/agenda-medicos/{agendaMedico}', [AgendaMedicosController::class, 'show'])->name('agendaMedicos.show');


// Authentication Routes (if needed)
// Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('login', [AuthController::class, 'login']);  

