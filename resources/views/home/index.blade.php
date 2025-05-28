@extends('layouts.app')
@section('title', 'PanelFresh - Inicio')

@section('content')
    <div class="m-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 2xl:gap-4 px-8 mt-1">

            <div class="bg-white shadow-xl rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg text-gray-600 font-bold mb-2">Vendedores</h2>
                    <p class="text-3xl font-semibold text-primary">{{ $customers->count() }}</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-primary">
                    <i class="fa-solid fa-users fa-3x text-gray-400"></i>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg text-gray-600 font-bold mb-2">Productos</h2>
                    <p class="text-3xl font-semibold text-primary">{{ $products->count() }}</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-primary">
                    <i class="fa-solid fa-tag fa-3x text-gray-400"></i>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg text-gray-600 font-bold mb-2">Stock</h2>
                    <p class="text-3xl font-semibold text-primary">{{ $totalProducts }}</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-primary">
                    <i class="fa-solid fa-cubes fa-3x text-gray-400"></i>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-4 flex items-center gap-1 2xl:gap-4">
                <div class="w-1/3">
                    <h2 class="text-md 2xl:text-lg text-gray-600 font-bold mb-2">Ventas</h2>
                    <p class="text-lg font-semibold text-secondary">$<span class="text-secondary">{{ $sales }}</span>
                    </p>
                </div>
                <div class="w-1/3">
                    <h2 class="text-md 2xl:text-lg text-gray-600 font-bold mb-2">Ganancias</h2>
                    <p class="text-lg font-semibold text-primary">$<span class="text-primary">{{ $earnings }}</span>
                    </p>
                </div>
                <div class="w-1/3 flex justify-center items-center border-r-4 border-primary">
                    <i class="fa-solid fa-wallet fa-3x text-gray-400"></i>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-2 flex flex-col items-center">
                <h2 class="text-lg text-gray-600 font-bold mb-4">Existencias bajas</h2>
                <canvas id="lowStockChart" height="350" class="m-auto"></canvas>
                @if ($lowStockProducts->where('quantity', 0)->count())
                    <div class="mt-4 text-center">
                        <h3 class="text-red-500 font-bold">¡Productos sin stock!</h3>
                        <ul>
                            @foreach ($lowStockProducts->where('quantity', 0) as $product)
                                <li class="text-gray-700">{{ $product->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="bg-white shadow-xl rounded-lg p-2 flex flex-col items-center">
                <h2 class="text-lg text-gray-600 font-bold mb-4">Existencias altas</h2>
                <canvas id="highStockChart" height="350" class="m-auto"></canvas>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-2 flex flex-col items-center col-span-1 md:col-span-2">
                <h2 class="text-lg text-gray-600 font-bold">Top 3 más vendidos</h2>
                <canvas id="bestSellingChart" height="125" class="my-auto"></canvas>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-2 flex flex-col items-center col-span-1 md:col-span-2">
                <h2 class="text-lg text-gray-600 font-bold">Acciones rapidas</h2>
                <div class="flex flex-col justify-center items-center gap-4 p-4 m-auto w-full h-full text-white">
                    <a href="{{ route('customers.create') }}"
                        class="text-utils cursor-pointer w-full h-1/4 rounded-xl flex justify-center bg-gray-100 hover:bg-gray-50 transition-colors">
                        <p class="m-auto text-xl">Registrar vendedor +</p>
                    </a>
                    <a href="{{ route('products.create') }}"
                        class="text-utils cursor-pointer w-full h-1/4 rounded-lg flex justify-center bg-gray-100 hover:bg-gray-50 transition-colors">
                        <p class="m-auto text-xl">Registrar producto +</p>
                    </a>
                    <a href="{{ route('sales.create') }}"
                        class="text-utils cursor-pointer w-full h-1/4 rounded-lg flex justify-center bg-gray-100 hover:bg-gray-50 transition-colors">
                        <p class="m-auto text-xl">Registrar venta +</p>
                    </a>
                    <a href="{{ route('sales.index') }}"
                        class="text-utils cursor-pointer w-full h-1/4 rounded-lg flex justify-center bg-gray-100 hover:bg-gray-50 transition-colors">
                        <p class="m-auto text-xl">Crear cuenta +</p>
                    </a>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-2 flex flex-col items-center justify-center">
                <h2 class="text-lg text-gray-600 font-bold mb-4">Estados de ventas</h2>
                <canvas id="salesPieChart"></canvas>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-2 flex flex-col items-center">
                <h2 class="text-lg font-bold text-gray-600 mb-4">Top 3 menos vendidos</h2>
                <div class="m-auto">
                    @foreach ($lowestSelling as $product)
                        <div class="flex justify-between items-center border-b p-4 gap-2">
                            <span class="font-medium">{{ $product->name }}</span>
                            <span class="bg-red-50 text-secondary px-2 py-1 rounded-full text-sm">
                                {{ $product->total_sold }} unidades
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('salesPieChart').getContext('2d');
        var salesPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pagadas', 'Pendientes'],
                datasets: [{
                    label: 'Sales Status',
                    data: [{{ $closedSalesCount }},
                        {{ $openSalesCount }}
                    ],
                    backgroundColor: ['#3049D0', '#FF2D75'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        const lowStockCtx = document.getElementById('lowStockChart').getContext('2d');
        const lowStockChart = new Chart(lowStockCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($lowStockLabels) !!},
                datasets: [{
                    label: 'Stock',
                    data: {!! json_encode($lowStockQuantities) !!},
                    backgroundColor: '#FF2D75'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const highStockCtx = document.getElementById('highStockChart').getContext('2d');
        const highStockChart = new Chart(highStockCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($highStockLabels) !!},
                datasets: [{
                    label: 'Stock',
                    data: {!! json_encode($highStockQuantities) !!},
                    backgroundColor: '#3049D0'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        })

        const bestSellingCtx = document.getElementById('bestSellingChart').getContext('2d');
        const bestSellingChart = new Chart(bestSellingCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($bestSelling->pluck('name')) !!},
                datasets: [{
                    label: 'Unidades vendidas',
                    data: {!! json_encode($bestSelling->pluck('total_sold')) !!},
                    backgroundColor: [
                        '#3049D0'
                    ]
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.parsed.x} unidades`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endsection
