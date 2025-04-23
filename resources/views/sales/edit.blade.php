@extends('layouts.app')
@section('title', 'Edit Sale')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-xl w-1/2">
            <h2 class="text-xl font-bold mb-4">Editar venta</h2>

            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form action="{{ route('sales.update', $sale->id) }}" method="POST" onsubmit="return validateForm()">
                @csrf
                @method('PUT')

                <!-- Select para clientes -->
                <div class="mb-4 flex justify-between">
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
                            $checked = $included ? 'checked' : '';
                            $quantity = $included ? $included->pivot->quantity : 0;
                        @endphp

                        <div class="border p-4 rounded-lg shadow-md">
                            <h4 class="font-bold">{{ $product->name }}</h4>
                            <p class="text-gray-700">Precio: ${{ $product->price }}</p>
                            <p class="text-gray-700">Stock: {{ $product->quantity }}</p>

                            <div class="flex items-center gap-2 mt-2">
                                <input type="checkbox" name="products[{{ $product->id }}][id]"
                                    value="{{ $product->id }}" id="product_{{ $product->id }}" class="product-checkbox"
                                    data-price="{{ $product->price }}"
                                    onchange="toggleQuantity({{ $product->id }}); updateTotal();" {{ $checked }}>

                                <input type="number" name="products[{{ $product->id }}][quantity]"
                                    id="quantity_{{ $product->id }}" class="w-full px-2 border rounded-lg quantity-input"
                                    placeholder="Quantity" min="1" value="{{ $quantity }}"
                                    {{ $checked ? '' : 'disabled' }} onchange="updateTotal();">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center mt-4 gap-3">

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="is_closed" name="is_closed" value="1" class="sr-only peer"
                            onchange="toggleLabelText()" {{ $sale->is_closed ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 transition-colors">
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
                        class="w-full bg-amber-500 text-white px-4 py-2 rounded-lg text-center">Cancelar</a>
                    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleQuantity(productId) {
            const checkbox = document.getElementById(`product_${productId}`);
            const quantityInput = document.getElementById(`quantity_${productId}`);

            if (checkbox.checked) {
                quantityInput.disabled = false;
                if (quantityInput.value == 0) quantityInput.value = 1;
            } else {
                quantityInput.disabled = true;
                quantityInput.value = 0;
            }

            updateTotal();
        }

        function updateTotal() {
            let total = 0;

            const checkboxes = document.querySelectorAll('.product-checkbox');

            checkboxes.forEach((checkbox) => {
                const productId = checkbox.value;
                const quantityInput = document.getElementById(`quantity_${productId}`);
                const price = parseFloat(checkbox.dataset.price);

                if (checkbox.checked && !isNaN(price)) {
                    const quantity = parseInt(quantityInput.value) || 0;
                    total += price * quantity;
                }
            });

            // Actualizar el input visible
            document.getElementById('total').value = `$ ${total.toFixed(2)}`;
            // Actualizar el input hidden que se envía
            document.getElementById('total_hidden').value = total.toFixed(2);
        }

        function validateForm() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Please select at least one product.');
                return false;
            }
            return true;
        }

        function toggleLabelText() {
            const checkbox = document.getElementById('is_closed');
            const label = document.getElementById('toggleLabel');
            label.textContent = checkbox.checked ? 'Cuenta Pagada' : 'Cuenta Pendiente';
        }
    </script>
@endsection
