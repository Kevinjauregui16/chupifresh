@extends('layouts.app')
@section('title', 'Editar vendedor')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-xl w-1/2">
            <h2 class="text-xl font-bold mb-4">Editar vendedor</h2>

            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium">Nombre:</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $customer->name) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('customers.index') }}"
                        class="w-full bg-secondary text-white px-4 py-2
                        rounded-lg text-center"">Cancelar</a>
                    <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-lg">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
