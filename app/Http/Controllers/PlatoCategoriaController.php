<?php

namespace App\Http\Controllers;

use App\Models\PlatoCategoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PlatoCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = PlatoCategoria::query();
            
            // Búsqueda
            if ($request->has('search') && !empty($request->search)) {
                $query->buscar($request->search);
            }
            
            $categorias = $query->orderBy('nombre', 'asc')->paginate(10);
            
            return response()->json([
                'html' => view('plato-categorias.partials.table-body', compact('categorias'))->render(),
                'pagination' => $categorias->links('pagination::bootstrap-4')->render()
            ]);
        }
        
        $categorias = PlatoCategoria::orderBy('nombre', 'asc')->paginate(10);
        return view('plato-categorias.index', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:plato_categorias,nombre',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0'
        ]);

        try {
            $categoria = PlatoCategoria::create($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Categoría de plato creada exitosamente',
                'data' => $categoria
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la categoría: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PlatoCategoria $platoCategoria): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $platoCategoria->load('platos')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlatoCategoria $platoCategoria): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:plato_categorias,nombre,' . $platoCategoria->id,
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0'
        ]);

        try {
            $platoCategoria->update($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Categoría de plato actualizada exitosamente',
                'data' => $platoCategoria
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la categoría: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlatoCategoria $platoCategoria): JsonResponse
    {
        try {
            // Verificar si tiene platos asociados
            if ($platoCategoria->platos()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la categoría porque tiene platos asociados'
                ], 400);
            }
            
            $platoCategoria->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Categoría de plato eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la categoría: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get categories for select options
     */
    public function getForSelect(): JsonResponse
    {
        $categorias = PlatoCategoria::select('id', 'nombre')
                                   ->orderBy('nombre', 'asc')
                                   ->get();
        
        return response()->json([
            'success' => true,
            'data' => $categorias
        ]);
    }
}