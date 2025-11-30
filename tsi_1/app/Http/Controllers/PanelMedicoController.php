<?php

namespace App\Http\Controllers;

use App\Models\CitaPaciente;
use App\Models\ResumenCita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PanelMedicoController extends Controller
{
    /**
     * Pantalla principal del médico (si la usas).
     */
    public function index()
    {
        return view('home.index-medico');
    }

    /**
     * Calendario mensual de citas del médico.
     */
    public function citas(Request $request)
    {
        // Ajusta esto según tu tabla users
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

        return view('medicos.citas-dia', [
            'citas' => $citas,
            'fecha' => $fecha,
        ]);
    }

    /**
     * Listado de pacientes atendidos por ese médico,
     * mostrando la última cita y si tiene resumen o no.
     */
   public function pacientes()
    {
        $rutMedico = Auth::user()->rutMedico ?? Auth::user()->rut ?? null;
        if (!$rutMedico) {
            abort(403, 'Falta vincular el usuario con el médico.');
        }

        $citas = CitaPaciente::with('paciente')
            ->where('rutMedico', $rutMedico)
            ->orderBy('fechaHora', 'desc')
            ->get();

        $grupos = $citas->groupBy('rutPaciente');

        $items = $grupos->map(function ($grupo) {
            $cita = $grupo->sortByDesc('fechaHora')->first();

            return [
                'paciente'   => $cita->paciente,
                'ultimaCita' => $cita->fechaHora,
                'idCita'     => $cita->idCita,
            ];
        })->sortByDesc('ultimaCita');

        $idsCita = $items->pluck('idCita')->all();

        $resumenes = ResumenCita::whereIn('idCita', $idsCita)
            ->get()
            ->keyBy('idCita');

        return view('medicos.pacientes', [
            'items'     => $items,
            'resumenes' => $resumenes,
        ]);
    }

    /**
     * Detalle de una cita con template de médico.
     */
    public function verCita(CitaPaciente $cita)
    {
        $rutMedico = Auth::user()->rutMedico ?? Auth::user()->rut ?? null;

        if (!$rutMedico || $cita->rutMedico !== $rutMedico) {
            abort(403, 'No puedes ver citas de otros médicos.');
        }

        $cita->load(['paciente.prevision', 'medico.especialidad']);

        return view('medicos.cita-detalle', compact('cita'));
    }
}
