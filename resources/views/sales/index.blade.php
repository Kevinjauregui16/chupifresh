@extends('layouts.app')
@section('title', 'PanelFresh - Ventas')

@section('content')
    <div class="flex flex-col justify-start w-full h-screen pt-6">
        <div class="flex justify-between items-center mb-2 py-4 w-[90%] mx-auto">
            <p class="text-3xl font-bold text-gray-500">Listado de Ventas</p>
            <div>
                <button type="button" id="openModalBtn"
                    class="bg-primary text-sm text-white font-bold px-4 py-1 rounded-lg transition-opacity"
                    style="opacity: 0.4;" disabled>
                    Crear cuenta
                </button>

                <a href="{{ route('sales.create') }}" class="bg-utils text-white font-bold text-sm px-4 py-1 rounded-lg">Nueva
                    +</a>
            </div>
        </div>
        <div class="bg-white shadow-xl rounded-xl p-4 w-[90%] mx-auto">
            <form id="salesForm">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-500">
                            <th class="px-4 py-2">Seleccionar</th>
                            <th class="px-4 py-2">Id</th>
                            <th class="px-4 py-2">Vendedor</th>
                            <th class="px-4 py-2">Productos</th>
                            <th class="px-4 py-2">Unidades</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2">Estado</th>
                            <th class="px-4 py-2">Creación</th>
                            <th class="px-4 py-2">Edición</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    @if ($sales->isEmpty())
                        <tbody>
                            <tr>
                                <td colspan="10" class="text-center text-amber-500 text-lg py-4">Sin ventas aún.</td>
                            </tr>
                        </tbody>
                    @endif
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr class="text-center border-b border-gray-200">
                                <td class="px-4 py-2">
                                    <input type="checkbox" class="sale-checkbox" value="{{ $sale->id }}"
                                        data-units="{{ $sale->units }}" data-total="{{ $sale->total }}"
                                        data-info="ventaID: {{ $sale->id }} - {{ $sale->customer->name }} - {{ $sale->units }} unidades - ${{ number_format($sale->total, 2) }}">
                                </td>
                                <td class="px-4 py-2">{{ $sale->id }}</td>
                                <td class="px-4 py-2">{{ $sale->customer->name }}</td>
                                <td class="px-4 py-2">
                                    <div id="products-{{ $sale->id }}" class="hidden">
                                        @foreach ($sale->products as $product)
                                            <p class="border-y py-1 px-2 bg-yellow-50">{{ $product->pivot->quantity }}
                                                {{ $product->name }}</p>
                                        @endforeach
                                    </div>
                                    <button id="toggle-btn-{{ $sale->id }}" type="button"
                                        onclick="toggleProducts({{ $sale->id }})" class="text-primary text-xs">Ver
                                        Productos</button>
                                </td>
                                <td class="px-4 py-2">{{ $sale->units }}</td>
                                <td class="px-4 py-2">${{ number_format($sale->total, 2, '.', ',') }}</td>
                                <td class="px-4 py-2 flex items-center justify-center gap-2">
                                    <span
                                        class="w-2 h-2 rounded-full {{ $sale->is_closed === 0 ? 'bg-secondary' : 'bg-primary' }}"></span>
                                    {{ $sale->is_closed === 0 ? 'Pendiente' : 'Pagada' }}
                                </td>
                                <td class="px-4 py-2 text-gray-400 text-xs">{{ $sale->created_at }}</td>
                                <td class="px-4 py-2 text-gray-400 text-xs">{{ $sale->updated_at }}</td>
                                <td class="px-4 py-2 gap-2 flex justify-center">
                                    <a href="{{ route('sales.edit', $sale->id) }}"
                                        class="text-primary hover:text-blue-400 transition-colors p-1"><i
                                            class="fa-solid fa-pencil"></i></a>
                                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-secondary hover:text-red-400 transition-colors p-1"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 w-full max-w-lg shadow-xl">
            <h2 class="text-xl text-gray-600 font-bold mb-4">Crear cuenta</h2>
            <form id="accountForm" action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input type="text" name="description" id="description" class="border rounded-lg p-2 w-full"
                        placeholder="Descripción de la cuenta" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Resumen de ventas seleccionadas:</label>
                    <ul id="salesSummary" class="list-disc pl-5 text-gray-600"></ul>
                    <div class="mt-2">
                        Total:
                        <span id="totalUnits" class="text-utils text-lg font-semibold"></span> unidades = <span
                            id="totalAmount" class="text-utils text-lg font-semibold"></span> pesos
                    </div>
                </div>
                <div id="selectedSalesInputs"></div>
                <div class="flex justify-center gap-2">
                    <button type="button" id="closeModalBtn"
                        class="w-1/2 bg-secondary text-white px-4 py-2 rounded-lg text-center">Cancelar</button>
                    <button type="submit" class="w-1/2 bg-primary text-white px-4 py-2 rounded-lg">Crear cuenta</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Mostrar y ocultar productos
        function toggleProducts(saleId) {
            const productList = document.getElementById(`products-${saleId}`);
            const button = document.getElementById(`toggle-btn-${saleId}`);
            if (productList.classList.contains('hidden')) {
                productList.classList.remove('hidden');
                button.textContent = 'Ocultar Productos';
            } else {
                productList.classList.add('hidden');
                button.textContent = 'Ver Productos';
            }
        }

        // Modal y selección de ventas
        const checkboxes = document.querySelectorAll('.sale-checkbox');
        const openModalBtn = document.getElementById('openModalBtn');
        const modal = document.getElementById('modal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const salesSummary = document.getElementById('salesSummary');
        const totalUnits = document.getElementById('totalUnits');
        const totalAmount = document.getElementById('totalAmount');
        const selectedSalesInputs = document.getElementById('selectedSalesInputs');

        function updateButtonState() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            openModalBtn.disabled = !anyChecked;
            openModalBtn.style.opacity = anyChecked ? '1' : '0.4';
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateButtonState);
        });

        openModalBtn.addEventListener('click', () => {
            // Limpiar resumen
            salesSummary.innerHTML = '';
            selectedSalesInputs.innerHTML = '';
            let units = 0;
            let total = 0;
            // Agregar ventas seleccionadas al resumen y como inputs ocultos
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const info = cb.getAttribute('data-info');
                    const saleId = cb.value;
                    const saleUnits = parseInt(cb.getAttribute('data-units'));
                    const saleTotal = parseFloat(cb.getAttribute('data-total'));
                    units += saleUnits;
                    total += saleTotal;
                    salesSummary.innerHTML += `<li>${info}</li>`;
                    selectedSalesInputs.innerHTML +=
                        `<input type="hidden" name="sale_ids[]" value="${saleId}">`;
                }
            });
            totalUnits.textContent = units;
            totalAmount.textContent = `$${total.toFixed(2)}`;
            modal.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    </script>
@endsection
