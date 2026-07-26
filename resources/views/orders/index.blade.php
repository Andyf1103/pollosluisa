@extends('layouts.app')

@section('title', 'Lista de Pedidos')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Pedidos</h2>
            <a href="{{ route('orders.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nuevo Pedido
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                        <td class="px-6 py-4">{{ $order->customer->nombre_completo ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $order->fecha ? \Carbon\Carbon::parse($order->fecha)->format('d/m/Y') : 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                @elseif($order->estado == 'en_preparacion') bg-blue-100 text-blue-800
                                @elseif($order->estado == 'listo') bg-green-100 text-green-800
                                @elseif($order->estado == 'entregado') bg-purple-100 text-purple-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $order->estado)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                            <a href="{{ route('orders.edit', $order) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                            <button type="button" onclick="openModal('{{ route('orders.destroy', $order) }}')" class="text-red-600 hover:text-red-900">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
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