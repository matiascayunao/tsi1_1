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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelMedicoController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/informacion', [HomeController::class, 'informacion'])->name('home.info');
Route::get('/sobre', [HomeController::class, 'sobreNosotros'])->name('home.sobre');

Route::get('/secretaria', [HomeController::class, 'indexSecretaria'])->name('secretaria.index');
Route::get('/medico', [HomeController::class, 'indexMedico'])->name('medico.index');


// ===================== PACIENTES (SECRETARIA) =====================

// Menú principal (las 4 cards)
Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');

// Pantallas de buscar por RUT (detalle / actualizar / eliminar)
Route::get('/pacientes/detalle',    [PacientesController::class, 'detalle'])->name('pacientes.detalle');
Route::get('/pacientes/actualizar', [PacientesController::class, 'actualizar'])->name('pacientes.actualizar');
Route::get('/pacientes/eliminar',   [PacientesController::class, 'eliminar'])->name('pacientes.eliminar');

Route::post('/pacientes/secretaria', [PacientesController::class, 'guardar'])->name('pacientes.guardar');

// CRUD estándar
Route::get('/pacientes/create', [PacientesController::class, 'create'])->name('pacientes.create');
Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
Route::get('/pacientes/{paciente}/edit', [PacientesController::class, 'edit'])->name('pacientes.edit');
Route::put('/pacientes/{paciente}', [PacientesController::class, 'update'])->name('pacientes.update');
Route::delete('/pacientes/{paciente}', [PacientesController::class, 'destroy'])->name('pacientes.destroy');
Route::get('/pacientes/{paciente}', [PacientesController::class, 'show'])->name('pacientes.show');

// Resúmenes de un paciente (vista general, si la usas)
Route::get('/pacientes/{paciente}/resumenes', [ResumenesCitasController::class, 'porPaciente'])
    ->name('pacientes.resumenes');


// ===================== MÉDICOS (SECRETARIA) =====================

// Menú principal (cards)
Route::get('/medicos', [MedicosController::class, 'index'])->name('medicos.index');

// Listados para secretaria
Route::get('/medicos/detalle',    [MedicosController::class, 'detalle'])->name('medicos.detalle');
Route::get('/medicos/actualizar', [MedicosController::class, 'actualizar'])->name('medicos.actualizar');
Route::get('/medicos/eliminar',   [MedicosController::class, 'eliminar'])->name('medicos.eliminar');

// CRUD estándar
Route::get('/medicos/create', [MedicosController::class, 'create'])->name('medicos.create');
Route::post('/medicos',        [MedicosController::class, 'store'])->name('medicos.store');
Route::get('/medicos/{medico}/edit', [MedicosController::class, 'edit'])->name('medicos.edit');
Route::put('/medicos/{medico}',      [MedicosController::class, 'update'])->name('medicos.update');
Route::delete('/medicos/{medico}',   [MedicosController::class, 'destroy'])->name('medicos.destroy');
Route::get('/medicos/{medico}',      [MedicosController::class, 'show'])->name('medicos.show');


// ===================== ESPECIALIDADES =====================

Route::get('/especialidades', [EspecialidadesController::class, 'index'])->name('especialidades.index');
Route::get('/especialidades/create', [EspecialidadesController::class, 'create'])->name('especialidades.create');
Route::post('/especialidades', [EspecialidadesController::class, 'store'])->name('especialidades.store');
Route::get('/especialidades/{especialidad}/edit', [EspecialidadesController::class, 'edit'])->name('especialidades.edit');
Route::put('/especialidades/{especialidad}', [EspecialidadesController::class, 'update'])->name('especialidades.update');
Route::delete('/especialidades/{especialidad}', [EspecialidadesController::class, 'destroy'])->name('especialidades.destroy');
Route::get('/especialidades/{especialidad}', [EspecialidadesController::class, 'show'])->name('especialidades.show');


// ===================== PREVISIONES =====================

Route::get('/previsiones', [PrevisionesController::class, 'index'])->name('previsiones.index');
Route::get('/previsiones/create', [PrevisionesController::class, 'create'])->name('previsiones.create');
Route::post('/previsiones', [PrevisionesController::class, 'store'])->name('previsiones.store');
Route::get('/previsiones/{prevision}/edit', [PrevisionesController::class, 'edit'])->name('previsiones.edit');
Route::put('/previsiones/{prevision}', [PrevisionesController::class, 'update'])->name('previsiones.update');
Route::delete('/previsiones/{prevision}', [PrevisionesController::class, 'destroy'])->name('previsiones.destroy');
Route::get('/previsiones/{prevision}', [PrevisionesController::class, 'show'])->name('previsiones.show');


// ===================== CITAS PACIENTES =====================

Route::get('/citas', [CitasPacientesController::class, 'index'])->name('citas.index');
Route::post('/citas/buscar', [CitasPacientesController::class, 'buscar'])->name('citas.buscar');

