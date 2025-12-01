<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Prevision;
use Illuminate\Http\Request;

class PacientesController extends Controller
{
    /**
     * Menú principal (las 4 cards de pacientes)
     */
    public function index()
    {
        return view('pacientes.index');
    }

    /**
     * Formulario de registro de paciente (secretaría)
     */
    public function create()
    {
        $previsiones = Prevision::all();
        return view('pacientes.create', compact('previsiones'));
    }

    /**
     * Guardar paciente desde /pacientes/create (secretaría)
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'rutPaciente'     => 'required|string|max:9|min:8|unique:pacientes,rutPaciente',
                'nombre'          => 'required|string|max:100',
                'fechaNacimiento' => 'required|date|after_or_equal:1940-01-01|before_or_equal:today',
                'correo'          => 'required|email|unique:pacientes,correo',
                'telefono'        => 'required|string|max:9|min:8',
                'codPrevision'    => 'required|exists:previsiones,codPrevision',
            ],
            [
                // RUT
                'rutPaciente.required' => 'El RUT del paciente es obligatorio.',
                'rutPaciente.unique'   => 'El RUT del paciente ya está registrado.',
                'rutPaciente.max'      => 'El RUT del paciente no puede tener más de 9 caracteres.',
                'rutPaciente.min'      => 'El RUT del paciente debe tener al menos 8 caracteres.',


                // Nombre
                'nombre.required'      => 'El nombre del paciente es obligatorio.',

                // Fecha nacimiento
                'fechaNacimiento.required'        => 'La fecha de nacimiento es obligatoria.',
                'fechaNacimiento.after_or_equal'  => 'La fecha de nacimiento debe ser desde 1940 en adelante.',
                'fechaNacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser posterior a hoy.',
                'fechaNacimiento.date'            => 'La fecha de nacimiento no tiene un formato válido.',

                // Correo
                'correo.required' => 'El correo es obligatorio.',
                'correo.email'    => 'Debes ingresar un correo electrónico válido.',
                'correo.unique'   => 'Este correo ya está registrado en otro paciente.',
                

                // Teléfono
                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.max'      => 'El teléfono no puede tener más de 9 caracteres.',
                'telefono.min'      => 'El teléfono debe tener al menos 8 caracteres.',


                // Previsión
                'codPrevision.required' => 'Debes seleccionar una previsión.',
                'codPrevision.exists'   => 'La previsión seleccionada no es válida.',
            ]
        );

        // Validación extra de RUT (módulo 11)
        if (!$this->validarRutChile($request->rutPaciente)) {
            return back()
                ->withErrors(['rutPaciente' => 'El RUT ingresado no es válido.'])
                ->withInput();
        }

        Paciente::create([
            'rutPaciente'     => $request->rutPaciente,
            'nombre'          => $request->nombre,
            'fechaNacimiento' => $request->fechaNacimiento,
            'correo'          => $request->correo,
            'telefono'        => $request->telefono,
            'codPrevision'    => $request->codPrevision,
        ]);

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente registrado correctamente.');
    }

    /**
     * Mostrar un paciente puntual
     */
    public function show(Paciente $paciente)
    {
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Formulario para editar un paciente
     */
    public function edit(Paciente $paciente)
    {
        $previsiones = Prevision::all();
        return view('pacientes.edit', compact('paciente', 'previsiones'));
    }

    /**
     * Actualizar paciente (SOLO nombre, correo, teléfono y previsión)
     * – RUT y fechaNacimiento NO se tocan acá.
     */
    public function update(Request $request, Paciente $paciente)
    {
        $request->validate(
            [
                'nombre'       => 'required|string|max:100',
                'correo'       => 'required|email|unique:pacientes,correo,' . $paciente->correo . ',correo',
                'telefono'     => 'required|string|max:9|min:8',
                'codPrevision' => 'required|exists:previsiones,codPrevision',
            ],
            [
                'nombre.required'       => 'El nombre del paciente es obligatorio.',
                'telefono.max'          => 'El teléfono no puede tener más de 9 caracteres.',
                'telefono.min'          => 'El teléfono debe tener al menos 8 caracteres.',

                'correo.required'       => 'El correo es obligatorio.',
                'correo.email'          => 'Debes ingresar un correo electrónico válido.',
                'correo.unique'         => 'Este correo ya está registrado en otro paciente.',
                'telefono.required'     => 'El teléfono es obligatorio.',
                'codPrevision.required' => 'Debes seleccionar una previsión.',
                'codPrevision.exists'   => 'La previsión seleccionada no es válida.',
            ]
        );

        // Sólo se actualizan estos campos
        $paciente->update([
            'nombre'       => $request->nombre,
            'correo'       => $request->correo,
            'telefono'     => $request->telefono,
            'codPrevision' => $request->codPrevision,
        ]);

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente actualizado correctamente.');
    }

    /**
     * Eliminar paciente
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index');
    }

    // ================== DETALLE / ACTUALIZAR / ELIMINAR (listado por RUT) ==================

    public function detalle(Request $request)
    {
        return $this->listarPacientesPorRut($request, 'detalle');
    }

    public function actualizar(Request $request)
    {
        return $this->listarPacientesPorRut($request, 'actualizar');
    }

    public function eliminar(Request $request)
    {
        return $this->listarPacientesPorRut($request, 'eliminar');
    }

    protected function listarPacientesPorRut(Request $request, string $modo)
    {
        $orden = $request->query('orden', 'nombre'); // 'nombre' o 'fecha'

        $query = Paciente::with('prevision');

        if ($request->filled('rut')) {
            $query->where('rutPaciente', 'like', '%' . $request->rut . '%');
        }

        if ($orden === 'fecha') {
            // orden por fecha de creación (más nuevos primero)
            $query->orderBy('created_at', 'desc');
        } else {
            // orden alfabético por defecto
            $query->orderBy('nombre');
        }

        $pacientes = $query->get();

        return view('pacientes.listado', [
            'pacientes'  => $pacientes,
            'rutBuscado' => $request->rut,
            'modo'       => $modo,
            'orden'      => $orden,
        ]);
    }

    /**
     * Guardar paciente desde el formulario de secretaría
     * que apunta a la ruta POST /pacientes/secretaria
     */
    public function guardar(Request $request)
    {
        $request->validate(
            [
                'rutPaciente'     => 'required|string|max:9|min:8|unique:pacientes,rutPaciente',
                'nombre'          => 'required|string|max:100',
                'fechaNacimiento' => 'required|date|after_or_equal:1940-01-01|before_or_equal:today',
                'correo'          => 'required|email|unique:pacientes,correo',
                'telefono'        => 'required|string|max:9|min:8',
                'codPrevision'    => 'required|exists:previsiones,codPrevision',
            ],
            [
                // RUT
                'rutPaciente.required' => 'El RUT del paciente es obligatorio.',
                'rutPaciente.unique'   => 'El RUT del paciente ya está registrado.',
                'rutPaciente.max'      => 'El RUT del paciente no puede tener más de 9 caracteres.',
                'rutPaciente.min'      => 'El RUT del paciente debe tener al menos 8 caracteres.',

                // Nombre
                'nombre.required'      => 'El nombre del paciente es obligatorio.',
                'nombre.max'           => 'El nombre del paciente no puede tener más de 100 caracteres.',
                'nombre.min'           => 'El nombre del paciente debe tener al menos 2 caracteres.',


                // Fecha nacimiento
                'fechaNacimiento.required'        => 'La fecha de nacimiento es obligatoria.',
                'fechaNacimiento.after_or_equal'  => 'La fecha de nacimiento debe ser desde 1940 en adelante.',
                'fechaNacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser posterior a hoy.',
                'fechaNacimiento.date'            => 'La fecha de nacimiento no tiene un formato válido.',

                // Correo
                'correo.required' => 'El correo es obligatorio.',
                'correo.email'    => 'Debes ingresar un correo electrónico válido.',
                'correo.unique'   => 'Este correo ya está registrado en otro paciente.',

                // Teléfono
                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.max'      => 'El teléfono no puede tener más de 9 caracteres.',
                'telefono.min'      => 'El teléfono debe tener al menos 8 caracteres.',
                

                // Previsión
                'codPrevision.required' => 'Debes seleccionar una previsión.',
                'codPrevision.exists'   => 'La previsión seleccionada no es válida.',
            ]
        );

        // Validar RUT con módulo 11
        if (!$this->validarRutChile($request->rutPaciente)) {
            return back()
                ->withErrors(['rutPaciente' => 'El RUT ingresado no es válido.'])
                ->withInput();
        }

        Paciente::create([
            'rutPaciente'     => $request->rutPaciente,
            'nombre'          => $request->nombre,
            'fechaNacimiento' => $request->fechaNacimiento,
            'correo'          => $request->correo,
            'telefono'        => $request->telefono,
            'codPrevision'    => $request->codPrevision,
        ]);

        // Vuelta al panel de secretaría
        return redirect()
            ->route('secretaria.index')
            ->with('success', 'Paciente registrado correctamente.');
    }

    // ================== Helper: validación de RUT chileno (módulo 11) ==================

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
