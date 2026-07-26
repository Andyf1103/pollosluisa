@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detalles del Empleado</h2>
            <div>
                <a href="{{ route('employees.edit', $employee) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Editar
                </a>
                <a href="{{ route('employees.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">CI</p>
                <p class="font-semibold">{{ $employee->ci }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Nombre Completo</p>
                <p class="font-semibold">{{ $employee->nombre }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Correo</p>
                <p class="font-semibold">{{ $employee->email }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Rol</p>
                <p class="font-semibold">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($employee->rol == 'admin') bg-red-100 text-red-800
                        @elseif($employee->rol == 'cocinero') bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800 @endif">
                        {{ $employee->rol }}
                    </span>
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Turno</p>
                @if($employee->shift)
                    <p class="font-semibold">
                        {{ $employee->shift->hora_entrada }} - {{ $employee->shift->hora_salida }}
                        <br>
                        <span class="text-sm text-gray-600">Descanso: {{ implode(', ', $employee->shift->dias_descanso ?? []) }}</span>
                    </p>
                @else
                    <p class="font-semibold text-gray-500">Sin turno asignado</p>
                @endif
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha de Creación</p>
                <p class="font-semibold">{{ $employee->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection