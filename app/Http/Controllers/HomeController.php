<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;

class HomeController extends Controller
{
    public function index(): View
    {
        $customers = Customer::all();
        $products = Product::all();
        $totalProducts = Product::sum('quantity');

        $lowStockProducts = Product::where('quantity', '<=', 10)->get();
        $lowStockLabels = $lowStockProducts->pluck('name');
        $lowStockQuantities = $lowStockProducts->pluck('quantity');

        $highStockProducts = Product::where('quantity', '>=', 30)->get();
        $highStockLabels = $highStockProducts->pluck('name');
        $highStockQuantities = $highStockProducts->pluck('quantity');


        $sales = number_format(Sale::sum('total'), 2, '.', '');
        $totalCost = Sale::with('products')->get()->sum(function ($sale) {
            return $sale->products->sum('pivot.cost');
        });
        $earnings = number_format($sales - $totalCost, 2, '.', '');

        $closedSalesCount = Sale::where('is_closed', true)->count();
        $openSalesCount = Sale::where('is_closed', false)->count();

        $bestSelling = Sale::with('products')
            ->join('sales_products', 'sales.id', '=', 'sales_products.sale_id')
            ->join('products', 'sales_products.product_id', '=', 'products.id')
            ->selectRaw('products.id, products.name, SUM(sales_products.quantity) as total_sold')
            ->groupBy('product_id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(3)
            ->get();
        $lowestSelling = Product::query()
            ->leftJoin('sales_products', 'products.id', '=', 'sales_products.product_id')
            ->selectRaw('products.id, products.name, COALESCE(SUM(sales_products.quantity), 0) as total_sold')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'asc')
            ->take(3) // Muestra los 3 menos vendidos
            ->get();


        return view('home.index', compact(
            'customers',
            'products',
            'totalProducts',
            'lowStockProducts',
            'lowStockLabels',
            'lowStockQuantities',
            'highStockProducts',
            'highStockLabels',
            'highStockQuantities',
            'sales',
            'totalCost',
            'earnings',
            'closedSalesCount',
            'openSalesCount',
            'bestSelling',
            'lowestSelling'
        ));
    }
}
