@extends('layouts.app')
@section('title', 'Create Sale')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-xl w-1/2">
            <h2 class="text-xl font-bold mb-4">Create Sale</h2>

            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form action="{{ route('sales.store') }}" method="POST" onsubmit="return validateForm()">
                @csrf

                <!-- Select para el cliente -->
                <div class="mb-4 flex justify-between">
                    <div>
                        <label for="customer" class="block text-gray-700 font-medium">Select Customer:</label>
                        <select id="customer" name="customer_id"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                            <option value="" disabled selected>Select a customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Total de la venta -->
                    <div class="">
                        <label for="total" class="block text-gray-700 font-medium">Total:</label>
                        <input type="text" id="total" class="w-full px-4 py-2 border rounded-lg bg-green-200"
                            value="$0.00" readonly disabled>

                        <!-- Este input oculto es el que se enviará al backend -->
                        <input type="hidden" id="total_hidden" name="total" value="0">
                    </div>

                </div>

                <!-- Mostrar productos en tarjetas -->
                <div class="grid grid-cols-4 gap-4">
                    @foreach ($products as $product)
                        <div class="border p-4 rounded-lg shadow-md">
                            <h4 class="font-bold">{{ $product->name }}</h4>
                            <p class="text-gray-700">Price: ${{ $product->price }}</p>
                            <p class="text-gray-700">Stock: {{ $product->quantity }}</p>

                            <div class="flex items-center mt-2 gap-2">
                                <!-- Checkbox para seleccionar el producto -->
                                <input type="checkbox" name="products[{{ $product->id }}][id]" value="{{ $product->id }}"
                                    id="product_{{ $product->id }}" class="product-checkbox"
                                    data-price="{{ $product->price }}"
                                    onchange="toggleQuantity({{ $product->id }}); updateTotal();">


                                <!-- Input de cantidad (inicialmente deshabilitado) -->
                                <input type="number" name="products[{{ $product->id }}][quantity]"
                                    id="quantity_{{ $product->id }}"
                                    class="w-full px-2 border rounded-lg quantity-input" placeholder="Quantity"
                                    min="1" value="0" disabled onchange="updateTotal();">
                            </div>
                        </div>
                    @endforeach
                </div>



                <!-- Botón para enviar la venta -->
                <div class="flex gap-4 mt-4">
                    <a href="{{ route('sales.index') }}"
                        class="w-full bg-amber-500 text-white px-4 py-2 rounded-lg text-center">Cancel</a>
                    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg">Create Sale</button>
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
                if (quantityInput.value == 0) quantityInput.value = 1; // Establecer valor por defecto
            } else {
                quantityInput.disabled = true;
                quantityInput.value = 0; // Reiniciar cantidad al desmarcar
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
            // Actualizar el input oculto que se enviará
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

        // Ejecutar al cargar la página
        window.addEventListener('DOMContentLoaded', updateTotal);
    </script>
@endsection
