@extends('layouts.app')
@section('title', 'Edit Sale')

@section('content')
    <div class="flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-xl w-1/2">
            <h2 class="text-xl text-gray-600 font-bold mb-4">Editar venta</h2>
            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form action="{{ route('sales.update', $sale->id) }}" method="POST" onsubmit="return validateForm()">
                @csrf
                @method('PUT')

                <!-- Select para clientes -->
                <div class="mb-4 flex justify-between gap-2">
                    <div>
                        <label for="customer" class="block text-gray-700 font-medium">Vendedor:</label>
                        <select id="customer" name="customer_id"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                            <option value="" disabled>Selecciona un vendedor</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ $customer->id === $sale->customer_id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="total" class="block text-gray-700 font-medium">Unidades:</label>
                        <input type="text" id="units" class="w-full px-4 py-2 border rounded-lg bg-green-200"
                            value="{{ $sale->units }}" readonly disabled>
                    </div>
                    <div>
                        <label for="total" class="block text-gray-700 font-medium">Total:</label>
                        <input type="text" id="total" class="w-full px-4 py-2 border rounded-lg bg-green-200"
                            value="${{ $sale->total }}" readonly disabled>

                        <!-- Este input oculto es el que se enviará al backend -->
                        <input type="hidden" id="total_hidden" name="total" value="{{ $sale->total }}">

                        @error('total')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Mostrar todos los productos -->
                <div class="grid grid-cols-4 gap-4">
                    @foreach ($products as $product)
                        @php
                            $included = $sale->products->firstWhere('id', $product->id);
                            $quantity = $included ? $included->pivot->quantity : 0;
                            $stockDisponible = $product->quantity + $quantity;
                        @endphp

                        <div class="border p-4 rounded-lg shadow-md cursor-pointer group relative hover:bg-gray-100 transition-colors flex flex-col justify-center items-center"
                            style="user-select: none;"
                            onclick="incrementQuantity({{ $product->id }}, {{ $stockDisponible }})">
                            <h4 class="font-bold text-gray-600 text-center">{{ $product->name }}</h4>
                            <p class="text-gray-700 text-center">Precio: ${{ $product->price }}</p>
                            <p class="text-gray-700">Stock: <span class="font-bold">{{ $stockDisponible }}</span></p>

                            @if ($stockDisponible <= 0)
                                <p class="text-red-500 mt-1">Sin stock</p>
                            @endif

                            <div class="flex items-center mt-2 gap-2">
                                <button type="button"
                                    class="bg-secondary text-white rounded-xl w-9 h-7 flex items-center justify-center text-lg font-bold"
                                    onclick="event.stopPropagation(); decrementQuantity({{ $product->id }});">-</button>
                                <span id="quantity_display_{{ $product->id }}"
                                    class="text-xl font-semibold">{{ $quantity }}</span>
                                <input type="hidden" name="products[{{ $product->id }}][quantity]"
                                    id="quantity_{{ $product->id }}" value="{{ $quantity }}">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center mt-4 gap-3">

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="is_closed" name="is_closed" value="1" class="sr-only peer"
                            onchange="toggleLabelText()" {{ $sale->is_closed ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-primary transition-colors">
                        </div>
                        <div
                            class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-transform">
                        </div>
                    </label>
                    <span id="toggleLabel" class="text-gray-700 font-medium">Cuenta Pendiente</span>
                </div>

                <!-- Botones -->
                <div class="flex gap-4 mt-4">
                    <a href="{{ route('sales.index') }}"
                        class="w-full bg-secondary text-white px-4 py-2 rounded-lg text-center">Cancelar</a>
                    <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-lg">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function incrementQuantity(productId, maxStock) {
            const quantityInput = document.getElementById(`quantity_${productId}`);
            let current = parseInt(quantityInput.value) || 0;
            if (current < maxStock) {
                quantityInput.value = current + 1;
                document.getElementById(`quantity_display_${productId}`).textContent = quantityInput.value;
                updateTotal();
            }
        }

        function decrementQuantity(productId) {
            const quantityInput = document.getElementById(`quantity_${productId}`);
            let current = parseInt(quantityInput.value) || 0;
            if (current > 0) {
                quantityInput.value = current - 1;
                document.getElementById(`quantity_display_${productId}`).textContent = quantityInput.value;
                updateTotal();
            }
        }

        function updateTotal() {
            let total = 0;
            let units = 0;
            @foreach ($products as $product)
                const price{{ $product->id }} = {{ $product->price }};
                const quantity{{ $product->id }} = parseInt(document.getElementById('quantity_{{ $product->id }}')
                    .value) || 0;
                if (quantity{{ $product->id }} > 0) {
                    total += price{{ $product->id }} * quantity{{ $product->id }};
                    units += quantity{{ $product->id }};
                }
            @endforeach
            document.getElementById('total').value = `$ ${total.toFixed(2)}`;
            document.getElementById('total_hidden').value = total.toFixed(2);
            document.getElementById('units').value = units;
        }

        function validateForm() {
            let valid = false;
            @foreach ($products as $product)
                if (parseInt(document.getElementById('quantity_{{ $product->id }}').value) > 0) {
                    valid = true;
                }
            @endforeach
            if (!valid) {
                alert('Debes seleccionar al menos un producto con cantidad mayor a 0.');
                return false;
            }
            return true;
        }

        function toggleLabelText() {
            const checkbox = document.getElementById('is_closed');
            const label = document.getElementById('toggleLabel');
            label.textContent = checkbox.checked ? 'Cuenta Pagada' : 'Cuenta Pendiente';
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleLabelText();
        });
    </script>
@endsection
