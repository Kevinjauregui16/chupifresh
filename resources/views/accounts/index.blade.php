@extends('layouts.app')
@section('title', 'PanelFresh - Cuentas')

@section('content')
    <div class="flex flex-col justify-start w-full h-screen pt-6">
        <div class="flex justify-between items-center mb-2 py-4 w-[90%] mx-auto">
            <p class="text-3xl font-bold text-gray-500">Listado de Cuentas</p>
        </div>
        <div class="bg-white shadow-xl rounded-xl p-4 w-[90%] mx-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-100 text-gray-500">
                        <th class="px-4 py-2">Id</th>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Unidades</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Fecha creación</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                @if ($cuentas->isEmpty())
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center text-amber-500 text-lg py-4">Sin cuentas aún.</td>
                        </tr>
                    </tbody>
                @else
                    <tbody>
                        @foreach ($cuentas as $cuenta)
                            <tr class="text-center border-b border-gray-200">
                                <td class="px-4 py-2">{{ $cuenta->id }}</td>
                                <td class="px-4 py-2">{{ $cuenta->description }}</td>
                                <td class="px-4 py-2">{{ $cuenta->units }}</td>
                                <td class="px-4 py-2">${{ $cuenta->total }}</td>
                                <td class="px-4 py-2">{{ $cuenta->created_at }}</td>
                                <td class="px-4 py-2 gap-2 flex justify-center">

                                    <form action="{{ route('accounts.destroy', $cuenta) }}" method="POST"
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
                @endif
            </table>

        </div>
    </div>
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}")
        </script>
    @endif
    @if ($errors->any())
        <script>
            toastr.error("{{ $errors->first() }}")
        </script>
    @endif
@endsection
