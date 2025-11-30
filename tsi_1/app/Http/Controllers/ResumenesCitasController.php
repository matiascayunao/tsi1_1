<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResumenRequest;
use App\Models\CitaPaciente;
use App\Models\Paciente;
use App\Models\ResumenCita;

class ResumenesCitasController extends Controller
{
    // ================== VISTAS GENERALES (por paciente) ==================

    public function index()
    {
        $resumenes = ResumenCita::with('cita')->get();
        return view('resumenes.index', compact('resumenes'));
    }

    public function porPaciente($rutPaciente)
    {
        $paciente = Paciente::findOrFail($rutPaciente);

        $resumenes = ResumenCita::with(['cita.medico'])
            ->whereHas('cita', function ($q) use ($rutPaciente) {
                $q->where('rutPaciente', $rutPaciente);
            })
            ->get();

        return view('resumenes.por-paciente', compact('paciente', 'resumenes'));
    }

    // ================== FLUJO DESDE PANEL DEL MÉDICO ==================

    /**
     * Formulario para crear el resumen de una cita concreta.
     */
    public function createDesdeMedico(CitaPaciente $cita)
    {
        // Si ya existe resumen para esta cita, redirigir a editar
        if (ResumenCita::find($cita->idCita)) {
            return redirect()->route('resumenCitas.edit', $cita->idCita);
        }

        return view('medicos.resumen-create', compact('cita'));
    }

    /**
     * Guarda el resumen médico de una cita.
     */
    public function storeDesdeMedico(ResumenRequest $request, CitaPaciente $cita)
    {
        $resumen = ResumenCita::firstOrNew(['idCita' => $cita->idCita]);

        $resumen->diagnostico  = $request->diagnostico;
        $resumen->prescripcion = $request->prescripcion;
        $resumen->numReceta    = $request->numReceta;
        $resumen->save();

        return redirect()
            ->route('resumenCitas.show', $cita->idCita)
            ->with('success', 'Resumen guardado correctamente.');
    }

    /**
     * Formulario para editar el resumen de una cita.
     */
    public function editDesdeMedico(CitaPaciente $cita)
    {
        $resumen = ResumenCita::findOrFail($cita->idCita);

        return view('medicos.resumen-edit', [
            'cita'    => $cita,
            'resumen' => $resumen,
        ]);
    }

    /**
     * Actualiza un resumen existente.
     */
    public function updateDesdeMedico(ResumenRequest $request, CitaPaciente $cita)
    {
        $resumen = ResumenCita::findOrFail($cita->idCita);

        $resumen->diagnostico  = $request->diagnostico;
        $resumen->prescripcion = $request->prescripcion;
        $resumen->numReceta    = $request->numReceta;
        $resumen->save();

        return redirect()
            ->route('resumenCitas.show', $cita->idCita)
            ->with('success', 'Resumen actualizado correctamente.');
    }

    /**
     * Muestra el resumen con la info completa de la cita.
     */
    public function showDesdeMedico(CitaPaciente $cita)
    {
        $resumen = ResumenCita::with([
                'cita.paciente.prevision',
                'cita.medico.especialidad',
            ])
            ->findOrFail($cita->idCita);

        // 👈 ESTA ES LA VISTA QUE ESTABA FALLANDO
        return view('medicos.resumen-show', compact('resumen'));
    }
}
