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
    return view('pacientes.index'); // esta vista tendrá las 4 cards
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
    // NO tocar rutPaciente ni fechaNacimiento aquí
    $paciente->nombre       = $request->nombre;
    $paciente->correo       = $request->correo;
    $paciente->telefono     = $request->telefono;
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

    // 🔹 para Detalle
// Ir a “Detalle Paciente”
public function detalle(Request $request)
{
    return $this->listarPacientesPorRut($request, 'detalle');
}

// Ir a “Actualizar Paciente”
public function actualizar(Request $request)
{
    return $this->listarPacientesPorRut($request, 'actualizar');
}

// Ir a “Eliminar Paciente”
public function eliminar(Request $request)
{
    return $this->listarPacientesPorRut($request, 'eliminar');
}

// Método común para las 3 pantallas
protected function listarPacientesPorRut(Request $request, string $modo)
{
    $query = Paciente::with('prevision');

    if ($request->filled('rut')) {
        $query->where('rutPaciente', 'like', '%'.$request->rut.'%');
    }

    $pacientes = $query->orderBy('nombre')->get(); // orden alfabético

    return view('pacientes.listado', [
        'pacientes'  => $pacientes,
        'rutBuscado' => $request->rut,
        'modo'       => $modo,
    ]);
}
    public function guardar(PacienteRequest $request)
    {
        $paciente = new Paciente();
        $paciente->rutPaciente = $request->rutPaciente;
        $paciente->nombre = $request->nombre;
        $paciente->fechaNacimiento = $request->fechaNacimiento;
        $paciente->correo = $request->correo;
        $paciente->telefono = $request->telefono;
        $paciente->codPrevision = $request->codPrevision;
        $paciente->save();

        return redirect()->route('secretaria.index');
    }
}