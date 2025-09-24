<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use App\Http\Requests\MedicoRequest;

class MedicosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicos = Medico::with('especialidad')->get();
        return view('medicos.index', compact('medicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidades = Especialidad::all();
        return view('medicos.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicoRequest $request)
    {
        $medico = new Medico();
        $medico->rutMedico = $request->rutMedico;
        $medico->nombreMedico = $request->nombreMedico;
        $medico->correoMedico = $request->correoMedico;
        $medico->telefonoMedico = $request->telefonoMedico;
        $medico->idEspecialidad = $request->idEspecialidad;
        $medico->save();

        return redirect()->route('medicos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medico $medico)
    {
        return view('medicos.show', compact('medico'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medico $medico)
    {
        $especialidades = Especialidad::all();
        return view('medicos.edit', compact('medico', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicoRequest $request, Medico $medico)
    {
        $medico->rutMedico = $request->rutMedico;
        $medico->nombreMedico = $request->nombreMedico;
        $medico->correoMedico = $request->correoMedico;
        $medico->telefonoMedico = $request->telefonoMedico;
        $medico->idEspecialidad = $request->idEspecialidad;
        $medico->save();

        return redirect()->route('medicos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medico $medico)
    {
        $medico->delete();
        return redirect()->route('medicos.index');
    }
}
