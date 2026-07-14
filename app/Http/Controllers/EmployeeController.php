<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('shift')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $shifts = Shift::all();
        return view('employees.create', compact('shifts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:employees',
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees',
            'rol' => ['required', Rule::in(['admin', 'cocinero', 'mesero'])],  
            'shift_id' => 'nullable|exists:shifts,id'
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Empleado creado exitosamente.');
    }

    public function show(Employee $employee)
    {
        $employee->load('shift');
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $shifts = Shift::all();
        return view('employees.edit', compact('employee', 'shifts'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:employees,ci,' . $employee->id,
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees,email,' . $employee->id,
            'rol' => ['required', Rule::in(['admin', 'cocinero', 'mesero'])],  
            'shift_id' => 'nullable|exists:shifts,id'
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')
            ->with('success', 'Empleado eliminado exitosamente.');
    }
}