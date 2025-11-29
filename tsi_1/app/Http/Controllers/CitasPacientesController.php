<?php

namespace App\Http\Controllers;

use App\Models\CitaPaciente;
use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Http\Request;
use App\Http\Requests\CitaRequest;
use App\Models\Prevision;
use App\Models\Especialidad;
use Carbon\Carbon;

class CitasPacientesController extends Controller
{
    public function index()
    {
        $previsiones    = Prevision::all();
        $especialidades = Especialidad::all();

        return view('citas.index', compact('previsiones', 'especialidades'));
    }

    public function create(Request $request)
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::with('especialidad')->orderBy('nombreMedico')->get();

        $rutPaciente = $request->query('rutPaciente', session('rutPacienteSel'));
        $rutMedico   = $request->query('rutMedico', session('rutMedicoSel'));

        return view('citas.create', compact('pacientes', 'medicos', 'rutPaciente', 'rutMedico'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rutPaciente' => 'required|string|max:12',
            'rutMedico'   => 'required|string|max:12',
            'fechaHora'   => 'required|date',
            'motivoCita'  => 'required|string|max:255',
        ]);

        $cita = CitaPaciente::create([
            'rutPaciente' => $request->rutPaciente,
            'rutMedico'   => $request->rutMedico,
            'fechaHora'   => $request->fechaHora,
            'motivoCita'  => $request->motivoCita,
        ]);

