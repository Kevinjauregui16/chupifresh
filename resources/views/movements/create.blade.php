@extends('layouts.app')
@section('title', 'Crear Movimiento')

@section('content')
    <div class="flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg">
            <h2 class="text-xl text-gray-600 font-bold mb-4">Registrar movimiento</h2>
            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form action="{{ route('movements.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium">Descripción:</label>
                    <input type="text" id="description" name="description" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" value="{{ old('description') }}" required>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 font-medium">Monto:</label>
                    <input type="number" step="0.01" id="amount" name="amount" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" value="{{ old('amount') }}" required>
                    <p class="text-xs text-gray-400 mt-1">Usa valores positivos para ingresos y negativos para egresos.</p>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-4 mt-4">
                    <a href="{{ route('movements.index') }}" class="w-full bg-secondary text-white px-4 py-2 rounded-lg text-center">Cancelar</a>
                    <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-lg">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
