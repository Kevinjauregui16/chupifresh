<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Sale;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ],
        [
            'name.required' => 'El nombre del vendedor es obligatorio.',
        ]);

        Customer::create([
            'name' => $request->name,
        ]);

        return redirect()->route('customers.index')->with('success', '!Vendedor creado exitosamente!');
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
    public function edit(string $id): View
    {
        return view('customers.edit', [
            'customer' => Customer::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ],
    [
        'name.required' => 'El nombre del vendedor es obligatorio.'
    ]);

        $customer = Customer::findOrFail($id);
        $customer->update([
            'name' => $request->name,
        ]);

        return redirect()->route('customers.index')->with('success', '!Vendedor actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        if($customer->sales()->exists()) {
            return redirect()->route('customers.index')
            ->with('error', 'Ventas asociadas a este vendedor, no se puede eliminar');
        }

        $customer->delete();

        return redirect()->route('customers.index')
        ->with('success', '!Vendedor eliminado exitosamente!');
    }
}
