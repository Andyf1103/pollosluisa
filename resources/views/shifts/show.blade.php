@extends('layouts.app')

@section('title', 'Detalles del Turno')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detalles del Turno</h2>
            <div>
                <a href="{{ route('shifts.edit', $shift) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Editar
                </a>
                <a href="{{ route('shifts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">ID</p>
                <p class="font-semibold">{{ $shift->id }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Hora de Entrada</p>
                <p class="font-semibold">{{ $shift->hora_entrada }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Hora de Salida</p>
                <p class="font-semibold">{{ $shift->hora_salida }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Días de Descanso</p>
                <p class="font-semibold">
                    @if($shift->dias_descanso)
                        {{ implode(', ', $shift->dias_descanso) }}
                    @else
                        <span class="text-gray-500">Sin días de descanso</span>
                    @endif
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Total de Empleados</p>
                <p class="font-semibold">{{ $shift->employees->count() }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha de Creación</p>
                <p class="font-semibold">{{ $shift->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        @if($shift->employees->count() > 0)
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Empleados con este Turno</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CI</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($shift->employees as $employee)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $employee->ci }}</td>
                            <td class="px-6 py-4">{{ $employee->nombre }}</td>
                            <td class="px-6 py-4">{{ $employee->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($employee->role == 'admin') bg-red-100 text-red-800
                                    @elseif($employee->role == 'cocinero') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ $employee->role }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection