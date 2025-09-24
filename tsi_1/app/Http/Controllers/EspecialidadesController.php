<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;
use App\Http\Requests\EspecialidadRequest;

class EspecialidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especialidades = Especialidad::all();
        return view('especialidades.index', compact('especialidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('especialidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EspecialidadRequest $request)
    {
        $especialidad = new Especialidad();
        $especialidad->nombreEspecialidad = $request->nombreEspecialidad;
        $especialidad->save();

        return redirect()->route('especialidades.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Especialidad $especialidad)
    {
        return view('especialidades.show', compact('especialidad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialidad $especialidad)
    {
        return view('especialidades.edit', compact('especialidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EspecialidadRequest $request, Especialidad $especialidad)
    {
        $especialidad->nombreEspecialidad = $request->nombreEspecialidad;
        $especialidad->save();

        return redirect()->route('especialidades.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Especialidad $especialidad)
    {
        $especialidad->delete();
        return redirect()->route('especialidades.index');
    }
}
