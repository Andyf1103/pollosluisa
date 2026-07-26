@extends('layouts.app')

@section('title', 'Detalles de la Venta')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detalles de la Venta #{{ $sale->id }}</h2>
            <div>
                <a href="{{ route('sales.edit', $sale) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Editar
                </a>
                <a href="{{ route('sales.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">ID</p>
                <p class="font-semibold">{{ $sale->id }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Pedido</p>
                <p class="font-semibold">#{{ $sale->order_id }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha</p>
                <p class="font-semibold">{{ $sale->fecha ? \Carbon\Carbon::parse($sale->fecha)->format('d/m/Y') : 'No registrada' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Total</p>
                <p class="font-semibold">Bs {{ number_format($sale->total, 2) }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha de Creación</p>
                <p class="font-semibold">{{ $sale->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Última Actualización</p>
                <p class="font-semibold">{{ $sale->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection