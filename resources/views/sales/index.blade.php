@extends('layouts.app')

@section('title', 'Lista de Ventas')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Ventas</h2>
            <a href="{{ route('sales.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nueva Venta
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pedido</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sales as $sale)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $sale->id }}</td>
                        <td class="px-6 py-4">#{{ $sale->pedido_id }}</td>
                        <td class="px-6 py-4">{{ $sale->fecha ? \Carbon\Carbon::parse($sale->fecha)->format('d/m/Y') : 'N/A' }}</td>
                        <td class="px-6 py-4">Bs {{ number_format($sale->total, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('sales.show', $sale) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                            <a href="{{ route('sales.edit', $sale) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                            <button type="button" onclick="openModal('{{ route('sales.destroy', $sale) }}')" class="text-red-600 hover:text-red-900">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No hay ventas registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection