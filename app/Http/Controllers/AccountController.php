<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Sale;
use App\Models\Account;

class AccountController extends Controller
{
    public function index(): View
    {
        $cuentas = Account::all();

        return view('accounts.index', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_ids' => 'required|array|min:1',
            'sale_ids.*' => 'integer|exists:sales,id',
            'description' => 'required|string|max:255',
        ]);

        $sales = Sale::whereIn('id', $request->sale_ids)->get();

        $units = $sales->sum('units');
        $total = $sales->sum('total');

        $account = Account::create([
            'sale_ids' => json_encode($request->sale_ids),
            'description' => $request->description,
            'units' => $units,
            'total' => $total,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Cuenta registrada correctamente.');
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Cuenta eliminada correctamente.');
    }
}
