@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detalles del Producto</h2>
            <div>
                <a href="{{ route('inventories.edit', $inventory) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Editar
                </a>
                <a href="{{ route('inventories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">ID</p>
                <p class="font-semibold">{{ $inventory->id }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Producto</p>
                <p class="font-semibold">{{ $inventory->producto }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Stock Actual</p>
                <p class="font-semibold">{{ $inventory->stock_actual }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Stock Mínimo</p>
                <p class="font-semibold">{{ $inventory->stock_minimo }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Precio</p>
                <p class="font-semibold">Bs {{ number_format($inventory->precio, 2) }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Estado del Stock</p>
                <p class="font-semibold">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $inventory->estado_color }}">
                        {{ ucfirst($inventory->estado_stock) }}
                    </span>
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha de Creación</p>
                <p class="font-semibold">{{ $inventory->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Última Actualización</p>
                <p class="font-semibold">{{ $inventory->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection