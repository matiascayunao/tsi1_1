<?php

namespace App\Http\Controllers;

use App\Models\CitaPaciente;
use App\Models\Paciente;
use App\Models\ResumenCita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PanelMedicoController extends Controller
{
    /**
     * Menú principal del médico: Ver citas / Ver pacientes
     */
    public function index()
    {
        // Tu pantalla principal de médico está en home/index-medico.blade.php
        return view('home.index-medico');
    }

    /**
     * Calendario mensual de citas del médico.
     */
    public function citas(Request $request)
    {
        // AJUSTA ESTA LÍNEA SEGÚN Users:
        $rutMedico = Auth::user()->rutMedico ?? Auth::user()->rut ?? null;

        if (!$rutMedico) {
            abort(403, 'Falta vincular el usuario con el médico.');
        }

        $hoy = Carbon::today();

        $mes  = (int) $request->query('mes',  $hoy->month);
        $anio = (int) $request->query('anio', $hoy->year);

        $primerDiaMes = Carbon::create($anio, $mes, 1);
        $mesAnterior  = $primerDiaMes->copy()->subMonth();
        $mesSiguiente = $primerDiaMes->copy()->addMonth();

        $inicio = $primerDiaMes->copy()->startOfWeek(Carbon::MONDAY);
        $fin    = $primerDiaMes->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $semanas   = [];
        $diaActual = $inicio->copy();

        while ($diaActual <= $fin) {
            $semana = [];
            for ($i = 0; $i < 7; $i++) {
                $semana[] = $diaActual->copy();
                $diaActual->addDay();
            }
            $semanas[] = $semana;
        }

        $conteoCitas = CitaPaciente::selectRaw('DATE(fechaHora) as fecha, COUNT(*) as total')
            ->where('rutMedico', $rutMedico)
            ->whereYear('fechaHora', $anio)
            ->whereMonth('fechaHora', $mes)
            ->groupBy('fecha')
            ->pluck('total', 'fecha');

        // 👇 aquí uso el nombre REAL de tu vista: medicos/medico-citas.blade.php
        return view('medicos.medico-citas', [
            'semanas'      => $semanas,
            'hoy'          => $hoy,
            'mes'          => $mes,
            'anio'         => $anio,
            'mesAnterior'  => $mesAnterior,
            'mesSiguiente' => $mesSiguiente,
            'conteoCitas'  => $conteoCitas,
        ]);
    }

    /**
     * Listado de citas de un día concreto del médico.
     */
    public function citasDia(Request $request)
    {
        $fecha = $request->query('fecha');
        if (!$fecha) {
            abort(404);
        }

        $rutMedico = Auth::user()->rutMedico ?? Auth::user()->rut ?? null;
        if (!$rutMedico) {
            abort(403, 'Falta vincular el usuario con el médico.');
        }

        $citas = CitaPaciente::with(['paciente.prevision'])
            ->where('rutMedico', $rutMedico)
            ->whereDate('fechaHora', $fecha)
            ->orderBy('fechaHora')
            ->get();

        // 👇 nombre REAL de tu vista: medicos/citas-dia.blade.php
        return view('medicos.citas-dia', [
            'citas' => $citas,
            'fecha' => $fecha,
        ]);
    }

    /**
     * Listado de pacientes atendidos por ese médico,
     * con info de si tiene resumen o no.
     */
    public function pacientes()
{
    // AJUSTA IGUAL QUE ARRIBA
    $rutMedico = Auth::user()->rutMedico ?? Auth::user()->rut ?? null;
    if (!$rutMedico) {
        abort(403, 'Falta vincular el usuario con el médico.');
    }

    // Todas las citas del médico (con el paciente)
    $citas = CitaPaciente::with('paciente')
        ->where('rutMedico', $rutMedico)
        ->orderBy('fechaHora', 'desc')   // ✅ usamos la fecha de la cita
        ->get();

    // Agrupar por paciente y quedarnos con última cita
    $grupos = $citas->groupBy('rutPaciente');

    $items = $grupos->map(function ($grupo) {
        $cita = $grupo->sortByDesc('fechaHora')->first();
        return [
            'paciente'   => $cita->paciente,
            'ultimaCita' => $cita->fechaHora,
        ];
    })->sortByDesc('ultimaCita');

    // Buscar resúmenes existentes por paciente+medico
    // Buscar resúmenes existentes por paciente
$rutPacientes = $grupos->keys()->all();

$resumenes = ResumenCita::whereIn('rutPaciente', $rutPacientes)
    ->get()
    ->keyBy('rutPaciente');


    return view('medicos.pacientes', [
        'items'      => $items,
        'resumenes'  => $resumenes,
        'rutMedico'  => $rutMedico,
    ]);
}

}
