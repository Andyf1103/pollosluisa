<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = Shift:: width('employees')->get();
        return view('shifts.index', compact ('shifts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
        {
        $validated = $request->validate([
            'hora_entrada' => 'required|date_format:Y-m-d H:i:s',
            'hora_salida' => 'required|date_format:Y-m-d H:i:s|after:hora_entrada',
            'dias_descanso' => 'nullable|array',
            'dias_descanso.*' => 'string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'
        ]);

        Shift::create($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Turno creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shift -> load('employees');
        return view('shifts.show', compact('shift'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validated([
            'hora_entrada' => 'required | date_format: Y-m-d H:i:s',
            'hora_salida' => 'required|date_format:Y-m-d H:i:s|after:hora_entrada',
            'dias_descanso' => 'nullable|array',
            'dias_descanso.*' => 'string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'
        ]);

        
        $shift->update($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Turno actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shift->delete();
        return redirect()->route('shifts.index')
            ->with('success', 'Turno eliminado exitosamente.');
    }
}