        return redirect()->route('citas.show', $cita->idCita)
                         ->with('success', 'Cita agendada correctamente');
    }

    public function show(CitaPaciente $cita)
    {
        return view('citas.show', compact('cita'));
    }

    public function edit(CitaPaciente $cita)
    {
        $pacientes = Paciente::all();
        $medicos   = Medico::all();

        return view('citas.edit', compact('cita', 'pacientes', 'medicos'));
    }

    public function update(Request $request, CitaPaciente $cita)
    {
        $request->validate([
            'fechaHora' => 'required|date',
        ]);

        $cita->fechaHora = $request->fechaHora;
        // $cita->motivoCita = $request->motivoCita;  // si más adelante quieres editar motivo

        $cita->save();

        return redirect()->route('citas.show', $cita->idCita);
    }

    public function destroy(CitaPaciente $cita, Request $request)
    {
        $rut = $cita->rutPaciente;
        $cita->delete();

        $citas = CitaPaciente::with(['medico', 'paciente'])
            ->where('rutPaciente', $rut)
            ->get();

        return view('citas.listar-cancelar', [
            'citas'      => $citas,
            'rutPaciente'=> $rut,
        ]);
    }

    public function buscar(Request $request)
    {
        $codPrevision   = $request->codPrevision;
        $idEspecialidad = $request->idEspecialidad;

        $prevision   = Prevision::find($codPrevision);
        $especialidad= Especialidad::find($idEspecialidad);

        $medicos = Medico::where('idEspecialidad', $idEspecialidad)->get();

        return view('citas.buscar', compact('medicos', 'prevision', 'especialidad'));
    }

    public function registrarPaciente(Request $request)
    {
        $rutMedico   = $request->rutMedico;
        $idPrevision = $request->idPrevision;

        $prevision = Prevision::find($idPrevision);
        $medico    = Medico::where('rutMedico', $rutMedico)->first();

        return view('citas.registrar-paciente', compact('rutMedico', 'idPrevision', 'prevision', 'medico'));
    }

    public function guardarPaciente(Request $request)
    {
        $request->validate([
            'rutPaciente'      => 'required|string|max:12|unique:pacientes,rutPaciente',
            'nombre'           => 'required|string|max:100',
            'fechaNacimiento'  => 'required|date',
            'correo'           => 'required|email',
            'telefono'         => 'required|string|max:15',
            'idPrevision'      => 'required|exists:previsiones,codPrevision',
            'rutMedico'        => 'required|string|max:12',
        ]);

        Paciente::create([
            'rutPaciente'     => $request->rutPaciente,
            'nombre'          => $request->nombre,
            'fechaNacimiento' => $request->fechaNacimiento,
            'correo'          => $request->correo,
            'telefono'        => $request->telefono,
            'codPrevision'    => $request->idPrevision,
        ]);

        return redirect()
            ->route('citas.create', [
                'rutMedico'   => $request->rutMedico,
                'rutPaciente' => $request->rutPaciente,
            ])
            ->with([
                'rutPacienteSel' => $request->rutPaciente,
                'rutMedicoSel'   => $request->rutMedico,
            ]);
    }

    public function buscarPorRut()
    {
        return view('citas.buscar-rut');
    }

    public function mostrarCitaActu(Request $request)
    {
        $rutPaciente = $request->rutPaciente;

        $citas = CitaPaciente::with(['medico', 'paciente'])
            ->where('rutPaciente', $rutPaciente)
            ->get();

        return view('citas.listar-citas', compact('citas', 'rutPaciente'));
    }

    public function cancelarPorRut()
    {
        return view('citas.cancelar-rut');
    }

    public function mostrarCancelar(Request $request)
    {
        $rut = $request->rutPaciente;

        $citas = CitaPaciente::with(['medico', 'paciente'])
            ->where('rutPaciente', $rut)
            ->get();

        return view('citas.listar-cancelar', [
            'citas'      => $citas,
            'rutPaciente'=> $rut,
        ]);
    }

    // ====== LISTADO "TODAS" (por si lo usas) ===================

    public function todas(Request $request)
    {
        $fecha = $request->query('fecha', now()->format('Y-m-d'));
        $rutMedico = $request->query('rutMedico');

        $medicos = Medico::select('medicos.*')
            ->leftJoin('especialidades', 'medicos.idEspecialidad', '=', 'especialidades.idEspecialidad')
            ->with('especialidad')
            ->orderBy('especialidades.nombreEspecialidad')
            ->orderBy('medicos.nombreMedico')
            ->get();

        $query = CitaPaciente::with(['paciente.prevision', 'medico.especialidad'])
            ->whereDate('fechaHora', $fecha);

        if ($rutMedico) {
            $query->where('rutMedico', $rutMedico);
        }

        $citas = $query->orderBy('fechaHora')->get();

        return view('citas.todas', [
            'citas'     => $citas,
            'medicos'   => $medicos,
            'fecha'     => $fecha,
            'rutMedico' => $rutMedico,
        ]);
    }

    // ================= CALENDARIO ===============================

    public function calendario(Request $request)
{
    $hoy = Carbon::today();

    $mes      = (int) $request->query('mes', $hoy->month);
    $anio     = (int) $request->query('anio', $hoy->year);
    $rutMedico= $request->query('rutMedico');

    // Primer día del mes elegido
    $primerDiaMes = Carbon::create($anio, $mes, 1);
    $mesAnterior  = $primerDiaMes->copy()->subMonth();
    $mesSiguiente = $primerDiaMes->copy()->addMonth();

    // Lunes de la primera semana que se muestra
    $inicio = $primerDiaMes->copy()->startOfWeek(Carbon::MONDAY);
    // Domingo de la última semana que se muestra
    $fin    = $primerDiaMes->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

    // Construimos semanas de 7 días
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

    // 👇 AQUÍ LO IMPORTANTE: TODOS los médicos, sin join raros
    $medicos = Medico::with('especialidad')
        ->orderBy('nombreMedico')
        ->get();

    return view('citas.calendario', [
        'semanas'      => $semanas,
        'hoy'          => $hoy,
        'mes'          => $mes,
        'anio'         => $anio,
        'mesAnterior'  => $mesAnterior,
        'mesSiguiente' => $mesSiguiente,
        'medicos'      => $medicos,
        'rutMedico'    => $rutMedico,
    ]);
}

    public function porDia(Request $request)
{
    $fecha = $request->query('fecha'); // formato Y-m-d
    if (!$fecha) {
        abort(404);
    }

    $rutMedico = $request->query('rutMedico');

    // Mismos médicos que en el calendario
    $medicos = Medico::with('especialidad')
        ->orderBy('nombreMedico')
        ->get();

    // Citas para ese día
    $query = CitaPaciente::with(['paciente.prevision', 'medico.especialidad'])
        ->whereDate('fechaHora', $fecha);

    if ($rutMedico) {
        $query->where('rutMedico', $rutMedico);
    }

    // Ordenadas desde la más temprana a la más tarde
    $citas = $query->orderBy('fechaHora')->get();

    return view('citas.dia', [
        'citas'     => $citas,
        'fecha'     => $fecha,
        'medicos'   => $medicos,
        'rutMedico' => $rutMedico,
    ]);
}

}
