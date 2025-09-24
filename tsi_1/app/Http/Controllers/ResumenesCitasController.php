<?php

namespace App\Http\Controllers;

use App\Models\ResumenCita;
use App\Models\CitaPaciente;
use Illuminate\Http\Request;
use App\Http\Requests\ResumenRequest;

class ResumenesCitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resumenes = ResumenCita::with('cita')->get();
        return view('resumenes.index', compact('resumenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $citas = CitaPaciente::all();
        return view('resumenes.create', compact('citas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResumenRequest $request)
    {
        $resumen = new ResumenCita();
        $resumen->idCita = $request->idCita;
        $resumen->diagnostico = $request->diagnostico;
        $resumen->prescripcion = $request->prescripcion;
        $resumen->numReceta = $request->numReceta;
        $resumen->save();

        return redirect()->route('resumenes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ResumenCita $resumen)
    {
        return view('resumenes.show', compact('resumen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResumenCita $resumen)
    {
        $citas = CitaPaciente::all();
        return view('resumenes.edit', compact('resumen','citas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResumenRequest $request, ResumenCita $resumen)
    {
        $resumen->diagnostico = $request->diagnostico;
        $resumen->prescripcion = $request->prescripcion;
        $resumen->numReceta = $request->numReceta;
        $resumen->save();

        return redirect()->route('resumenes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResumenCita $resumen)
    {
        $resumen->delete();
        return redirect()->route('resumenes.index');
    }
}
