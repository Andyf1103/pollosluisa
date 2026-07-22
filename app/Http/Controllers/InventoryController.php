<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        return view('inventories.index', compact('inventories'));
    }

    public function create()
    {
        return view('inventories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'producto' => 'required|string|max:100',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0'
        ]);

        Inventory::create($validated);

        return redirect()->route('inventories.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function show(Inventory $inventory)
    {
        return view('inventories.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        return view('inventories.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'producto' => 'required|string|max:100',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0'
        ]);

        $inventory->update($validated);

        return redirect()->route('inventories.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventories.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}