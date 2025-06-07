@extends('layouts.app')
@section('title', 'Editar Movimiento')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg">
            <h2 class="text-xl text-gray-600 font-bold mb-4">Editar movimiento</h2>
            @if (session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form action="{{ route('movements.update', $movement->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 font-medium mb-1">Tipo de movimiento:</label>
                    <select name="type" id="type"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 bg-gray-50 text-gray-700"
                        required>
                        <option value="" disabled>Selecciona un tipo</option>
                        <option value="entrada" {{ old('type', $movement->type) == 'entrada' ? 'selected' : '' }}>Entrada
                        </option>
                        <option value="salida" {{ old('type', $movement->type) == 'salida' ? 'selected' : '' }}>Salida
                        </option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium">Descripción:</label>
                    <input type="text" id="description" name="description"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                        value="{{ old('description', $movement->description) }}" required>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-between">
                    <div class="mb-4">
                        <label for="amount_before" class="block text-gray-700 font-medium">Monto antes del
                            movimiento:</label>
                        <input type="text" id="amount_before" name="amount_before_display"
                            class="w-full px-4 py-2 border rounded-lg bg-green-200" value="$ {{ $movement->amount_before }}"
                            disabled>
                        <input type="hidden" name="amount_before" value="{{ $movement->amount_before }}">
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 font-medium">Monto:</label>
                        <input type="number" step="0.01" id="amount" name="amount"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                            value="{{ old('amount', $movement->amount) }}" required>
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex gap-4 mt-4">
                    <a href="{{ route('movements.index') }}"
                        class="w-full bg-secondary text-white px-4 py-2 rounded-lg text-center">Cancelar</a>
                    <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-lg">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
