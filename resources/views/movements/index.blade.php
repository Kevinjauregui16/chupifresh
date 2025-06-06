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
                            <th class="px-4 py-2">Fecha</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center border-b border-gray-200">
                            <td class="px-4 py-2">Movimiento de ejemplo</td>
                            <td class="px-4 py-2 text-gray-500">$1,000.00</td>
                            <td class="px-4 py-2 text-green-500 font-bold">+$100.00</td>
                            <td class="px-4 py-2 text-xs text-gray-400">04/06/2025</td>
                            <td class="px-4 py-2">
                                <a href="#" class="text-primary hover:text-blue-400 transition-colors p-1"><i
                                        class="fa-solid fa-pencil"></i></a>
                                <form action="#" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-secondary hover:text-red-400 transition-colors p-1"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                        <tr class="text-center border-b border-gray-200">
                            <td class="px-4 py-2">Otro movimiento</td>
                            <td class="px-4 py-2 text-gray-500">$900.00</td>
                            <td class="px-4 py-2 text-red-500 font-bold">-$50.00</td>
                            <td class="px-4 py-2 text-xs text-gray-400">03/06/2025</td>
                            <td class="px-4 py-2">
                                <a href="#" class="text-primary hover:text-blue-400 transition-colors p-1"><i
                                        class="fa-solid fa-pencil"></i></a>
                                <form action="#" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-secondary hover:text-red-400 transition-colors p-1"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
