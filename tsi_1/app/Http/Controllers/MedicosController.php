<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use App\Http\Requests\MedicoRequest;

class MedicosController extends Controller
{
    // Menú principal (cards)
    public function index()
    {
        return view('medicos.index');
    }

    // ===== LISTADOS PARA SECRETARIA =====

    // Listado normal (detalle)
    public function detalle()
    {
        $medicos = Medico::select('medicos.*')
            ->leftJoin('especialidades', 'medicos.idEspecialidad', '=', 'especialidades.idEspecialidad')
            ->with('especialidad')
            ->orderBy('especialidades.nombreEspecialidad')
            ->orderBy('medicos.nombreMedico')
            ->get();

        return view('medicos.detalle', compact('medicos'));
    }

    // Listado con botón de actualizar
    public function actualizar()
    {
        $medicos = Medico::select('medicos.*')
            ->leftJoin('especialidades', 'medicos.idEspecialidad', '=', 'especialidades.idEspecialidad')
            ->with('especialidad')
            ->orderBy('especialidades.nombreEspecialidad')
            ->orderBy('medicos.nombreMedico')
            ->get();

        return view('medicos.actualizar', compact('medicos'));
    }

    // Listado con botón de eliminar
    public function eliminar()
    {
        $medicos = Medico::select('medicos.*')
            ->leftJoin('especialidades', 'medicos.idEspecialidad', '=', 'especialidades.idEspecialidad')
            ->with('especialidad')
            ->orderBy('especialidades.nombreEspecialidad')
            ->orderBy('medicos.nombreMedico')
            ->get();

        return view('medicos.eliminar', compact('medicos'));
    }

    // =============== CRUD CLÁSICO =====================

    public function create()
    {
        $especialidades = Especialidad::orderBy('nombreEspecialidad')->get();
        return view('medicos.create', compact('especialidades'));
    }

    public function store(MedicoRequest $request)
    {
        Medico::create([
            'rutMedico'      => $request->rutMedico,
            'nombreMedico'   => $request->nombreMedico,
            'correoMedico'   => $request->correoMedico,
            'telefonoMedico' => $request->telefonoMedico,
            'idEspecialidad' => $request->idEspecialidad,
        ]);

        return redirect()->route('medicos.index');
    }

    public function show(Medico $medico)
    {
        $medico->load('especialidad');
        return view('medicos.show', compact('medico'));
    }

    public function edit(Medico $medico)
    {
        $especialidades = Especialidad::orderBy('nombreEspecialidad')->get();
        return view('medicos.edit', compact('medico', 'especialidades'));
    }

    public function update(MedicoRequest $request, Medico $medico)
    {
        $medico->update([
            'rutMedico'      => $request->rutMedico,
            'nombreMedico'   => $request->nombreMedico,
            'correoMedico'   => $request->correoMedico,
            'telefonoMedico' => $request->telefonoMedico,
            'idEspecialidad' => $request->idEspecialidad,
        ]);

        return redirect()->route('medicos.index');
    }

    public function destroy(Medico $medico)
    {
        $medico->delete();
        return redirect()->route('medicos.index');
    }
}
