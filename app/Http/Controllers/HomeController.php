<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
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
        $sales = Sale::sum('total');
        $closedSalesCount = Sale::where('is_closed', true)->count();
        $openSalesCount = Sale::where('is_closed', false)->count();

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
            'closedSalesCount',
            'openSalesCount'
        ));
    }
}
