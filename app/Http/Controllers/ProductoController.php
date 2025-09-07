<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoCategoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Producto::with('categoria');
            
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
            
            $productos = $query->orderBy('nombre', 'asc')->paginate(10);
            
            return response()->json([
                'html' => view('productos.partials.table-body', compact('productos'))->render(),
                'pagination' => $productos->links('pagination::bootstrap-4')->render()
            ]);
        }
        
        $productos = Producto::with('categoria')->orderBy('nombre', 'asc')->paginate(10);
        $categorias = ProductoCategoria::orderBy('nombre', 'asc')->get();
        
        return view('productos.index', compact('productos', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'idcategoriaproductos' => 'required|exists:producto_categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'tipo' => 'required|string|max:255'
        ]);

        try {
            $producto = Producto::create($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Producto creado exitosamente',
                'data' => $producto->load('categoria')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $producto->load('categoria')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto): JsonResponse
    {
        $request->validate([
            'idcategoriaproductos' => 'required|exists:producto_categorias,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'tipo' => 'required|string|max:255'
        ]);

        try {
            $producto->update($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado exitosamente',
                'data' => $producto->load('categoria')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto): JsonResponse
    {
        try {
            $producto->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get productos by category
     */
    public function getPorCategoria(Request $request): JsonResponse
    {
        $categoriaId = $request->get('categoria_id');
        
        $productos = Producto::where('idcategoriaproductos', $categoriaId)
                      ->select('id', 'nombre', 'precio')
                      ->orderBy('nombre', 'asc')
                      ->get();
        
        return response()->json([
            'success' => true,
            'data' => $productos
        ]);
    }

    /**
     * Get tipos únicos
     */
    public function getTipos(): JsonResponse
    {
        $tipos = Producto::select('tipo')
                     ->distinct()
                     ->orderBy('tipo', 'asc')
                     ->pluck('tipo');
        
        return response()->json([
            'success' => true,
            'data' => $tipos
        ]);
    }
}