@extends('layouts.app')

@section('title', 'Detalles del Pedido')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">🧾 Detalles del Pedido #{{ $order->id }}</h2>
            <div>
                <a href="{{ route('orders.edit', $order) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Editar
                </a>
                <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Cliente</p>
                <p class="font-semibold">{{ $order->customer->nombre_completo ?? 'N/A' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha</p>
                <p class="font-semibold">{{ $order->fecha ? \Carbon\Carbon::parse($order->fecha)->format('d/m/Y') : 'N/A' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Estado</p>
                <p class="font-semibold">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->estado_color }}">
                        {{ $order->estado_nombre }}
                    </span>
                </p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🛒 Productos del Pedido</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->orderDetails as $index => $detail)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $detail->inventario->producto ?? 'Producto no encontrado' }}</td>
                            <td class="px-6 py-4">Bs {{ number_format($detail->inventario->precio ?? 0, 2) }}</td>
                            <td class="px-6 py-4">{{ $detail->cantidad }}</td>
                            <td class="px-6 py-4 font-semibold">Bs {{ number_format($detail->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right font-bold text-gray-800">Total:</td>
                            <td class="px-6 py-4 font-bold text-gray-800">Bs {{ number_format($order->total_orden, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="mt-6 p-4 bg-gray-100 rounded-lg">
            <p class="text-sm text-gray-600">Fecha de Creación: {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p class="text-sm text-gray-600">Última Actualización: {{ $order->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>
@endsection