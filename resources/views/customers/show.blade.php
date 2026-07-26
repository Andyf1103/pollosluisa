@extends('layouts.app')

@section('title', 'Detalles del Cliente')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detalles del Cliente</h2>
            <div>
                <a href="{{ route('customers.edit', $customer) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Editar
                </a>
                <a href="{{ route('customers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">ID</p>
                <p class="font-semibold">{{ $customer->id }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">CI</p>
                <p class="font-semibold">{{ $customer->ci }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Nombre Completo</p>
                <p class="font-semibold">{{ $customer->nombre_completo }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Email</p>
                <p class="font-semibold">{{ $customer->email }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Teléfono</p>
                <p class="font-semibold">{{ $customer->telefono }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha de Nacimiento</p>
                <p class="font-semibold">{{ $customer->fecha_nacimiento ? \Carbon\Carbon::parse($customer->fecha_nacimiento)->format('d/m/Y') : 'No registrada' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha de Creación</p>
                <p class="font-semibold">{{ $customer->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Última Actualización</p>
                <p class="font-semibold">{{ $customer->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection