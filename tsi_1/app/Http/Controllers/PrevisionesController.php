<?php

namespace App\Http\Controllers;

use App\Models\Prevision;
use Illuminate\Http\Request;
use App\Http\Requests\PrevisionRequest;

class PrevisionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $previsiones = Prevision::all();
        return view('previsiones.index', compact('previsiones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('previsiones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrevisionRequest $request)
    {
        $prevision = new Prevision();
        $prevision->nombre = $request->nombre;
        $prevision->tipoPrevision = $request->tipoPrevision;
        $prevision->save();

        return redirect()->route('previsiones.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prevision $prevision)
    {
        return view('previsiones.show', compact('prevision'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prevision $prevision)
    {
        return view('previsiones.edit', compact('prevision'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrevisionRequest $request, Prevision $prevision)
    {
        $prevision->nombre = $request->nombre;
        $prevision->tipoPrevision = $request->tipoPrevision;
        $prevision->save();

        return redirect()->route('previsiones.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prevision $prevision)
    {
        $prevision->delete();
        return redirect()->route('previsiones.index');
    }
}
