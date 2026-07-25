<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:customers',
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:customers',
            'telefono' => 'required|string|max:20|unique:customers',
            'fecha_nacimiento' => 'nullable|date'
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Cliente creado correctamente');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
       $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:customers',
            'nombre_completo' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:customers',
            'telefono' => 'required|string|max:20|unique:customers',
            'fecha_nacimiento' => 'nullable|date'
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success', 'Cliente eliminado correctamente');
    }
}