<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Sale;
use App\Models\Movement;

class MovementsController extends Controller
{
    public function index(): View
    {
        $sales = number_format(Sale::sum('total'), 2, '.', '');
        $totalCost = Sale::with('products')->get()->sum(function ($sale) {
            return $sale->products->sum('pivot.cost');
        });

        $movementsIn = Movement::where('type', 'entrada')->sum('amount');
        $movementsOut = Movement::where('type', 'salida')->sum('amount');

        $earnings = number_format($sales - $totalCost + $movementsIn - $movementsOut, 2, '.', ',');

        $movements = Movement::all();

        return view('movements.index', compact(
            'sales',
            'totalCost',
            'earnings',
            'movements',
        ));
    }

    public function create(): View
    {
        $sales = number_format(Sale::sum('total'), 2, '.', '');
        $totalCost = Sale::with('products')->get()->sum(function ($sale) {
            return $sale->products->sum('pivot.cost');
        });

        $movementsIn = Movement::where('type', 'entrada')->sum('amount');
        $movementsOut = Movement::where('type', 'salida')->sum('amount');

        $earnings = number_format($sales - $totalCost + $movementsIn - $movementsOut, 2, '.', ',');

        return view('movements.create', compact('earnings'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'type' => 'required|string|in:entrada,salida',
                'description' => 'required|string|max:255',
                'amount_before' => 'required|numeric|min:0',
                'amount' => 'required|numeric|min:0',
            ],
            [
                'type.required' => 'El tipo de movimiento es obligatorio.',
                'description.required' => 'La descripción del movimiento es obligatoria.',
                'amount_before.required' => 'El monto antes del movimiento es obligatorio.',
                'amount.required' => 'El monto del movimiento es obligatorio.',
            ]
        );

        Movement::create([
            'type' => $request->type,
            'description' => $request->description,
            'amount_before' => $request->amount_before,
            'amount' => $request->amount,
        ]);

        return redirect()->route('movements.index')->with('success', 'Movimiento creado exitosamente.');
    }

    public function edit($id): View
    {
        return view(
            'movements.edit',
            ['movement' => Movement::findOrFail($id)]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'type' => 'required|string|in:entrada,salida',
                'description' => 'required|string|max:255',
                'amount_before' => 'required|numeric|min:0',
                'amount' => 'required|numeric|min:0',
            ],
            [
                'type.required' => 'El tipo de movimiento es obligatorio.',
                'description.required' => 'La descripción del movimiento es obligatoria.',
                'amount_before.required' => 'El monto antes del movimiento es obligatorio.',
                'amount.required' => 'El monto del movimiento es obligatorio.',
            ]
        );

        $movement = Movement::findOrFail($id);
        $movement->update([
            'type' => $request->type,
            'description' => $request->description,
            'amount_before' => $request->amount_before,
            'amount' => $request->amount,
        ]);

        return redirect()->route('movements.index')->with('success', 'Movimiento actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $movement = Movement::findOrFail($id);
        $movement->delete();

        return redirect()->route('movements.index')->with('success', 'Movimiento eliminado exitosamente.');
    }
}
