@extends('layouts.app')
@section('title', 'Sales')

@section('content')
    <div class="flex flex-col justify-start w-full h-screen pt-6">
        <div class="flex justify-between items-center mb-2 py-4 w-[90%] mx-auto">
            <p class="text-3xl font-bold">Ventas</p>
            <a href="{{ route('sales.create') }}" class="bg-green-500 text-white text-sm px-4 py-1 rounded-lg">Nueva +</a>
        </div>
        <div class="bg-white shadow-xl rounded-xl p-4 w-[90%] mx-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Id</th>
                        <th class="px-4 py-2">Vendedor</th>
                        <th class="px-4 py-2">Productos</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Fecha creación</th>
                        <th class="px-4 py-2">Ultima edición</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                @if ($sales->isEmpty())
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center text-amber-500 text-lg py-4">Sin ventas aún.</td>
                        </tr>
                    </tbody>
                @endif
                <tbody>
                    @foreach ($sales as $sale)
                        <tr class="text-center border-b border-gray-200">
                            <td class="px-4 py-2">{{ $sale->id }}</td>
                            <td class="px-4 py-2">{{ $sale->customer->name }}</td>
                            <td class="px-4 py-2">
                                <div id="products-{{ $sale->id }}" class="hidden">
                                    @foreach ($sale->products as $product)
                                        <p>{{ $product->pivot->quantity }} {{ $product->name }} -
                                            ${{ $product->pivot->price }} c/u</p>
                                    @endforeach
                                </div>
                                <button id="toggle-btn-{{ $sale->id }}" onclick="toggleProducts({{ $sale->id }})"
                                    class="text-blue-500">Ver
                                    Productos</button>
                            </td>
                            <td class="px-4 py-2">${{ $sale->total }}</td>
                            <td class="px-4 py-2 flex items-center justify-center gap-2">
                                <span
                                    class="w-2 h-2 rounded-full {{ $sale->is_closed === 0 ? 'bg-red-500' : 'bg-green-500' }}"></span>
                                {{ $sale->is_closed === 0 ? 'Pendiente' : 'Pagada' }}
                            </td>
                            <td class="px-4 py-2">{{ $sale->created_at }}</td>
                            <td class="px-4 py-2">{{ $sale->updated_at }}</td>
                            <td class="px-4 py-2 gap-2 flex justify-center">
                                <a href="{{ route('sales.edit', $sale->id) }}"
                                    class="text-blue-500 hover:text-blue-300 transition-colors p-1"><i
                                        class="fa-solid fa-pencil"></i></a>
                                <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-300 transition-colors p-1"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Función para mostrar y ocultar los productos de cada venta
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
    </script>
@endsection
