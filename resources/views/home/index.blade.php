@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white shadow-xl rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg font-bold mb-2">Vendedores</h2>
                    <p class="text-3xl font-semibold text-yellow-500">{{ $customers->count() }}</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-yellow-500">
                    <i class="fa-solid fa-users fa-3x"></i>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg font-bold mb-2">Productos</h2>
                    <p class="text-3xl font-semibold text-primary">{{ $products->count() }}</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-primary">
                    <i class="fa-solid fa-tag fa-3x"></i>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg font-bold mb-2">Stock</h2>
                    <p class="text-3xl font-semibold text-red-500">{{ $totalProducts }}</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-red-500">
                    <i class="fa-solid fa-cubes fa-3x"></i>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-4 flex items-center">
                <div class="w-1/2">
                    <h2 class="text-lg font-bold mb-2">Ventas</h2>
                    <p class="text-3xl font-semibold text-green-500">${{ $sales }}</p>
                </div>
                <div class="w-1/2 flex justify-center items-center border-r-4 border-green-500">
                    <i class="fa-solid fa-wallet fa-3x"></i>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-2 flex flex-col items-center justify-center">
                <h2 class="text-lg font-bold mb-4">Estados de ventas</h2>
                <canvas id="salesPieChart"></canvas>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-2 flex flex-col items-center">
                <h2 class="text-lg font-bold mb-4">Existencias bajas</h2>
                <canvas id="lowStockChart" height="350" class="m-auto"></canvas>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-2 flex flex-col items-center">
                <h2 class="text-lg font-bold mb-4">Existencias altas</h2>
                <canvas id="highStockChart" height="350" class="m-auto"></canvas>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('salesPieChart').getContext('2d');
        var salesPieChart = new Chart(ctx, {
            type: 'doughnut', // Tipo de gráfico
            data: {
                labels: ['Pagadas', 'Pendientes'],
                datasets: [{
                    label: 'Sales Status',
                    data: [{{ $closedSalesCount }},
                        {{ $openSalesCount }}
                    ], // Valores de ventas cerradas y abiertas
                    backgroundColor: ['#22c55e', '#facc15'], // Colores para los segmentos
                    borderColor: ['#fff', '#fff'], // Bordes blancos
                    borderWidth: 1
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
                    backgroundColor: '#f87171'
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
                    backgroundColor: '#22c55e'
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
    </script>
@endsection
