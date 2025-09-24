<?php

namespace App\Http\Controllers;

use App\Models\CitaPaciente;
use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Http\Request;
use App\Http\Requests\CitaRequest;

class CitasPacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = CitaPaciente::with(['paciente','medico'])->get();
        return view('citas.index', compact('citas'));
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
    public function store(CitaRequest $request)
    {
        $cita = new CitaPaciente();
        $cita->rutPaciente = $request->rutPaciente;
        $cita->rutMedico = $request->rutMedico;
        $cita->fechaHora = $request->fechaHora;
        $cita->motivoCita = $request->motivoCita;
        $cita->save();

        return redirect()->route('citas.index');
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
    public function update(CitaRequest $request, CitaPaciente $cita)
    {
        $cita->rutPaciente = $request->rutPaciente;
        $cita->rutMedico = $request->rutMedico;
        $cita->fechaHora = $request->fechaHora;
        $cita->motivoCita = $request->motivoCita;
        $cita->save();

        return redirect()->route('citas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CitaPaciente $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index');
    }
}
