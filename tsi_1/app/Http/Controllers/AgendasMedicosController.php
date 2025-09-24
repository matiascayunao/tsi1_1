<?php

namespace App\Http\Controllers;

use App\Models\AgendaMedico;
use App\Models\Medico;
use Illuminate\Http\Request;
use App\Http\Requests\AgendaRequest;

class AgendasMedicosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendas = AgendaMedico::with('medico')->get();
        return view('agenda.index', compact('agendas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicos = Medico::all();
        return view('agenda.create', compact('medicos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AgendaRequest $request)
    {
        $agenda = new AgendaMedico();
        $agenda->rutMedico = $request->rutMedico;
        $agenda->fecha = $request->fecha;
        $agenda->horaInicio = $request->horaInicio;
        $agenda->horaTermino = $request->horaTermino;
        $agenda->fechaApertura = $request->fechaApertura;
        $agenda->disponibilidad = $request->disponibilidad;
        $agenda->save();

        return redirect()->route('agenda.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(AgendaMedico $agenda)
    {
        return view('agenda.show', compact('agenda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgendaMedico $agenda)
    {
        $medicos = Medico::all();
        return view('agenda.edit', compact('agenda','medicos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AgendaRequest $request, AgendaMedico $agenda)
    {
        $agenda->horaInicio = $request->horaInicio;
        $agenda->horaTermino = $request->horaTermino;
        $agenda->fechaApertura = $request->fechaApertura;
        $agenda->disponibilidad = $request->disponibilidad;
        $agenda->save();

        return redirect()->route('agenda.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgendaMedico $agenda)
    {
        $agenda->delete();
        return redirect()->route('agenda.index');
    }
}
