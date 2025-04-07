@extends('layouts.app')
@section('title', 'Customers')

@section('content')
    <div class="flex flex-col justify-start bg-gray-100 w-full h-screen">
        <div class="flex justify-between items-center mb-2 py-4 w-[90%] mx-auto">
            <p class="text-3xl font-bold">List Customers</p>
            <a href="{{ route('customers.create') }}" class="bg-green-500 text-white text-sm px-4 py-1 rounded-lg">New +</a>
        </div>
        <div class="bg-white shadow-xl rounded-xl p-4 w-[90%] mx-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Id</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Actions</th>
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
                                    class="bg-blue-500 text-white text-sm px-4 py-1 rounded-lg">Edit</a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white text-sm px-4 py-1 rounded-lg">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
