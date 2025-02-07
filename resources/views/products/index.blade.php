<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="max-w-7xl mx-auto p-6 mt-5 bg-white shadow-xl rounded-2xl">
        <h1 class="mb-6 text-3xl font-bold text-center text-gray-600">Stock de Productos</h1>

        <!-- Botón para crear un nuevo post -->
        <div class="mb-4 text-right">
            <a href="{{ route('products.create') }}" class="text-green-500 hover:text-green-300">
                Nuevo Producto</a>
        </div>

        <!-- Verificar si hay posts -->
        @if ($products->isEmpty())
            <p class="text-center text-lg text-gray-600">No hay posts disponibles.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md border-collapse">
                    <thead class="bg-gray-200">
                        <tr>
                            {{-- <th class="py-2 px-4 border-b text-left text-gray-700">ID</th> --}}
                            <th class="py-2 px-4 border-b text-left text-gray-700">Producto</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Ingredientes</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Costo de produccion</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Precio de venta</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Stock</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Fecha de Creación</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Fecha de Edición</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50">
                                {{-- <td class="py-2 px-4 border-b text-gray-600">{{ $product->id }}</td> --}}
                                <td class="py-2 px-4 border-b text-gray-600">{{ $product->product_name }}</td>
                                <td class="py-2 px-4 border-b text-gray-600">{{ $product->ingredients }}</td>
                                <td class="py-2 px-4 border-b text-gray-600">{{ $product->production_cost }}</td>
                                <td class="py-2 px-4 border-b text-gray-600">{{ $product->sale_price }}</td>
                                <td class="py-2 px-4 border-b text-gray-600">{{ $product->stock }}</td>
                                <td class="py-2 px-4 border-b text-gray-600">
                                    {{ $product->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-2 px-4 border-b text-gray-600">
                                    {{ $product->updated_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <!-- Botón de Editar -->
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="text-blue-500 hover:text-blue-300 mr-1">Editar</a>

                                    <!-- Botón de Eliminar -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-300">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>

</html>
