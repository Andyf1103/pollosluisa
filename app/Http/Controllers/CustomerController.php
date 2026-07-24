<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:customers',
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:customers',
            'telefono' => 'required|string|max:20|unique:customers',
            'fecha_nacimiento' => 'nullable|date_format:Y-m-d'
            
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Cliente creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:customers',
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:customers',
            'telefono' => 'required|string|max:20|unique:customers',
            'fecha_nacimiento' => 'nullable|date_format:Y-m-d'
            
        ]);

        $shift->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Cliente actualizdo exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('succes', 'Cliente eliminado correctamente');
    }
}
