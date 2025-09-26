<?php

namespace App\Http\Controllers;

use App\Models\CitaPaciente;
use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Http\Request;
use App\Http\Requests\CitaRequest;
use App\Models\Prevision;
use App\Models\Especialidad;





class CitasPacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $previsiones = Prevision::all();
        $especialidades = Especialidad::all();

        return view('citas.index', compact('previsiones', 'especialidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
public function create(Request $request)
{
    $pacientes = Paciente::orderBy('nombre')->get();
    $medicos   = Medico::with('especialidad')->orderBy('nombreMedico')->get();

    $rutPaciente = $request->query('rutPaciente', session('rutPacienteSel'));
    $rutMedico   = $request->query('rutMedico', session('rutMedicoSel'));

    return view('citas.create', compact('pacientes', 'medicos', 'rutPaciente', 'rutMedico'));
}

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(CitaPaciente $cita)
    {
        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CitaPaciente $cita)
    {
        $pacientes = Paciente::all();
        $medicos = Medico::all();
        return view('citas.edit', compact('cita','pacientes','medicos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CitaPaciente $cita)
{
    $request->validate([
        'fechaHora'   => 'required|date',
    ]);

    $cita->fechaHora = $request->fechaHora;

    // Si quieres permitir editar el motivo, descomenta:
    // $cita->motivoCita = $request->motivoCita;

    $cita->save();

    return redirect()->route('citas.show', $cita->idCita)
                     ->with('success', 'La cita se actualizó correctamente');
}


    /**
     * Remove the specified resource from storage.
     */
   public function destroy(CitaPaciente $cita, Request $request)
{
    $rut = $cita->rutPaciente;
    $cita->delete();

    $citas = CitaPaciente::with(['medico', 'paciente'])
                ->where('rutPaciente', $rut)
                ->get();

    return view('citas.listar-cancelar', [
    'citas' => $citas,
    'rutPaciente' => $rut
])->with('success', 'La cita fue cancelada correctamente.');
}
    public function buscar(Request $request)
    {

    // Guardamos la selección del paciente
    $codPrevision = $request->codPrevision;
    $idEspecialidad = $request->idEspecialidad;

    // Obtenemos la previsión y especialidad para mostrar en la vista
    $prevision = Prevision::find($codPrevision);
    $especialidad = Especialidad::find($idEspecialidad);

    // Filtramos médicos que pertenezcan a la especialidad seleccionada
    $medicos = Medico::where('idEspecialidad', $idEspecialidad)->get();

    return view('citas.buscar', compact('medicos', 'prevision', 'especialidad'));
    }

    public function registrarPaciente(Request $request)
    {
        $rutMedico = $request->rutMedico;
        $idPrevision = $request->idPrevision;

        $prevision = Prevision::find($idPrevision);
        $medico = Medico::where('rutMedico', $rutMedico)->first();

        return view('citas.registrar-paciente', compact('rutMedico', 'idPrevision', 'prevision', 'medico'));
    }

    public function guardarPaciente(Request $request)
    {
    // (opcional) validación rápida
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

        return view('citas.listar-cancelar', ['citas' => $citas,'rutPaciente' => $rut]);
    }



}