@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Nuevo Producto</h2>

        <form action="{{ route('inventories.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="producto" class="block text-sm font-medium text-gray-700">Producto</label>
                    <input type="text" name="producto" id="producto" value="{{ old('producto') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('producto')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock_actual" class="block text-sm font-medium text-gray-700">Stock Actual</label>
                    <input type="number" name="stock_actual" id="stock_actual" value="{{ old('stock_actual', 0) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('stock_actual')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock_minimo" class="block text-sm font-medium text-gray-700">Stock Mínimo</label>
                    <input type="number" name="stock_minimo" id="stock_minimo" value="{{ old('stock_minimo', 0) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('stock_minimo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio (Bs)</label>
                    <input type="number" step="0.01" name="precio" id="precio" value="{{ old('precio', 0) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('precio')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('inventories.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Crear Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection