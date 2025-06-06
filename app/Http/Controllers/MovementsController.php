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
        $earnings = number_format($sales - $totalCost, 2, '.', '');

        return view('movements.index', compact(
            'sales',
            'totalCost',
            'earnings'
        ));
    }

    public function create(): View
    {
        return view('movements.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'description' => 'required|string|max:255',
                'amount_before' => 'required|numeric|min:0',
                'amount' => 'required|numeric|min:0',
            ],
            [
                'description.required' => 'La descripción del movimiento es obligatoria.',
                'amount_before.required' => 'El monto antes del movimiento es obligatorio.',
                'amount.required' => 'El monto del movimiento es obligatorio.',
            ]
        );

        Movement::create([
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
                'description' => 'required|string|max:255',
                'amount_before' => 'required|numeric|min:0',
                'amount' => 'required|numeric|min:0',
            ],
            [
                'description.required' => 'La descripción del movimiento es obligatoria.',
                'amount_before.required' => 'El monto antes del movimiento es obligatorio.',
                'amount.required' => 'El monto del movimiento es obligatorio.',
            ]
        );

        $movement = Movement::findOrFail($id);
        $movement->update([
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
