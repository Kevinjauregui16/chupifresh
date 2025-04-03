@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg font-bold mb-2">Customers</h2>
                    <p class="text-3xl font-semibold text-yellow-500">{{ $customers->count() }}</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-yellow-500">
                    <i class="fa-solid fa-users fa-3x"></i>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg font-bold mb-2">Products</h2>
                    <p class="text-3xl font-semibold text-primary">{{ $products->count() }}</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-primary">
                    <i class="fa-solid fa-tag fa-3x"></i>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg font-bold mb-2">Product Stock</h2>
                    <p class="text-3xl font-semibold text-red-500">{{ $totalProducts }}</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-red-500">
                    <i class="fa-solid fa-cubes fa-3x"></i>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg font-bold mb-2">Sales</h2>
                    <p class="text-3xl font-semibold text-green-500">$5,000</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-green-500">
                    <i class="fa-solid fa-wallet fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
