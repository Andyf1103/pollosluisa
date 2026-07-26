@extends('layouts.app')

@section('title', 'Crear Detalle de Pedido')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Nuevo Detalle de Pedido</h2>

        <form action="{{ route('order_details.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pedido_id" class="block text-sm font-medium text-gray-700">Pedido</label>
                    <select name="pedido_id" id="pedido_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Seleccionar Pedido</option>
                        @foreach($pedidos as $pedido)
                            <option value="{{ $pedido->id }}" {{ old('pedido_id') == $pedido->id ? 'selected' : '' }}>
                                #{{ $pedido->id }} - {{ $pedido->fecha_pedido }}
                            </option>
                        @endforeach
                    </select>
                    @error('pedido_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="inventario_id" class="block text-sm font-medium text-gray-700">Producto</label>
                    <select name="inventario_id" id="inventario_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Seleccionar Producto</option>
                        @foreach($inventarios as $inventario)
                            <option value="{{ $inventario->id }}" {{ old('inventario_id') == $inventario->id ? 'selected' : '' }}>
                                {{ $inventario->producto }} (Stock: {{ $inventario->stock_actual }})
                            </option>
                        @endforeach
                    </select>
                    @error('inventario_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                    <input type="number" name="cantidad" id="cantidad" value="{{ old('cantidad', 1) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('cantidad')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subtotal" class="block text-sm font-medium text-gray-700">Subtotal (Bs)</label>
                    <input type="number" step="0.01" name="subtotal" id="subtotal" value="{{ old('subtotal', 0) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('subtotal')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('order_details.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Crear Detalle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection