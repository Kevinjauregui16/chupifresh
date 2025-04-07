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
        $sales = Sale::sum('total');

        return view('home.index', compact('customers', 'products', 'totalProducts', 'sales'));
    }
}
