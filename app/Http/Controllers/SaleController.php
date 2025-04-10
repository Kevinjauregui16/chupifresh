<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $sales = Sale::with('customer')->get();
        $customers = Customer::all();

        return view('sales.index', compact('sales', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();

        return view('sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Datos recibidos en store():', $request->all());

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'is_closed' => 'boolean'
        ]);

        $isClosed = $request->has('is_closed') ? true : false;

        // Crear la venta con total = 0 (se actualizará luego)
        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'total' => 0,
            'is_closed' => $isClosed
        ]);

        $total = 0;

        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);
            $quantity = $productData['quantity'];
            $price = $product->price;

            if ($product->quantity < $quantity) {
                return back()->withErrors([
                    'quantity' => "No hay suficiente stock para el producto: {$product->name}. Solo hay {$product->quantity} unidades disponibles."
                ]);
            }

            // Calcular subtotal de este producto
            $subtotal = $price * $quantity;
            $total += $subtotal;

            $product->quantity -= $quantity; // Reducir la cantidad en stock
            $product->save(); // Guardar cambios en el producto

            // Asociar producto a la venta
            $sale->products()->attach($product->id, [
                'quantity' => $quantity,
                'price' => $price
            ]);

            Log::info("Producto agregado a la venta", [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal
            ]);
        }

        // Actualizar el total de la venta
        $sale->update(['total' => $total]);

        Log::info("Venta creada con éxito", ['sale_id' => $sale->id, 'total' => $total]);

        return redirect()->route('sales.index')->with('success', 'Sale created successfully!');
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
        $sale = Sale::with(['customer', 'products'])->findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();

        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'is_closed' => 'boolean'
        ]);

        $sale = Sale::findOrFail($id);

        $oldProducts = $sale->products->keyBy('id');

        $isClosed = $request->has('is_closed') ? true : false;

        // Actualizar el cliente
        $sale->update([
            'customer_id' => $request->customer_id,
            'is_closed' => $isClosed
        ]);

        $total = 0;
        $syncData = [];

        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);
            $quantity = $productData['quantity'];
            $price = $product->price;
            $subtotal = $price * $quantity;
            $total += $subtotal;

            $syncData[$product->id] = [
                'quantity' => $quantity,
                'price' => $price
            ];

            // Verificar si la cantidad del producto ha cambiado
            if (isset($oldProducts[$product->id])) {
                $oldQuantity = $oldProducts[$product->id]->pivot->quantity;

                if (isset($oldProducts[$product->id])) {
                    $oldQuantity = $oldProducts[$product->id]->pivot->quantity;

                    if ($quantity > $oldQuantity) {
                        // El usuario quiere más productos → se deben descontar del stock
                        $difference = $quantity - $oldQuantity;

                        if ($product->quantity < $difference) {
                            return back()->withErrors([
                                'quantity' => "No hay suficiente stock para el producto: {$product->name}. Solo hay {$product->quantity} unidades disponibles."
                            ]);
                        }

                        $product->decrement('quantity', $difference);
                    } elseif ($quantity < $oldQuantity) {
                        // El usuario quiere menos productos → se devuelven al stock
                        $difference = $oldQuantity - $quantity;
                        $product->increment('quantity', $difference);
                    }
                } else {
                    // Producto nuevo → descontar del stock
                    if ($product->quantity < $quantity) {
                        return back()->withErrors([
                            'quantity' => "No hay suficiente stock para el producto: {$product->name}. Solo hay {$product->quantity} unidades disponibles."
                        ]);
                    }

                    $product->decrement('quantity', $quantity);
                }
            } else {
                // Si el producto es nuevo en la venta, descontamos del stock
                $product->decrement('quantity', $quantity);
            }

            $product->save();
        }


        // Sincronizar productos con cantidades y precios
        $sale->products()->sync($syncData);

        // Actualizar total
        $sale->update(['total' => $total]);

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->products()->detach(); // Desasociar productos
        $sale->delete(); // Eliminar la venta

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully!');
    }
}
