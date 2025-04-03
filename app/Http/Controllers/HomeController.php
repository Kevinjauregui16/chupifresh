<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Customer;

class HomeController extends Controller
{
    public function index(): View
    {
        $customers = Customer::all();
        return view('home.index', compact('customers'));
    }
}
