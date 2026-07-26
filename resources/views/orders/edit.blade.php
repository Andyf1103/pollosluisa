@extends('layouts.app')

@section('title', 'Editar Pedido')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Pedido #{{ $order->id }}</h2>

        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                    <select name="customer_id" id="customer_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Seleccionar Cliente</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->nombre_completo }} - {{ $customer->ci }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="fecha" id="fecha" value="{{ old('fecha', $order->fecha) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('fecha')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="estado" id="estado" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="pendiente" {{ old('estado', $order->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_preparacion" {{ old('estado', $order->estado) == 'en_preparacion' ? 'selected' : '' }}>En Preparación</option>
                        <option value="listo" {{ old('estado', $order->estado) == 'listo' ? 'selected' : '' }}>Listo</option>
                        <option value="entregado" {{ old('estado', $order->estado) == 'entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelado" {{ old('estado', $order->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('estado')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Actualizar Pedido
                </button>
            </div>
        </form>
    </div>
</div>
@endsection