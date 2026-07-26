@extends('layouts.app')

@section('title', 'Crear Pedido')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">🛒 Nuevo Pedido</h2>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                    <select name="customer_id" id="customer_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Seleccionar Cliente</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
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
                    <input type="date" name="fecha" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('fecha')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Producto</label>
                    <select id="producto-select" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Buscar y seleccionar producto...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-precio="{{ $product->precio }}" data-nombre="{{ $product->producto }}" data-stock="{{ $product->stock_actual }}">
                                {{ $product->producto }} (Stock: {{ $product->stock_actual }}) - Bs {{ number_format($product->precio, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                    <div class="flex gap-2">
                        <input type="number" id="cantidad-producto" value="1" min="1" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <button type="button" id="btn-agregar-carrito" class="mt-1 bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded">
                            +
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🧾 Carrito de Pedido</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="carrito-body" class="bg-white divide-y divide-gray-200">
                            <tr id="carrito-vacio">
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    🛒 El carrito está vacío. Agrega productos.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 p-4 bg-gray-100 rounded-lg flex justify-between items-center">
                <p class="text-xl font-bold text-gray-800">Total: Bs <span id="total-pedido">0.00</span></p>
                <div>
                    <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                        ✅ Confirmar Pedido
                    </button>
                </div>
            </div>

            <div id="productos-inputs"></div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#producto-select').select2({
            placeholder: 'Buscar y seleccionar producto...',
            allowClear: true,
            width: '100%'
        });
    });

    let carrito = [];
    let productoIndex = 0;

    document.getElementById('btn-agregar-carrito').addEventListener('click', agregarAlCarrito);
    document.getElementById('cantidad-producto').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            agregarAlCarrito();
        }
    });

    function agregarAlCarrito() {
        const select = document.getElementById('producto-select');
        const cantidad = parseInt(document.getElementById('cantidad-producto').value) || 1;
        
        if (!select.value) {
            alert('Selecciona un producto');
            return;
        }

        const option = select.options[select.selectedIndex];
        const id = parseInt(select.value);
        const nombre = option.getAttribute('data-nombre');
        const precio = parseFloat(option.getAttribute('data-precio'));
        const stock = parseInt(option.getAttribute('data-stock'));

        if (cantidad > stock) {
            alert('Stock insuficiente. Disponible: ' + stock);
            return;
        }

        const existente = carrito.find(item => item.id === id);
        if (existente) {
            if (existente.cantidad + cantidad > stock) {
                alert('Stock insuficiente. Disponible: ' + stock);
                return;
            }
            existente.cantidad += cantidad;
        } else {
            carrito.push({ id, nombre, precio, cantidad });
        }

        renderCarrito();
        document.getElementById('cantidad-producto').value = 1;
        select.value = '';
        $('#producto-select').trigger('change');
    }

    function eliminarDelCarrito(index) {
        carrito.splice(index, 1);
        renderCarrito();
    }

    function renderCarrito() {
        const tbody = document.getElementById('carrito-body');
        const totalSpan = document.getElementById('total-pedido');
        let total = 0;

        if (carrito.length === 0) {
            tbody.innerHTML = `
                <tr id="carrito-vacio">
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        🛒 El carrito está vacío. Agrega productos.
                    </td>
                </tr>
            `;
            totalSpan.textContent = '0.00';
            document.getElementById('productos-inputs').innerHTML = '';
            return;
        }

        let html = '';
        carrito.forEach((item, index) => {
            const subtotal = item.precio * item.cantidad;
            total += subtotal;
            html += `
                <tr>
                    <td class="px-6 py-4">${item.nombre}</td>
                    <td class="px-6 py-4">Bs ${item.precio.toFixed(2)}</td>
                    <td class="px-6 py-4">${item.cantidad}</td>
                    <td class="px-6 py-4">Bs ${subtotal.toFixed(2)}</td>
                    <td class="px-6 py-4">
                        <button type="button" onclick="eliminarDelCarrito(${index})" class="text-red-600 hover:text-red-900">
                            🗑️ Eliminar
                        </button>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        totalSpan.textContent = total.toFixed(2);

        let inputsHtml = '';
        carrito.forEach((item, index) => {
            inputsHtml += `
                <input type="hidden" name="productos[${index}][inventario_id]" value="${item.id}">
                <input type="hidden" name="productos[${index}][cantidad]" value="${item.cantidad}">
            `;
        });
        document.getElementById('productos-inputs').innerHTML = inputsHtml;
    }
</script>
@endsection