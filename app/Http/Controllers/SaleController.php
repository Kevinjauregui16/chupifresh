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
        ],[
            'customer_id.required' => 'Debes seleccionar un vendedor.',
            'products.required' => 'Debes agregar al menos un producto.',
        ]);

        $isClosed = $request->has('is_closed') ? true : false;
        $units = array_sum(array_column($request->products, 'quantity'));

        // Crear la venta con total = 0 (se actualizará luego)
        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'units' => $units,
            'total' => 0,
            'is_closed' => $isClosed
        ]);

        $total = 0;

        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);
            $quantity = $productData['quantity'];
            $cost = $product->cost; // Costo unitario en el momento de la venta
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
                'cost' => $product->cost, // Costo unitario en el momento de la venta
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

        return redirect()->route('sales.index')->with('success', '!Venta creada exitosamente!');
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
        $isClosed = $request->has('is_closed');
        $units = array_sum(array_column($request->products, 'quantity'));

        $sale->update([
            'customer_id' => $request->customer_id,
            'units' => $units,
            'is_closed' => $isClosed
        ]);

        $total = 0;
        $syncData = [];

        $newProductIds = collect($request->products)->pluck('id')->toArray();

        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $quantity = $productData['quantity'];
            $cost = $product->cost;
            $price = $product->price;
            $subtotal = $price * $quantity;
            $total += $subtotal;

            $syncData[$product->id] = [
                'quantity' => $quantity,
                'cost' => $cost,
                'price' => $price
            ];

            if (isset($oldProducts[$product->id])) {
                // Producto ya estaba en la venta
                $oldQuantity = $oldProducts[$product->id]->pivot->quantity;

                if ($quantity > $oldQuantity) {
                    $diff = $quantity - $oldQuantity;
                    if ($product->quantity < $diff) {
                        return back()->withErrors([
                            'quantity' => "No hay suficiente stock para el producto: {$product->name}. Solo hay {$product->quantity} unidades disponibles."
                        ]);
                    }
                    $product->decrement('quantity', $diff);
                } elseif ($quantity < $oldQuantity) {
                    $diff = $oldQuantity - $quantity;
                    $product->increment('quantity', $diff);
                }
            } else {
                // Producto nuevo → verificar y descontar stock
                if ($product->quantity < $quantity) {
                    return back()->withErrors([
                        'quantity' => "No hay suficiente stock para el producto: {$product->name}. Solo hay {$product->quantity} unidades disponibles."
                    ]);
                }
                $product->decrement('quantity', $quantity);
            }

            $product->save();
        }

        // Reintegrar al stock productos eliminados de la venta
        foreach ($oldProducts as $oldProductId => $oldProduct) {
            if (!in_array($oldProductId, $newProductIds)) {
                $product = Product::find($oldProductId);
                $quantityToRestore = $oldProduct->pivot->quantity;
                $product->increment('quantity', $quantityToRestore);
                $product->save();
            }
        }

        // Sincronizar productos
        $sale->products()->sync($syncData);

        // Actualizar total
        $sale->update(['total' => $total]);

        return redirect()->route('sales.index')->with('success', '¡Venta actualizada exitosamente!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::with('products')->findOrFail($id);

        foreach ($sale->products as $product) {
            $quantitySold = $product->pivot->quantity;
            $product->increment('quantity', $quantitySold); // Reintegrar al stock
        }

        $sale->products()->detach(); // Desasociar productos
        $sale->delete(); // Eliminar la venta

        return redirect()->route('sales.index')->with('success', '!Venta eliminada exitosamente!');
    }

    public function getTotalBySales(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:sales,id'
        ]);

        $ventas = Sale::whereIn('id', $request->ids)->get();

        $totalUnidades = $ventas->sum('units');
        $totalVenta = $ventas->sum('total');

        return response()->json([
            'total_unidades' => $totalUnidades,
            'total_venta' => $totalVenta
        ]);
    }
}
