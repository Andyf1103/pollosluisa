@extends('layouts.app')

@section('title', 'Pedidos Pendientes - Cocina')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">👨‍🍳 Pedidos Pendientes</h2>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-yellow-600 mb-4">🟡 Pendientes</h3>
                @foreach($orders->where('estado', 'pendiente') as $order)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold">Pedido #{{ $order->id }}</p>
                            <p class="text-sm text-gray-600">Cliente: {{ $order->customer->nombre_completo ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600">Total: Bs {{ number_format($order->total_orden, 2) }}</p>
                        </div>
                        <form action="{{ route('orders.preparar', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                Cocinar
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
                @if($orders->where('estado', 'pendiente')->count() == 0)
                    <p class="text-gray-500">No hay pedidos pendientes</p>
                @endif
            </div>

            <div>
                <h3 class="text-lg font-semibold text-blue-600 mb-4">🔵 En Preparación</h3>
                @foreach($orders->where('estado', 'en_preparacion') as $order)
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 rounded">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold">Pedido #{{ $order->id }}</p>
                            <p class="text-sm text-gray-600">Cliente: {{ $order->customer->nombre_completo ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600">Total: Bs {{ number_format($order->total_orden, 2) }}</p>
                        </div>
                        <form action="{{ route('orders.listo', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                Listo
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
                @if($orders->where('estado', 'en_preparacion')->count() == 0)
                    <p class="text-gray-500">No hay pedidos en preparación</p>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-4">📋 Pedidos Completados</h3>
            @foreach($orders->whereIn('estado', ['listo', 'entregado', 'cancelado']) as $order)
            <div class="bg-gray-50 p-3 mb-2 rounded flex justify-between items-center">
                <div>
                    <span class="font-bold">Pedido #{{ $order->id }}</span>
                    <span class="text-sm text-gray-600 ml-2">{{ $order->customer->nombre_completo ?? 'N/A' }}</span>
                </div>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->estado_color }}">
                    {{ $order->estado_nombre }}
                </span>
            </div>
            @endforeach
            @if($orders->whereIn('estado', ['listo', 'entregado', 'cancelado'])->count() == 0)
                <p class="text-gray-500">No hay pedidos completados</p>
            @endif
        </div>
    </div>
</div>
@endsection