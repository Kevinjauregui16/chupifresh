@extends('layouts.app')

@section('contenido')
    <x-tittle-component tittle="PRODUCTOS" />

    <div class="mt-12">
        <x-navbar />
    </div>

    {{-- <div class="flex justify-center">
        <a href="{{ route('products.create') }}"
            class="text-green-500 hover:text-green-300 bg-gray-500 bg-opacity-25 p-2 rounded-2xl">
            Nuevo<i class="fa-solid fa-plus"></i></a>
    </div> --}}

    <div class="">
        <div class="max-w-7xl mx-auto p-6 mt-5 rounded-2xl bg-[#141318]">
            <h2 class="text-gray-200 text-xl font-bold">Lista de productos</h2>
            @if ($products->isEmpty())
                <p class="text-center text-lg text-gray-600 py-12">Sin productos</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead class="text-white">
                            <tr>
                                {{-- <th class="py-2 px-4 border-b text-left text-gray-700">ID</th> --}}
                                <th class="py-2 px-4 border-b text-left">Nombre</th>
                                <th class="py-2 px-4 border-b text-left">Stock</th>
                                <th class="py-2 px-4 border-b text-left">Costo de produccion</th>
                                <th class="py-2 px-4 border-b text-left">Precio de venta</th>
                                <th class="py-2 px-4 border-b text-left">Ingredientes</th>
                                {{-- <th class="py-2 px-4 border-b text-left">Fecha de Creación</th> --}}
                                <th class="py-2 px-4 border-b text-left">Fecha de Edición</th>
                                <th class="py-2 px-4 border-b text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="hover:bg-gray-200 hover:bg-opacity-5">
                                    {{-- <td class="py-2 px-4 border-b text-gray-600">{{ $product->id }}</td> --}}
                                    <td class="py-2 px-4 border-b text-white">{{ $product->product_name }}</td>
                                    <td class="py-2 px-4 border-b text-white">{{ $product->stock }}</td>
                                    <td class="py-2 px-4 border-b text-white">{{ $product->production_cost }}</td>
                                    <td class="py-2 px-4 border-b text-white">{{ $product->sale_price }}</td>
                                    <td class="py-2 px-4 border-b text-white">{{ $product->ingredients }}</td>
                                    {{-- <td class="py-2 px-4 border-b text-white">
                                        {{ $product->created_at->format('d/m/Y H:i') }}
                                    </td> --}}
                                    <td class="py-2 px-4 border-b text-white">
                                        {{ $product->updated_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-4 px-4 m-auto border-b text-white">
                                        <!-- Botón de Editar -->
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="text-green-500 hover:text-blue-300 mr-1"><i
                                                class="fa-solid fa-pen text-xl"></i></a>

                                        <!-- Botón de Eliminar -->
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-300"><i
                                                    class="fa-solid fa-trash text-xl"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
