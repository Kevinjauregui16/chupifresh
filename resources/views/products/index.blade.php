@extends('layouts.app')
@section('title', 'Products')

@section('content')
    <div class="flex flex-col justify-start bg-gray-100 w-full h-screen">
        <div class="flex justify-between items-center mb-2 py-4 w-[90%] mx-auto">
            <p class="text-3xl font-bold">List Products</p>
            <a href="{{ route('products.create') }}" class="bg-green-500 text-white text-sm px-4 py-1 rounded-lg">New +</a>
        </div>
        <div class="bg-white shadow-xl rounded-xl p-4 w-[90%] mx-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Id</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                @if ($products->isEmpty())
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-center text-amber-500 text-lg py-4">No products found.</td>
                        </tr>
                    </tbody>
                @else
                @endif
                <tbody>
                    @foreach ($products as $product)
                        <tr class="text-center border-b border-gray-200">
                            <td class="px-4 py-2">{{ $product->id }}</td>
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2">{{ $product->price }}</td>
                            <td class="px-4 py-2">{{ $product->quantity }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('products.edit', $product) }}" method="GET" class="inline-block">
                                    <button type="submit"
                                        class="bg-blue-500 text-white text-sm px-4 py-1 rounded-lg">Edit</button>
                                </form>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
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
