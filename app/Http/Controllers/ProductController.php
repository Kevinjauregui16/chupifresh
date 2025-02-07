<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    // Método para mostrar todos los posts
    public function index()
    {
        // Obtener todos los posts de la base de datos
        $products = Product::all();

        // Retornar la vista con los posts
        return view('products.index', compact('products'));
    }
    // Guarda el post en la base de datos
    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'ingredients' => 'required',
            'production_cost' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Crear el post
        Product::create($validated);

        // Redirigir con un mensaje de éxito
        return redirect()->route('products.create')->with('success', 'Producto creado con éxito.');
    }

    // Muestra el formulario para crear un nuevo post
    public function create()
    {
        return view('products.create');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'ingredients' => 'required',
            'production_cost' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Producto actualizado con éxito');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product eliminado con éxito');
    }
}
