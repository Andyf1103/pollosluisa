<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Inventory;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orderDetails = OrderDetail::with(['pedido', 'inventario'])->get();
        return view('order_details.index', compact('orderDetails'));
    }

    public function create()
    {
        $pedidos = Order::all();
        $inventarios = Inventory::all();
        return view('order_details.create', compact('pedidos', 'inventarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:orders,id',
            'inventario_id' => 'required|exists:inventories,id',
            'cantidad' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0'
        ]);

        OrderDetail::create($validated);

        return redirect()->route('order_details.index')
            ->with('success', 'Detalle de pedido creado exitosamente.');
    }

    public function show(OrderDetail $orderDetail)
    {
        $orderDetail->load(['pedido', 'inventario']);
        return view('order_details.show', compact('orderDetail'));
    }

    public function edit(OrderDetail $orderDetail)
    {
        $pedidos = Order::all();
        $inventarios = Inventory::all();
        return view('order_details.edit', compact('orderDetail', 'pedidos', 'inventarios'));
    }

    public function update(Request $request, OrderDetail $orderDetail)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:orders,id',
            'inventario_id' => 'required|exists:inventories,id',
            'cantidad' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0'
        ]);

        $orderDetail->update($validated);

        return redirect()->route('order_details.index')
            ->with('success', 'Detalle de pedido actualizado exitosamente.');
    }

    public function destroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();
        return redirect()->route('order_details.index')
            ->with('success', 'Detalle de pedido eliminado exitosamente.');
    }
}