<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Especialidad;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MedicosController extends Controller
{
    // Menú principal (cards)
    public function index()
    {
        return view('medicos.index');
    }

    // ===== LISTADOS PARA SECRETARIA =====

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

    // =============== CRUD =====================

    public function create()
    {
        $especialidades = Especialidad::orderBy('nombreEspecialidad')->get();
        return view('medicos.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        // 1) Validar datos del médico
        $request->validate([
            'rutMedico'      => 'required|string|max:9|min:8|unique:medicos,rutMedico|unique:usuarios,rut',
            'nombreMedico'   => 'required|string|max:100',
            'correoMedico'   => 'nullable|email',
            'telefonoMedico' => 'nullable|string|max:9|min:8|',
            'idEspecialidad' => 'required|exists:especialidades,idEspecialidad',

        ], [
            'rutMedico.required'      => 'El RUT del médico es obligatorio.',
            'rutMedico.unique'        => 'El RUT ingresado ya está registrado.',
            'rutMedico.max'           => 'El RUT no puede tener más de 9 caracteres.',
            'rutMedico.min'           => 'El RUT debe tener al menos 8 caracteres.',
            'nombreMedico.required'   => 'El nombre del médico es obligatorio.',
            
            'correoMedico.email'      => 'Debes ingresar un correo electrónico válido.',
            'idEspecialidad.required' => 'Debes seleccionar una especialidad.', 
            'telefonoMedico.max'      => 'El teléfono no puede tener más de 9 caracteres.',
            'telefonoMedico.min'      => 'El teléfono debe tener al menos 8 caracteres.',
            
            'telefonoMedico.required' => 'El teléfono es obligatorio.',

        ]);

        // 2) Validar RUT con módulo 11
        if (!$this->validarRutChile($request->rutMedico)) {
            return back()
                ->withErrors(['rutMedico' => 'El RUT ingresado no es válido.'])
                ->withInput();
        }

        // 3) Contraseña para el médico: usamos su propio RUT.
        $passwordPlano = $request->rutMedico;

        DB::transaction(function () use ($request, $passwordPlano) {
            // Crear médico
            Medico::create([
                'rutMedico'      => $request->rutMedico,
                'nombreMedico'   => $request->nombreMedico,
                'correoMedico'   => $request->correoMedico,
                'telefonoMedico' => $request->telefonoMedico,
                'idEspecialidad' => $request->idEspecialidad,
            ]);

            // Crear usuario asociado
            Usuario::create([
                'rut'      => $request->rutMedico,          // login con RUT
                'nombre'   => $request->nombreMedico,
                'password' => Hash::make($passwordPlano),   // encriptada
                'rol'      => 'medico',
            ]);
        });

        return redirect()
            ->route('medicos.index')
            ->with(
                'success',
                "Médico creado correctamente. Usuario (RUT): {$request->rutMedico} | Contraseña: {$passwordPlano}"
            );
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

    // ********** AQUÍ ESTÁ EL UPDATE ARREGLADO **********
    public function update(Request $request, Medico $medico)
    {
        // Ya NO tocamos el RUT, sólo otros campos
        $request->validate(
            [
                'nombreMedico'   => 'required|string|max:100',
                'correoMedico'   => 'nullable|email',
                'telefonoMedico' => 'nullable|string|max:9|min:8',
                'idEspecialidad' => 'required|exists:especialidades,idEspecialidad',
            ],
            [
                'nombreMedico.required'   => 'El nombre del médico es obligatorio.',
                'telefonoMedico.max'      => 'El teléfono no puede tener más de 9 caracteres.',
                'telefonoMedico.min'      => 'El teléfono debe tener al menos 8 caracteres.',
                
                'correoMedico.email'      => 'Debes ingresar un correo electrónico válido.',
                'idEspecialidad.required' => 'Debes seleccionar una especialidad.',
            ]
        );

        DB::transaction(function () use ($request, $medico) {
            // Actualizar médico (SIN tocar rutMedico)
            $medico->update([
                'nombreMedico'   => $request->nombreMedico,
                'correoMedico'   => $request->correoMedico,
                'telefonoMedico' => $request->telefonoMedico,
                'idEspecialidad' => $request->idEspecialidad,
            ]);

            // Actualizar nombre del usuario asociado (rut fijo)
            Usuario::where('rut', $medico->rutMedico)->update([
                'nombre' => $request->nombreMedico,
            ]);
        });

        return redirect()
            ->route('medicos.index')
            ->with('success', 'Médico actualizado correctamente.');
    }
    // ***************************************************

    public function destroy(Medico $medico)
    {
        DB::transaction(function () use ($medico) {
            Usuario::where('rut', $medico->rutMedico)->delete();
            $medico->delete();
        });

        return redirect()
            ->route('medicos.index')
            ->with('success', 'Médico eliminado correctamente.');
    }

    // ==================== HELPER RUT =========================

    private function validarRutChile(string $rutCompleto): bool
    {
        // Dejamos solo números y K
        $rut = preg_replace('/[^0-9kK]/', '', $rutCompleto);

        if (strlen($rut) < 2) {
            return false;
        }

        $dv     = strtoupper(substr($rut, -1));
        $numero = substr($rut, 0, -1);

        $suma     = 0;
        $multiplo = 2;

        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $suma += $numero[$i] * $multiplo;
            $multiplo = ($multiplo == 7) ? 2 : $multiplo + 1;
        }

        $resto           = $suma % 11;
        $digitoCalculado = 11 - $resto;

        if ($digitoCalculado == 11) {
            $dvEsperado = '0';
        } elseif ($digitoCalculado == 10) {
            $dvEsperado = 'K';
        } else {
            $dvEsperado = (string) $digitoCalculado;
        }

        return $dvEsperado === $dv;
    }
}
