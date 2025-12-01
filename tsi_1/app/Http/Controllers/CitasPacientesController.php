<?php

namespace App\Http\Controllers;

use App\Models\CitaPaciente;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Prevision;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CitasPacientesController extends Controller
{
    // ===================== FLUJO PÚBLICO: BUSCAR Y RESERVAR =====================

    public function index()
    {
        $previsiones    = Prevision::all();
        $especialidades = Especialidad::all();

        return view('citas.index', compact('previsiones', 'especialidades'));
    }

    /**
     * Paso 3 del flujo público: seleccionar paciente, médico y horario.
     * Si viene con rutPaciente/rutMedico en la query, mostramos la grilla de horas.
     */
    public function create(Request $request)
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::with('especialidad')->orderBy('nombreMedico')->get();

        $rutPaciente = $request->query('rutPaciente', session('rutPacienteSel'));
        $rutMedico   = $request->query('rutMedico', session('rutMedicoSel'));
        $fecha       = $request->query('fecha', Carbon::today()->toDateString());

        $slots    = [];
        $ocupados = [];

        if ($rutMedico) {
            // Generamos la grilla de horarios (08:00–13:00 y 14:30–21:00 cada 20 min)
            $slots = $this->generarSlotsDia($fecha);

            // Horas ya ocupadas por ese médico en ese día
            $ocupados = CitaPaciente::where('rutMedico', $rutMedico)
                ->whereDate('fechaHora', $fecha)
                ->get()
                ->map(function ($cita) {
                    return Carbon::parse($cita->fechaHora)->format('H:i');
                })
                ->toArray();
        }

        return view('citas.create', compact(
            'pacientes',
            'medicos',
            'rutPaciente',
            'rutMedico',
            'fecha',
            'slots',
            'ocupados'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rutPaciente' => 'required|string|max:9|min:8|exists:pacientes,rutPaciente',
            'rutMedico'   => 'required|string|max:9|min:8|exists:medicos,rutMedico',
            'fechaHora'   => 'required|date',
            'motivoCita'  => 'required|string|max:255',

            ], [
            'rutPaciente.exists' => 'El RUT del paciente no existe en el sistema.',
            'rutPaciente.max'    => 'El RUT del paciente no puede tener más de 9 caracteres.',
            'rutPaciente.min'    => 'El RUT del paciente debe tener al menos 8 caracteres.',
            'rutMedico.exists'   => 'El RUT del médico no existe en el sistema.',
            'rutMedico.max'      => 'El RUT del médico no puede tener más de 9 caracteres.',
            'rutMedico.min'      => 'El RUT del médico debe tener al menos 8 caracteres.',

            'rutPaciente.required' => 'El RUT del paciente es obligatorio.',
            'rutMedico.required'   => 'El RUT del médico es obligatorio.',
            'fechaHora.required'   => 'La fecha y hora de la cita son obligatorias.',
            'motivoCita.required'  => 'El motivo de la cita es obligatorio.',

        ]);

        // Verificamos que la hora no esté tomada justo ahora
        $ocupada = CitaPaciente::where('rutMedico', $request->rutMedico)
            ->where('fechaHora', $request->fechaHora)
            ->exists();

        if ($ocupada) {
            return back()
                ->withErrors([
                    'fechaHora' => 'Ese horario ya no está disponible, por favor selecciona otro.',
                ])
                ->withInput();
        }

        $cita = CitaPaciente::create([
            'rutPaciente' => $request->rutPaciente,
            'rutMedico'   => $request->rutMedico,
            'fechaHora'   => $request->fechaHora,
            'motivoCita'  => $request->motivoCita,
        ]);

        // Si viene desde /secretaria/... => volvemos a vistas de secretaría
        if ($request->is('secretaria/*')) {
            return redirect()
                ->route('citas.calendario')
                ->with('success', 'Cita agendada correctamente.');
        }

        // Flujo público (detalle con template.master)
        return redirect()
            ->route('citas.show', $cita->idCita)
            ->with('success', 'Cita agendada correctamente');
    }

    public function show(CitaPaciente $cita)
    {
        return view('citas.show', compact('cita'));
    }

    // ===================== EDITAR CITA (CALENDARIO DE HORAS) =====================

    // FLUJO PÚBLICO (template.master)
    public function edit(Request $request, CitaPaciente $cita)
    {
        // Fecha y hora original de la cita
        $fechaOriginal = Carbon::parse($cita->fechaHora)->toDateString();
        $horaOriginal  = Carbon::parse($cita->fechaHora)->format('H:i');

        // Fecha que se mostrará en la rejilla (puede venir por ?fecha=YYYY-mm-dd)
        $fecha = $request->query('fecha', $fechaOriginal);

        $fechaCarbon  = Carbon::parse($fecha);

        // Día anterior / siguiente SOLO HÁBILES (saltando sábados y domingos)
        $diaAnterior  = $this->siguienteHabil($fechaCarbon->copy(), -1)->toDateString();
        $diaSiguiente = $this->siguienteHabil($fechaCarbon->copy(),  1)->toDateString();

        // Todas las citas del mismo médico en ese día
        $citasDia = CitaPaciente::where('rutMedico', $cita->rutMedico)
            ->whereDate('fechaHora', $fecha)
            ->get();

        // Construimos los bloques de 20 minutos, con estado (libre, ocupado, actual)
        $slots = $this->generarSlotsParaMedico(
            $citasDia,
            $cita,
            $fecha,
            $horaOriginal,
            $fechaOriginal
        );

        // Valor inicial del campo oculto (por defecto, hora original en la fecha que se ve)
        $fechaHoraInicial = $fecha . ' ' . $horaOriginal . ':00';

        return view('citas.edit', compact(
            'cita',
            'fecha',
            'diaAnterior',
            'diaSiguiente',
            'slots',
            'fechaHoraInicial'
        ));
    }

    // FLUJO SECRETARIA (template.secretaria)
    public function editSecretaria(Request $request, CitaPaciente $cita)
    {
        // Fecha y hora original de la cita
        $fechaOriginal = Carbon::parse($cita->fechaHora)->toDateString();
        $horaOriginal  = Carbon::parse($cita->fechaHora)->format('H:i');

        // Fecha que se mostrará en la rejilla (puede venir por ?fecha=YYYY-mm-dd)
        $fecha = $request->query('fecha', $fechaOriginal);

        $fechaCarbon  = Carbon::parse($fecha);

        // Día anterior / siguiente SOLO HÁBILES
        $diaAnterior  = $this->siguienteHabil($fechaCarbon->copy(), -1)->toDateString();
        $diaSiguiente = $this->siguienteHabil($fechaCarbon->copy(),  1)->toDateString();

        // Todas las citas del mismo médico en ese día
        $citasDia = CitaPaciente::where('rutMedico', $cita->rutMedico)
            ->whereDate('fechaHora', $fecha)
            ->get();

        // Bloques de 20 minutos
        $slots = $this->generarSlotsParaMedico(
            $citasDia,
            $cita,
            $fecha,
            $horaOriginal,
            $fechaOriginal
        );

        $fechaHoraInicial = $fecha . ' ' . $horaOriginal . ':00';

        return view('citas.edit-secretaria', compact(
            'cita',
            'fecha',
            'diaAnterior',
            'diaSiguiente',
            'slots',
            'fechaHoraInicial'
        ));
    }

    public function update(Request $request, CitaPaciente $cita)
    {
        $request->validate([
            'fechaHora' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Verificamos que no haya otra cita del mismo médico a la misma hora
        $choque = CitaPaciente::where('rutMedico', $cita->rutMedico)
            ->where('idCita', '!=', $cita->idCita)
            ->where('fechaHora', $request->fechaHora)
            ->exists();

        if ($choque) {
            return back()
                ->withErrors(['fechaHora' => 'La fecha y hora seleccionadas ya están ocupadas para este médico.'])
                ->withInput();
        }

        $cita->fechaHora = $request->fechaHora;
        $cita->save();

        return redirect()
            ->route('citas.show', $cita->idCita)
            ->with('success', 'Cita actualizada correctamente.');
    }

    // UPDATE cuando viene desde la SECRETARIA
    public function updateSecretaria(Request $request, CitaPaciente $cita)
    {
        $request->validate([
            'fechaHora' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Verificamos que no haya otra cita del mismo médico a la misma hora
        $choque = CitaPaciente::where('rutMedico', $cita->rutMedico)
            ->where('idCita', '!=', $cita->idCita)
            ->where('fechaHora', $request->fechaHora)
            ->exists();

        if ($choque) {
            return back()
                ->withErrors(['fechaHora' => 'La fecha y hora seleccionadas ya están ocupadas para este médico.'])
                ->withInput();
        }

        $cita->fechaHora = $request->fechaHora;
        $cita->save();

        // Volvemos al listado del día (pantalla de secretaria)
        $fecha = Carbon::parse($request->fechaHora)->toDateString();

        return redirect()
            ->route('citas.porDia', [
                'fecha'     => $fecha,
                'rutMedico' => $cita->rutMedico,
            ])
            ->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy(CitaPaciente $cita, Request $request)
    {
        $rut = $cita->rutPaciente;
        $cita->delete();

        $citas = CitaPaciente::with(['medico', 'paciente'])
            ->where('rutPaciente', $rut)
            ->get();

        return view('citas.listar-cancelar', [
            'citas'       => $citas,
            'rutPaciente' => $rut,
        ]);
    }

    // ===================== BÚSQUEDA DE MÉDICOS POR PREVISIÓN/ESPECIALIDAD =====================

    public function buscar(Request $request)
    {
        $codPrevision   = $request->codPrevision;
        $idEspecialidad = $request->idEspecialidad;

        $prevision    = Prevision::find($codPrevision);
        $especialidad = Especialidad::find($idEspecialidad);

        $medicos = Medico::where('idEspecialidad', $idEspecialidad)->get();

        return view('citas.buscar', compact('medicos', 'prevision', 'especialidad'));
    }

    // ===================== REGISTRO / USO DE PACIENTE EN FLUJO PÚBLICO =====================

    public function registrarPaciente(Request $request)
    {
        $rutMedico   = $request->rutMedico;
        $idPrevision = $request->idPrevision;

        $prevision = Prevision::find($idPrevision);
        $medico    = Medico::where('rutMedico', $rutMedico)->first();

        return view('citas.registrar-paciente', compact('rutMedico', 'idPrevision', 'prevision', 'medico'));
    }

    /**
     * Guarda un NUEVO paciente (cuadro rojo).
     * - Valida RUT con módulo 11
     * - Fecha de nacimiento entre 1940 y hoy
     */
    public function guardarPaciente(Request $request)
    {
        $request->validate([
            'rutPaciente'      => 'required|string|max:9|min:8|unique:pacientes,rutPaciente',
            'nombre'           => 'required|string|max:100',
            'fechaNacimiento'  => 'required|date|after_or_equal:1940-01-01|before_or_equal:today',
            'correo'           => 'required|email',
            'telefono'         => 'required|string|max:9|min:8|',
            'idPrevision'      => 'required|exists:previsiones,codPrevision',
            'rutMedico'        => 'required|string|max:9|min:8|',

            ], [
            'rutPaciente.unique'     => 'El RUT ingresado ya está registrado.',
            'rutPaciente.max'        => 'El RUT no puede tener más de 9 caracteres.',
            'rutPaciente.min'        => 'El RUT debe tener al menos 8 caracteres.',
            'nombre.required'        => 'El nombre del paciente es obligatorio.',
            'fechaNacimiento.after_or_equal'  => 'La fecha de nacimiento no puede ser anterior a 1940.',
            'fechaNacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser posterior a hoy.',
            'correo.email'           => 'Debes ingresar un correo electrónico válido.',
            'telefono.max'           => 'El teléfono no puede tener más de 9 caracteres.',
            'telefono.min'           => 'El teléfono debe tener al menos 8 caracteres.',
            'rutMedico.max'          => 'El RUT del médico no puede tener más de 9 caracteres.',
            'rutMedico.min'          => 'El RUT del médico debe tener al menos 8 caracteres.',
        ]);

        if (!$this->validarRut($request->rutPaciente)) {
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
            'codPrevision'    => $request->idPrevision,
        ]);

        return redirect()
            ->route('citas.create', [
                'rutMedico'   => $request->rutMedico,
                'rutPaciente' => $request->rutPaciente,
            ])
            ->with([
                'rutPacienteSel' => $request->rutPaciente,
                'rutMedicoSel'   => $request->rutMedico,
            ]);
    }

    /**
     * Cuadro VERDE: usar paciente existente.
     * - Valida RUT
     * - Si existe paciente, se ignora la previsión elegida antes
     *   y se usa la previsión guardada en la BD.
     */
    public function usarPaciente(Request $request)
{
    $request->validate(
        [
            'rutExistente' => 'required|string|max:9|min:8',
            'rutMedico'    => 'required|string|max:9|min:8|exists:medicos,rutMedico',
        ],
        [
            // RUT paciente
            'rutExistente.required' => 'El RUT del paciente es obligatorio.',
            'rutExistente.max'      => 'El RUT del paciente no puede tener más de 9 caracteres.',
            'rutExistente.min'      => 'El RUT del paciente debe tener al menos 8 caracteres.',

            // RUT médico (oculto)
            'rutMedico.required'    => 'Falta el médico seleccionado en el paso anterior.',
            'rutMedico.exists'      => 'El médico seleccionado no existe en el sistema.',
            'rutMedico.max'         => 'El RUT del médico no puede tener más de 9 caracteres.',
            'rutMedico.min'         => 'El RUT del médico debe tener al menos 8 caracteres.',
        ]
    );

    $rut = $request->rutExistente;

    // Validación módulo 11
    if (!$this->validarRut($rut)) {
        return back()
            ->withErrors(['rutExistente' => 'El RUT ingresado no es válido.'])
            ->withInput();
    }

    $paciente = Paciente::where('rutPaciente', $rut)->first();

    if (!$paciente) {
        return back()
            ->withErrors([
                'rutExistente' => 'No se encontró un paciente con ese RUT. Puedes registrarlo en el formulario de la izquierda.',
            ])
            ->withInput();
    }

    // IMPORTANTE: no tocamos su previsión, usamos la que ya tiene
    return redirect()
        ->route('citas.create', [
            'rutMedico'   => $request->rutMedico,
            'rutPaciente' => $paciente->rutPaciente,
        ])
        ->with([
            'rutPacienteSel' => $paciente->rutPaciente,
            'rutMedicoSel'   => $request->rutMedico,
        ]);
}

    // ===================== MODIFICAR / CANCELAR CITA POR RUT =====================

    public function buscarPorRut()
    {
        return view('citas.buscar-rut');
    }

    public function mostrarCitaActu(Request $request)
    {
        $rutPaciente = $request->rutPaciente;

        // Validación de RUT (módulo 11)
        if (!$this->validarRut($rutPaciente)) {
            return back()
                ->withErrors(['rutPaciente' => 'El RUT ingresado no es válido.'])
                ->withInput();
        }

        $citas = CitaPaciente::with(['medico', 'paciente'])
            ->where('rutPaciente', $rutPaciente)
            ->get();

        return view('citas.listar-citas', compact('citas', 'rutPaciente'));
    }

    public function cancelarPorRut()
    {
        return view('citas.cancelar-rut');
    }

    public function mostrarCancelar(Request $request)
    {
        $rut = $request->rutPaciente;

        // Validación de RUT (módulo 11)
        if (!$this->validarRut($rut)) {
            return back()
                ->withErrors(['rutPaciente' => 'El RUT ingresado no es válido.'])
                ->withInput();
        }

        $citas = CitaPaciente::with(['medico', 'paciente'])
            ->where('rutPaciente', $rut)
            ->get();

        return view('citas.listar-cancelar', [
            'citas'       => $citas,
            'rutPaciente' => $rut,
        ]);
    }

    // ====== LISTADO "TODAS" (por si lo usas) ===================

    public function todas(Request $request)
    {
        $fecha     = $request->query('fecha', now()->format('Y-m-d'));
        $rutMedico = $request->query('rutMedico');

        $medicos = Medico::select('medicos.*')
            ->leftJoin('especialidades', 'medicos.idEspecialidad', '=', 'especialidades.idEspecialidad')
            ->with('especialidad')
            ->orderBy('especialidades.nombreEspecialidad')
            ->orderBy('medicos.nombreMedico')
            ->get();

        $query = CitaPaciente::with(['paciente.prevision', 'medico.especialidad'])
            ->whereDate('fechaHora', $fecha);

        if ($rutMedico) {
            $query->where('rutMedico', $rutMedico);
        }

        $citas = $query->orderBy('fechaHora')->get();

        return view('citas.todas', [
            'citas'     => $citas,
            'medicos'   => $medicos,
            'fecha'     => $fecha,
            'rutMedico' => $rutMedico,
        ]);
    }

    // ===================== CALENDARIO (SECRETARIA) ===============================

    public function calendario(Request $request)
    {
        $hoy = Carbon::today();

        $mes       = (int) $request->query('mes', $hoy->month);
        $anio      = (int) $request->query('anio', $hoy->year);
        $rutMedico = $request->query('rutMedico');

        $primerDiaMes = Carbon::create($anio, $mes, 1);
        $mesAnterior  = $primerDiaMes->copy()->subMonth();
        $mesSiguiente = $primerDiaMes->copy()->addMonth();

        // Lunes de la primera semana que se muestra
        $inicio = $primerDiaMes->copy()->startOfWeek(Carbon::MONDAY);
        // Domingo de la última semana que se muestra
        $fin    = $primerDiaMes->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $semanas   = [];
        $diaActual = $inicio->copy();

        while ($diaActual <= $fin) {
            $semana = [];
            for ($i = 0; $i < 7; $i++) {
                $semana[] = $diaActual->copy();
                $diaActual->addDay();
            }
            $semanas[] = $semana;
        }

        $medicos = Medico::with('especialidad')
            ->orderBy('nombreMedico')
            ->get();

        return view('citas.calendario', [
            'semanas'      => $semanas,
            'hoy'          => $hoy,
            'mes'          => $mes,
            'anio'         => $anio,
            'mesAnterior'  => $mesAnterior,
            'mesSiguiente' => $mesSiguiente,
            'medicos'      => $medicos,
            'rutMedico'    => $rutMedico,
        ]);
    }

    public function porDia(Request $request)
    {
        $fecha = $request->query('fecha'); // formato Y-m-d
        if (!$fecha) {
            abort(404);
        }

        $rutMedico = $request->query('rutMedico');

        $medicos = Medico::with('especialidad')
            ->orderBy('nombreMedico')
            ->get();

        $query = CitaPaciente::with(['paciente.prevision', 'medico.especialidad'])
            ->whereDate('fechaHora', $fecha);

        if ($rutMedico) {
            $query->where('rutMedico', $rutMedico);
        }

        $citas = $query->orderBy('fechaHora')->get();

        return view('citas.dia', [
            'citas'     => $citas,
            'fecha'     => $fecha,
            'medicos'   => $medicos,
            'rutMedico' => $rutMedico,
        ]);
    }
    public function storeSecretaria(Request $request)
{
    $request->validate([
        'rutPaciente' => 'required|string|max:9|min:8|exists:pacientes,rutPaciente',
        'rutMedico'   => 'required|string|max:9|min:8|exists:medicos,rutMedico',
        'fechaHora'   => 'required|date',
        'motivoCita'  => 'required|string|max:255',

        ], [
        'rutPaciente.exists' => 'El RUT del paciente no existe en el sistema.',
        'rutPaciente.max'    => 'El RUT del paciente no puede tener más de 9 caracteres.',
        'rutPaciente.min'    => 'El RUT del paciente debe tener al menos 8 caracteres.',
        'rutMedico.exists'   => 'El RUT del médico no existe en el sistema.',
        'rutMedico.max'      => 'El RUT del médico no puede tener más de 9 caracteres.',
        'rutMedico.min'      => 'El RUT del médico debe tener al menos 8 caracteres.',
        'rutPaciente.required' => 'El RUT del paciente es obligatorio.',
        'rutMedico.required'   => 'El RUT del médico es obligatorio.',
        'fechaHora.required'   => 'La fecha y hora de la cita son obligatorias.',
        'motivoCita.required'  => 'El motivo de la cita es obligatorio.',
        
    ]);

    // Verificamos que la hora no esté tomada
    $ocupada = CitaPaciente::where('rutMedico', $request->rutMedico)
        ->where('fechaHora', $request->fechaHora)
        ->exists();

    if ($ocupada) {
        return back()
            ->withErrors([
                'fechaHora' => 'Ese horario ya no está disponible, por favor selecciona otro.',
            ])
            ->withInput();
    }

    $cita = CitaPaciente::create([
        'rutPaciente' => $request->rutPaciente,
        'rutMedico'   => $request->rutMedico,
        'fechaHora'   => $request->fechaHora,
        'motivoCita'  => $request->motivoCita,
    ]);

    return redirect()
        ->route('citas.secretaria.show', $cita->idCita)
        ->with('success', 'Cita agendada correctamente');
}
public function createSecretaria(Request $request)
    {
        $datos = $this->datosCrearCita($request);
        return view('citas.create-secretaria', $datos);
    }
public function showSecretaria(CitaPaciente $cita)
{
    $cita->load(['paciente.prevision', 'medico.especialidad']);

    return view('citas.show-secretaria', compact('cita'));
}

    // ===================== HELPERS DE HORARIOS ===============================

    /**
     * Genera los slots de 20 minutos:
     * - Mañana: 08:00 a 13:00 (último inicio 12:40)
     * - Tarde:  14:30 a 21:00 (último inicio 20:40)
     */
    private function generarSlotsDia(string $fecha): array
    {
        $slots = [];

        // Mañana
        $inicioManiana = Carbon::parse($fecha . ' 08:00');
        $finManiana    = Carbon::parse($fecha . ' 12:40');

        for ($hora = $inicioManiana->copy(); $hora <= $finManiana; $hora->addMinutes(20)) {
            $slots[] = $hora->copy();
        }

        // Tarde (salto de almuerzo 13:00–14:29)
        $inicioTarde = Carbon::parse($fecha . ' 14:30');
        $finTarde    = Carbon::parse($fecha . ' 20:40');

        for ($hora = $inicioTarde->copy(); $hora <= $finTarde; $hora->addMinutes(20)) {
            $slots[] = $hora->copy();
        }

        return $slots;
    }

    /**
     * Genera todos los slots de 20 minutos para un día,
     * marcando libre / ocupado / actual.
     */
    private function generarSlotsParaMedico($citasDia, CitaPaciente $cita, string $fechaVista, string $horaOriginal, string $fechaOriginal): array
    {
        // Citas ocupadas ese día para ese médico
        $ocupadas = [];
        foreach ($citasDia as $c) {
            $hora = Carbon::parse($c->fechaHora)->format('H:i');
            $ocupadas[$hora] = $c->idCita;
        }

        $slots = [];

        // Mañana: 08:00 a 13:00
        $inicioManana = Carbon::parse($fechaVista . ' 08:00');
        $finManana    = Carbon::parse($fechaVista . ' 13:00');

        $slots = array_merge(
            $slots,
            $this->generarBloqueHoras($inicioManana, $finManana, $ocupadas, $cita, $fechaVista, $horaOriginal, $fechaOriginal)
        );

        // Tarde: 14:30 a 21:00
        $inicioTarde = Carbon::parse($fechaVista . ' 14:30');
        $finTarde    = Carbon::parse($fechaVista . ' 21:00');

        $slots = array_merge(
            $slots,
            $this->generarBloqueHoras($inicioTarde, $finTarde, $ocupadas, $cita, $fechaVista, $horaOriginal, $fechaOriginal)
        );

        return $slots;
    }

    /**
     * Genera un bloque de 20 en 20 minutos entre $inicio y $fin.
     */
    private function generarBloqueHoras(
        Carbon $inicio,
        Carbon $fin,
        array $ocupadas,
        CitaPaciente $cita,
        string $fechaVista,
        string $horaOriginal,
        string $fechaOriginal
    ): array {
        $slots = [];

        while ($inicio < $fin) {
            $hora   = $inicio->format('H:i');
            $estado = 'libre';

            // Hora ocupada por otra cita
            if (isset($ocupadas[$hora]) && $ocupadas[$hora] != $cita->idCita) {
                $estado = 'ocupado';
            }

            // Hora actual de ESTA cita (solo en el día original)
            if ($fechaVista === $fechaOriginal && $hora === $horaOriginal) {
                $estado = 'actual';
            }

            $slots[] = [
                'hora'   => $hora,
                'estado' => $estado,
            ];

            $inicio->addMinutes(20);
        }

        return $slots;
    }

    /**
     * Devuelve el siguiente día hábil a partir de $fecha (lunes–viernes).
     * $direccion = 1  -> hacia adelante
     * $direccion = -1 -> hacia atrás
     */
    private function siguienteHabil(Carbon $fecha, int $direccion = 1): Carbon
    {
        do {
            $fecha->addDays($direccion);
        } while ($fecha->isWeekend()); // sábado/domingo

        return $fecha;
    }

    /**
     * Valida un RUT chileno con módulo 11.
     * Acepta formatos con puntos y guión.
     */
    private function validarRut(string $rutCompleto): bool
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

    private function datosCrearCita(Request $request): array
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $medicos   = Medico::with('especialidad')->orderBy('nombreMedico')->get();

        $rutPaciente = $request->query('rutPaciente', session('rutPacienteSel'));
        $rutMedico   = $request->query('rutMedico',   session('rutMedicoSel'));
        $fecha       = $request->query('fecha',       Carbon::today()->toDateString());

        $slots    = [];
        $ocupados = [];

        if ($rutMedico) {
            // Generamos la grilla de horarios (08:00–13:00 y 14:30–21:00 cada 20 min)
            $slots = $this->generarSlotsDia($fecha);

            // Horas ya ocupadas por ese médico en ese día
            $ocupados = CitaPaciente::where('rutMedico', $rutMedico)
                ->whereDate('fechaHora', $fecha)
                ->get()
                ->map(function ($cita) {
                    return Carbon::parse($cita->fechaHora)->format('H:i');
                })
                ->toArray();
        }

        return compact(
            'pacientes',
            'medicos',
            'rutPaciente',
            'rutMedico',
            'fecha',
            'slots',
            'ocupados'
        );
    }

    
}
