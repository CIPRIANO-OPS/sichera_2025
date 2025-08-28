<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mesas = Mesa::orderBy('numero')->get();
        return view('mesas.index', compact('mesas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estados = Mesa::getEstados();
        return response()->json([
            'estados' => $estados
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|integer|unique:mesas,numero',
            'estado' => 'required|in:disponible,ocupado,reservado,por_desocupar'
        ]);

        try {
            $mesa = Mesa::create([
                'id' => Str::uuid(),
                'numero' => $request->numero,
                'estado' => $request->estado ?? 'disponible'
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Mesa creada exitosamente',
                    'mesa' => $mesa
                ]);
            }

            return redirect()->route('mesas.index')->with('success', 'Mesa creada exitosamente');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la mesa: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al crear la mesa: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mesa $mesa)
    {
        return response()->json([
            'mesa' => $mesa,
            'estados' => Mesa::getEstados()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesa $mesa)
    {
        return response()->json([
            'mesa' => $mesa,
            'estados' => Mesa::getEstados()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesa $mesa)
    {
        $request->validate([
            'numero' => 'required|integer|unique:mesas,numero,' . $mesa->pk . ',pk',
            'estado' => 'required|in:disponible,ocupado,reservado,por_desocupar'
        ]);

        try {
            $mesa->update([
                'numero' => $request->numero,
                'estado' => $request->estado
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mesa actualizada exitosamente',
                'mesa' => $mesa->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la mesa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa)
    {
        try {
            $mesa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mesa eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la mesa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vista especial para mostrar mesas como cuadrados
     */
    public function restaurant()
    {
        $mesas = Mesa::orderBy('numero')->get();
        return view('mesas.restaurant', compact('mesas'));
    }

    /**
     * Obtener mesas en formato JSON para AJAX
     */
    public function getMesasJson()
    {
        $mesas = Mesa::orderBy('numero')->get();
        return response()->json([
            'success' => true,
            'mesas' => $mesas
        ]);
    }

    /**
     * Separar mesa (funcionalidad futura)
     */
    public function separar(Mesa $mesa)
    {
        // Funcionalidad vacía por ahora
        return response()->json([
            'success' => true,
            'message' => 'Función de separar mesa - En desarrollo',
            'mesa' => $mesa
        ]);
    }

    /**
     * Crear comanda (funcionalidad futura)
     */
    public function crearComanda(Mesa $mesa)
    {
        // Funcionalidad vacía por ahora
        return response()->json([
            'success' => true,
            'message' => 'Función de crear comanda - En desarrollo',
            'mesa' => $mesa
        ]);
    }
}
