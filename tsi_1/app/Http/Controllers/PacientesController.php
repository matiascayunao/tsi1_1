<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Prevision;
use Illuminate\Http\Request;
use App\Http\Requests\PacienteRequest;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::with('prevision')->get();
        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $previsiones = Prevision::all();
        return view('pacientes.create', compact('previsiones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PacienteRequest $request)
    {
        $paciente = new Paciente();
        $paciente->rutPaciente = $request->rutPaciente;
        $paciente->nombre = $request->nombre;
        $paciente->fechaNacimiento = $request->fechaNacimiento;
        $paciente->correo = $request->correo;
        $paciente->telefono = $request->telefono;
        $paciente->codPrevision = $request->codPrevision;
        $paciente->save();

        return redirect()->route('pacientes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paciente $paciente)
    {
        $previsiones = Prevision::all();
        return view('pacientes.edit', compact('paciente', 'previsiones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PacienteRequest $request, Paciente $paciente)
    {
        $paciente->rutPaciente = $request->rutPaciente;
        $paciente->nombre = $request->nombre;
        $paciente->fechaNacimiento = $request->fechaNacimiento;
        $paciente->correo = $request->correo;
        $paciente->telefono = $request->telefono;
        $paciente->codPrevision = $request->codPrevision;
        $paciente->save();

        return redirect()->route('pacientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index');
    }
}