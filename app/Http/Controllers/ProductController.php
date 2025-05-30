<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0|max:999999.99',
            'price' => 'required|numeric|min:0|max:999999.99',
            'quantity' => 'required|integer|min:1|max:10000',
        ]
        , [
            'name.required' => 'El nombre del producto es obligatorio.',
            'cost.required' => 'El costo del producto es obligatorio.',
            'price.required' => 'El precio del producto es obligatorio.',
            'quantity.required' => 'El stock del producto es obligatoria.',
        ]);

        Product::create([
            'name' => $request->name,
            'cost' => $request->cost,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return redirect()->route('products.index')->with('success', '!Producto creado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        return view('products.edit', [
            'product' => Product::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0|max:999999.99',
            'price' => 'required|numeric|min:0|max:999999.99',
            'quantity' => 'required|integer|min:1|max:10000',
        ],
        [
            'name.required' => 'El nombre del producto es obligatorio.',
            'cost.required' => 'El costo del producto es obligatorio.',
            'price.required' => 'El precio del producto es obligatorio.',
            'quantity.required' => 'El stock del producto es obligatoria.',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return redirect()->route('products.index')->with('success', '!Producto actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '!Producto eliminado exitosamente!');
    }
}
