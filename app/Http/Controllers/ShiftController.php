<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::with('employees')->get();
        return view('shifts.index', compact('shifts'));
    }

    public function create()
    {
        return view('shifts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hora_entrada' => 'required|date_format:Y-m-d\TH:i',
            'hora_salida' => 'required|date_format:Y-m-d\TH:i|after:hora_entrada',
            'dias_descanso' => 'nullable|array',
            'dias_descanso.*' => 'string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'
        ]);

        Shift::create($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Turno creado exitosamente.');
    }

    public function show(Shift $shift)
    {
        $shift->load('employees');
        return view('shifts.show', compact('shift'));
    }

    public function edit(Shift $shift)
    {
        return view('shifts.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'hora_entrada' => 'required|date_format:Y-m-d\TH:i',
            'hora_salida' => 'required|date_format:Y-m-d\TH:i|after:hora_entrada',
            'dias_descanso' => 'nullable|array',
            'dias_descanso.*' => 'string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'
        ]);

        $shift->update($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Turno actualizado exitosamente.');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('shifts.index')
            ->with('success', 'Turno eliminado exitosamente.');
    }
}