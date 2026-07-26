@extends('layouts.app')

@section('title', 'Editar Turno')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Turno</h2>

        <form action="{{ route('shifts.update', $shift) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="hora_entrada" class="block text-sm font-medium text-gray-700">Hora de Entrada</label>
                    <input type="datetime-local" name="hora_entrada" id="hora_entrada" 
                           value="{{ old('hora_entrada', $shift->hora_entrada) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('hora_entrada')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="hora_salida" class="block text-sm font-medium text-gray-700">Hora de Salida</label>
                    <input type="datetime-local" name="hora_salida" id="hora_salida" 
                           value="{{ old('hora_salida', $shift->hora_salida) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('hora_salida')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Días de Descanso</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $dia)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="dias_descanso[]" value="{{ $dia }}"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       {{ in_array($dia, old('dias_descanso', $shift->dias_descanso ?? [])) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">{{ $dia }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('dias_descanso')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <a href="{{ route('shifts.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Actualizar Turno
                </button>
            </div>
        </form>
    </div>
</div>
@endsection