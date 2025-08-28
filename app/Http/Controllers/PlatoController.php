<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use App\Models\PlatoCategoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PlatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Plato::with('categoria');
            
            // Búsqueda
            if ($request->has('search') && !empty($request->search)) {
                $query->buscar($request->search);
            }
            
            // Filtro por categoría
            if ($request->has('categoria_id') && !empty($request->categoria_id)) {
                $query->porCategoria($request->categoria_id);
            }
            
            // Filtro por tipo
            if ($request->has('tipo') && !empty($request->tipo)) {
                $query->porTipo($request->tipo);
            }
            
            $platos = $query->orderBy('nombre', 'asc')->paginate(10);
            
            return response()->json([
                'html' => view('platos.partials.table-body', compact('platos'))->render(),
                'pagination' => $platos->links('pagination::bootstrap-4')->render()
            ]);
        }
        
        $platos = Plato::with('categoria')->orderBy('nombre', 'asc')->paginate(10);
        $categorias = PlatoCategoria::orderBy('nombre', 'asc')->get();
        
        return view('platos.index', compact('platos', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'idcategoriaplatos' => 'required|exists:plato_categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'tipo' => 'required|string|max:255'
        ]);

        try {
            $plato = Plato::create($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Plato creado exitosamente',
                'data' => $plato->load('categoria')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el plato: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Plato $plato): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $plato->load('categoria')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plato $plato): JsonResponse
    {
        $request->validate([
            'idcategoriaplatos' => 'required|exists:plato_categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'tipo' => 'required|string|max:255'
        ]);

        try {
            $plato->update($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Plato actualizado exitosamente',
                'data' => $plato->load('categoria')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el plato: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plato $plato): JsonResponse
    {
        try {
            $plato->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Plato eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el plato: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get platos by category
     */
    public function getPorCategoria(Request $request): JsonResponse
    {
        $categoriaId = $request->get('categoria_id');
        
        $platos = Plato::where('idcategoriaplatos', $categoriaId)
                      ->select('id', 'nombre', 'precio')
                      ->orderBy('nombre', 'asc')
                      ->get();
        
        return response()->json([
            'success' => true,
            'data' => $platos
        ]);
    }

    /**
     * Get tipos únicos
     */
    public function getTipos(): JsonResponse
    {
        $tipos = Plato::select('tipo')
                     ->distinct()
                     ->orderBy('tipo', 'asc')
                     ->pluck('tipo');
        
        return response()->json([
            'success' => true,
            'data' => $tipos
        ]);
    }
}