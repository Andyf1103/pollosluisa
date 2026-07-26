@extends('layouts.app')

@section('title', 'Detalles del Pedido')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detalles del Pedido #{{ $order->id }}</h2>
            <div>
                <a href="{{ route('orders.edit', $order) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Editar
                </a>
                <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">ID</p>
                <p class="font-semibold">{{ $order->id }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Cliente</p>
                <p class="font-semibold">{{ $order->customer->nombre_completo ?? 'N/A' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">CI del Cliente</p>
                <p class="font-semibold">{{ $order->customer->ci ?? 'N/A' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha</p>
                <p class="font-semibold">{{ $order->fecha ? \Carbon\Carbon::parse($order->fecha)->format('d/m/Y') : 'N/A' }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Estado</p>
                <p class="font-semibold">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($order->estado == 'pendiente') bg-yellow-100 text-yellow-800
                        @elseif($order->estado == 'en_preparacion') bg-blue-100 text-blue-800
                        @elseif($order->estado == 'listo') bg-green-100 text-green-800
                        @elseif($order->estado == 'entregado') bg-purple-100 text-purple-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $order->estado)) }}
                    </span>
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha de Creación</p>
                <p class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection