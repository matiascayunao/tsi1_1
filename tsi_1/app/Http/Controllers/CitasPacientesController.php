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
    public function create()
    {
        $pacientes = Paciente::all();
        $medicos = Medico::all();
        return view('citas.create', compact('pacientes','medicos'));
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

    CitaPaciente::create([
        'rutPaciente' => $request->rutPaciente,
        'rutMedico'   => $request->rutMedico,
        'fechaHora'   => $request->fechaHora,
        'motivoCita'  => $request->motivoCita,
    ]);

    return redirect()->route('citas.index')->with('success', 'Cita agendada correctamente');
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
        'rutPaciente' => 'required|string|max:12',
        'rutMedico'   => 'required|string|max:12',
        'fechaHora'   => 'required|date',
        'motivoCita'  => 'required|string|max:255',
    ]);

    $cita->rutPaciente = $request->rutPaciente;
    $cita->rutMedico = $request->rutMedico;
    $cita->fechaHora = $request->fechaHora;
    $cita->motivoCita = $request->motivoCita;
    $cita->save();

    return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CitaPaciente $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index');
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

}

