@extends('layouts.app')

@section('title', 'Lista de Pedidos')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">📋 Pedidos</h2>
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('mesero'))
                <a href="{{ route('orders.create') }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Nuevo Pedido
                </a>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Productos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-Yellow-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                        <td class="px-6 py-4">{{ $order->customer->nombre_completo ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $order->fecha ? \Carbon\Carbon::parse($order->fecha)->format('d/m/Y') : 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $order->orderDetails->count() }}</td>
                        <td class="px-6 py-4 font-semibold">Bs {{ number_format($order->total_orden, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->estado_color }}">
                                {{ $order->estado_nombre }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-900 mr-2">Ver</a>
                            
                            @if(auth()->user()->hasRole('cocinero'))
                                @if($order->estado == 'pendiente')
                                    <form action="{{ route('orders.preparar', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-900 mr-2">Cocinar</button>
                                    </form>
                                @endif
                                
                                @if($order->estado == 'en_preparacion')
                                    <form action="{{ route('orders.listo', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Listo</button>
                                    </form>
                                @endif
                            @endif
                            
                            @if(auth()->user()->hasRole('mesero'))
                                @if($order->estado == 'listo')
                                    <form action="{{ route('orders.entregar', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Entregar</button>
                                    </form>
                                @endif
                                
                                @if(!in_array($order->estado, ['entregado', 'cancelado']))
                                    <form action="{{ route('orders.cancelar', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900 mr-2" onclick="return confirm('¿Cancelar pedido?')">Cancelar</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No hay pedidos registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection