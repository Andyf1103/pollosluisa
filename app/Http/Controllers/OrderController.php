<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,en_preparacion,listo,entregado,cancelado'
        ]);

        Order::create($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Pedido creado exitosamente.');
    }

    public function show(Order $order)
    {
        $order->load('customer');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        return view('orders.edit', compact('order', 'customers'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,en_preparacion,listo,entregado,cancelado'
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Pedido actualizado exitosamente.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Pedido eliminado exitosamente.');
    }
}