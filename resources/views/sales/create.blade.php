@extends('layouts.app')

@section('title', 'Crear Venta')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Nueva Venta</h2>

        <form action="{{ route('sales.store') }}" method="POST">
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
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="fecha" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('fecha')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="total" class="block text-sm font-medium text-gray-700">Total (Bs)</label>
                    <input type="number" step="0.01" name="total" id="total" value="{{ old('total', 0) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('total')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('sales.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Crear Venta
                </button>
            </div>
        </form>
    </div>
</div>
@endsection