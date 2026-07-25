<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Order;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('order')->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $pedidos = Order::all();
        return view('sales.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0'
        ]);

        Sale::create($validated);

        return redirect()->route('sales.index')
            ->with('success', 'Venta creada exitosamente.');
    }

    public function show(Sale $sale)
    {
        $sale->load('order');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $pedidos = Order::all();
        return view('sales.edit', compact('sale', 'orders'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0'
        ]);

        $sale->update($validated);

        return redirect()->route('sales.index')
            ->with('success', 'Venta actualizada exitosamente.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')
            ->with('success', 'Venta eliminada exitosamente.');
    }
}