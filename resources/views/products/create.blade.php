@extends('layouts.app')
@section('title', 'Crear producto')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-xl w-1/2">
            <h2 class="text-xl font-bold mb-4">Crear producto</h2>

            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium">Nombre:</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="cost" class="block text-gray-700 font-medium">Costo:</label>
                    <input type="number" id="cost" name="cost" step="0.01" value="{{ old('cost') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('cost')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-gray-700 font-medium">Precio:</label>
                    <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700 font-medium">Stock:</label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('products.index') }}"
                        class="w-full bg-secondary text-white px-4 py-2
                    rounded-lg text-center">Cancelar</a>
                    <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-lg">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>


@endsection
