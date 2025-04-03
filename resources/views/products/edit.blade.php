@extends('layouts.app')
@section('title', 'Edit Customer')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-xl w-1/2">
            <h2 class="text-xl font-bold mb-4">Product Edit</h2>

            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium">Name:</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-gray-700 font-medium">Price:</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700 font-medium">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('products.index') }}"
                        class="w-full bg-amber-500 text-white px-4 py-2
                    rounded-lg text-center"">Cancel</a>
                    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
