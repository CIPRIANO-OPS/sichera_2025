<?php

namespace App\Http\Controllers;

use App\Models\Venta;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        return view('ventas.create');
    }

    public function store(Request $request)
    {
        Venta::create($request->all());
        return redirect()->route('ventas.index');
    }

    public function show($id)
    {
        // Aquí deberías buscar por ambas claves si usas compuestas
    }

    public function edit($id)
    {
        // Igual que show
    }

    public function update(Request $request, $id)
    {
        // Igual que show
    }

    public function destroy($id)
    {
        // Igual que show
    }

}
