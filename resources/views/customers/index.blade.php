@extends('layouts.app')
@section('title', 'Customers')

@section('content')
    <div class="flex flex-col justify-start w-full h-screen mt-6">
        <div class="flex justify-between items-center mb-2 py-4 w-[90%] mx-auto">
            <p class="text-3xl font-bold">Vendedores</p>
            <a href="{{ route('customers.create') }}" class="bg-green-500 text-white text-sm px-4 py-1 rounded-lg">Nuevo +</a>
        </div>
        <div class="bg-white shadow-xl rounded-xl p-4 w-[90%] mx-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Id</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                @if ($customers->isEmpty())
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center text-amber-500 text-lg py-4">No customers found.</td>
                        </tr>
                    </tbody>
                @else
                @endif
                <tbody>
                    @foreach ($customers as $customer)
                        <tr class="text-center border-b border-gray-200">
                            <td class="px-4 py-2">{{ $customer->id }}</td>
                            <td class="px-4 py-2">{{ $customer->name }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('customers.edit', $customer) }}"
                                    class="text-blue-500 hover:text-blue-300 transition-colors p-1"><i
                                        class="fa-solid fa-pencil"></i></a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST"
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
    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}")
        </script>
    @endif
@endsection
