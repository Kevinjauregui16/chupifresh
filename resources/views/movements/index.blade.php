@extends('layouts.app')
@section('title', 'PanelFresh - Movimientos')

@section('content')
    <div class="flex flex-col justify-start w-full h-screen pt-6">
        <div class="flex flex-col justify-start w-full h-screen">
            <div class="flex justify-between items-center py-4 w-[90%] mx-auto">
                <p class="text-3xl font-bold text-gray-500">Historial de movimientos</p>
                <a href="{{ route('movements.create') }}"
                    class="bg-utils text-white font-bold text-sm px-4 py-1 rounded-lg">Nuevo
                    +</a>
            </div>
            <div class="w-[90%] mx-auto mb-2">
                <div class="flex items-center gap-2">
                    <span class="text-lg font-semibold text-gray-600">Saldo actual:</span>
                    <span class="text-md font-bold bg-primary py-1 px-2 rounded-xl text-white">${{ $earnings }}</span>
                </div>
            </div>
            <div class="bg-white shadow-xl rounded-xl p-4 w-[90%] mx-auto">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-500">
                            <th class="px-4 py-2">Descripción</th>
                            <th class="px-4 py-2">Saldo anterior</th>
                            <th class="px-4 py-2">Monto</th>
                            <th class="px-4 py-2">Creación</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    @if ($movements->isEmpty())
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center text-amber-500 text-lg py-4">Sin movimientos aún.</td>
                            </tr>
                        </tbody>
                    @else
                    @endif
                    <tbody>
                        @foreach ($movements as $movement)
                            <tr class="text-center border-b border-gray-200">
                                <td class="px-4 py-2">{{ $movement->description }}</td>
                                <td class="px-4 py-2 text-gray-500">${{ $movement->amount_before }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if ($movement->type === 'salida')
                                        <span class="text-red-500 font-bold">+
                                            ${{ number_format($movement->amount, 2, '.', ',') }}</span>
                                    @else
                                        <span class="text-green-500 font-bold">+
                                            ${{ number_format($movement->amount, 2, '.', ',') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-gray-400 text-xs">{{ $movement->created_at }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('movements.edit', $movement) }}"
                                        class="text-primary hover:text-blue-400 transition-colors p-1"><i
                                            class="fa-solid fa-pencil"></i></a>
                                    <form action="{{ route('movements.destroy', $movement) }}" method="POST"
                                        class="inline-block">
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
            </div>
        </div>
    </div>
@endsection