Route::get('/citas/registrar-paciente', [CitasPacientesController::class, 'registrarPaciente'])->name('citas.registrarPaciente');
Route::post('/citas/guardar-paciente', [CitasPacientesController::class, 'guardarPaciente'])->name('citas.guardarPaciente');

Route::get('/citas/modificar', [CitasPacientesController::class, 'buscarPorRut'])->name('citas.buscarPorRut');
Route::post('/citas/modificar', [CitasPacientesController::class, 'mostrarCitaActu'])->name('citas.mostrarCitaActu');

Route::get('/citas/cancelar',[CitasPacientesController::class, 'cancelarPorRut'])->name('citas.cancelarPorRut');
Route::post('/citas/cancelar',[CitasPacientesController::class, 'mostrarCancelar'])->name('citas.mostrarCancelar');

// Calendario y listado por día
Route::get('/citas/calendario', [CitasPacientesController::class, 'calendario'])->name('citas.calendario');
Route::get('/citas/dia',        [CitasPacientesController::class, 'porDia'])->name('citas.porDia');

// (opcional) todas las citas
Route::get('/citas/todas', [CitasPacientesController::class, 'todas'])->name('citas.todas');

// Reservar cita (público)
Route::get('/citas/reservar',  [CitasPacientesController::class, 'create'])->name('citas.create');
Route::post('/citas/reservar', [CitasPacientesController::class, 'store'])->name('citas.store');

// Rutas por ID al final
Route::get('/citas/{cita}/edit', [CitasPacientesController::class, 'edit'])
    ->name('citas.edit')->whereNumber('cita');

Route::put('/citas/{cita}', [CitasPacientesController::class, 'update'])
    ->name('citas.update')->whereNumber('cita');

Route::delete('/citas/{cita}', [CitasPacientesController::class, 'destroy'])
    ->name('citas.destroy')->whereNumber('cita');

Route::get('/citas/{cita}', [CitasPacientesController::class, 'show'])
    ->name('citas.show')->whereNumber('cita');


// ===================== RESÚMENES DE CITAS (FLUJO MÉDICO) =====================
// Todas estas rutas esperan SIEMPRE un idCita numérico.
// Crear resumen de UNA cita (formulario)
Route::get('/resumen-citas/create/{cita}', [ResumenesCitasController::class, 'createDesdeMedico'])
    ->name('resumenCitas.create')
    ->whereNumber('cita');

// Guardar resumen
Route::post('/resumen-citas/{cita}', [ResumenesCitasController::class, 'storeDesdeMedico'])
    ->name('resumenCitas.store')
    ->whereNumber('cita');

// Editar resumen
Route::get('/resumen-citas/{cita}/edit', [ResumenesCitasController::class, 'editDesdeMedico'])
    ->name('resumenCitas.edit')
    ->whereNumber('cita');

// Actualizar resumen
Route::put('/resumen-citas/{cita}', [ResumenesCitasController::class, 'updateDesdeMedico'])
    ->name('resumenCitas.update')
    ->whereNumber('cita');

// Ver resumen
Route::get('/resumen-citas/{cita}', [ResumenesCitasController::class, 'showDesdeMedico'])
    ->name('resumenCitas.show')
    ->whereNumber('cita');

Route::get('resumen-citas/', [ResumenesCitasController::class, 'index'])->name('resumenCitas.index');


// ===================== AGENDA DE MÉDICOS =====================

Route::get('/agenda-medicos', [AgendaMedicosController::class, 'index'])->name('agendaMedicos.index');
Route::get('/agenda-medicos/create', [AgendaMedicosController::class, 'create'])->name('agendaMedicos.create');
Route::post('/agenda-medicos', [AgendaMedicosController::class, 'store'])->name('agendaMedicos.store');
Route::get('/agenda-medicos/{agendaMedico}/edit', [AgendaMedicosController::class, 'edit'])->name('agendaMedicos.edit');
Route::put('/agenda-medicos/{agendaMedico}', [AgendaMedicosController::class, 'update'])->name('agendaMedicos.update');
Route::delete('/agenda-medicos/{agendaMedico}', [AgendaMedicosController::class, 'destroy'])->name('agendaMedicos.destroy');
Route::get('/agenda-medicos/{agendaMedico}', [AgendaMedicosController::class, 'show'])->name('agendaMedicos.show');


// ===================== LOGIN =====================

Route::get('/login',  [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ===================== PANEL MÉDICO =====================

Route::get('/medico/citas',     [PanelMedicoController::class, 'citas'])->name('medico.citas');
Route::get('/medico/citas/dia', [PanelMedicoController::class, 'citasDia'])->name('medico.citas.dia');
Route::get('/medico/pacientes', [PanelMedicoController::class, 'pacientes'])->name('medico.pacientes');

// Detalle de una cita, pero con template de médico
Route::get('/medico/citas/{cita}', [PanelMedicoController::class, 'verCita'])
    ->name('medico.citas.show')
    ->whereNumber('cita');
