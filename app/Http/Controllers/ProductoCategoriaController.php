<?php

namespace App\Http\Controllers;
use App\Models\ProductoCategoria;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductoCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = ProductoCategoria::query();
            
            // Búsqueda
            if ($request->has('search') && !empty($request->search)) {
                $query->buscar($request->search);
            }
            
            $categorias = $query->orderBy('id', 'asc')->paginate(10);
            
            return response()->json([
                'html' => view('producto-categorias.partials.table-body', compact('categorias'))->render(),
                'pagination' => $categorias->links('pagination::bootstrap-4')->render()
            ]);
        }
        
        $categorias = ProductoCategoria::orderBy('id', 'asc')->paginate(10);
        return view('producto-categorias.index', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:producto_categorias,nombre'
        ]);

        try {
            $categoria = ProductoCategoria::create($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Categoría de producto creada exitosamente',
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
    public function show(ProductoCategoria $productoCategoria): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $productoCategoria->load('productos')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductoCategoria $productoCategoria): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:producto_categorias,nombre,' . $productoCategoria->id,
        ]);

        try {
            $productoCategoria->update($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Categoría de producto actualizada exitosamente',
                'data' => $productoCategoria
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
    public function destroy(ProductoCategoria $productoCategoria): JsonResponse
    {
        try {
            // Verificar si tiene productos asociados
            if ($productoCategoria->productos()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la categoría porque tiene productos asociados'
                ], 400);
            }
            
            $productoCategoria->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Categoría de producto eliminada exitosamente'
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
        $categorias = ProductoCategoria::select('id', 'nombre')
                                   ->orderBy('nombre', 'asc')
                                   ->get();
        
        return response()->json([
            'success' => true,
            'data' => $categorias
        ]);
    }    
}
