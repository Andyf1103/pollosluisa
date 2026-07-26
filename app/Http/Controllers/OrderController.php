<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\OrderDetail;
use App\Models\Sale;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer', 'orderDetails.inventario')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Inventory::all();
        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'fecha' => 'required|date',
            'productos' => 'required|array|min:1',
            'productos.*.inventario_id' => 'required|exists:inventories,id',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        $order = Order::create([
            'customer_id' => $validated['customer_id'],
            'fecha' => $validated['fecha'],
            'estado' => 'pendiente'
        ]);

        foreach ($validated['productos'] as $producto) {
            $inventory = Inventory::find($producto['inventario_id']);
            
            if ($inventory->stock_actual < $producto['cantidad']) {
                return redirect()->back()
                    ->with('error', 'Stock insuficiente para ' . $inventory->producto)
                    ->withInput();
            }

            $subtotal = $inventory->precio * $producto['cantidad'];

            OrderDetail::create([
                'order_id' => $order->id,
                'inventario_id' => $producto['inventario_id'],
                'cantidad' => $producto['cantidad'],
                'subtotal' => $subtotal
            ]);

            $inventory->decrement('stock_actual', $producto['cantidad']);
        }

        return redirect()->route('orders.index')
            ->with('success', 'Pedido creado exitosamente.');
    }

    public function show(Order $order)
    {
        $order->load('customer', 'orderDetails.inventario');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        $products = Inventory::all();
        return view('orders.edit', compact('order', 'customers', 'products'));
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
        foreach ($order->orderDetails as $detail) {
            $inventory = Inventory::find($detail->inventario_id);
            $inventory->increment('stock_actual', $detail->cantidad);
            $detail->delete();
        }

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Pedido eliminado exitosamente.');
    }

    public function cambiarEstado(Request $request, Order $order)
    {
        $estado = $request->input('estado');
        
        $estadosValidos = ['pendiente', 'en_preparacion', 'listo', 'entregado', 'cancelado'];
        
        if (!in_array($estado, $estadosValidos)) {
            return redirect()->back()->with('error', 'Estado no válido');
        }

        $order->update(['estado' => $estado]);

        return redirect()->back()->with('success', 'Pedido actualizado a: ' . Order::ESTADOS[$estado]);
    }

    public function preparar(Order $order)
    {
        $order->update(['estado' => Order::ESTADO_EN_PREPARACION]);
        return redirect()->back()->with('success', 'Pedido en preparación');
    }

    public function listo(Order $order)
    {
        $order->update(['estado' => Order::ESTADO_LISTO]);
        return redirect()->back()->with('success', 'Pedido listo para entregar');
    }

    public function entregar(Order $order)
    {
        $order->update(['estado' => Order::ESTADO_ENTREGADO]);

        $total = $order->orderDetails->sum('subtotal');

        Sale::create([
            'order_id' => $order->id,
            'fecha' => now()->format('Y-m-d'),
            'total' => $total
        ]);

        return redirect()->back()->with('success', 'Pedido entregado al cliente. Venta registrada.');
    }

    public function cancelar(Order $order)
    {
        $order->update(['estado' => Order::ESTADO_CANCELADO]);
        return redirect()->back()->with('success', 'Pedido cancelado');
    }

    public function pendientes()
    {
        $orders = Order::whereIn('estado', ['pendiente', 'en_preparacion'])->get();
        return view('orders.pendientes', compact('orders'));
    }
}