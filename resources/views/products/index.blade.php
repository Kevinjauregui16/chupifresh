@extends('layouts.app')
@section('title', 'Products')

@section('content')
    <div class="flex flex-col justify-start w-full h-screen pt-6">
        <div class="flex justify-between items-center mb-2 py-4 w-[90%] mx-auto">
            <p class="text-3xl font-bold">Productos</p>
            <a href="{{ route('products.create') }}" class="bg-green-500 text-white text-sm px-4 py-1 rounded-lg">Nuevo +</a>
        </div>
        <div class="bg-white shadow-xl rounded-xl p-4 w-[90%] mx-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Id</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Costo</th>
                        <th class="px-4 py-2">Precio</th>
                        <th class="px-4 py-2">Stock</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                @if ($products->isEmpty())
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center text-amber-500 text-lg py-4">Sin productos aún.</td>
                        </tr>
                    </tbody>
                @else
                @endif
                <tbody>
                    @foreach ($products as $product)
                        <tr
                            class="text-center border-b border-gray-200  ">
                            <td class="px-4 py-2">{{ $product->id }}</td>
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2">${{ $product->cost }}</td>
                            <td class="px-4 py-2">${{ $product->price }}</td>
                            <td class="px-4 py-2 {{ $product->quantity <= 10 ? 'text-red-500 font-bold' : ($product->quantity > 30 ? 'text-green-500 font-bold' : '') }}">{{ $product->quantity }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('products.edit', $product) }}"
                                    class="text-blue-500 hover:text-blue-300 transition-colors p-1"><i
                                        class="fa-solid fa-pencil"></i></a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                    class="inline-block">
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
@endsection
