<?php

namespace App\Http\Controllers;

use App\Models\Comanda;
use App\Models\Mesa;
use App\Models\PlatoCategoria;
use App\Models\Plato;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ComandaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Comanda::with(['mesa', 'pedidos.plato']);
        
        // Filtrar por mesa si se proporciona
        if ($request->has('mesa_id')) {
            $query->where('mesa_id', $request->mesa_id);
        }
        
        // Filtrar por estado si se proporciona
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }
        
        $comandas = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Si es una petición AJAX, devolver JSON
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $comandas
            ]);
        }
        
        // Si es una petición web normal, devolver vista
        return view('comandas.index', compact('comandas'));
    }

    /**
     * Crear una nueva comanda para una mesa
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mesa_id' => 'required|exists:mesas,pk',
            'observaciones' => 'nullable|string|max:500',
            'pedidos' => 'nullable|array',
            'pedidos.*.plato_id' => 'required_with:pedidos|exists:platos,id',
            'pedidos.*.cantidad' => 'required_with:pedidos|integer|min:1',
            'pedidos.*.observaciones' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $mesa = Mesa::find($request->mesa_id);
            
            // Verificar si la mesa ya tiene una comanda activa
            $comandaExistente = Comanda::where('mesa_id', $request->mesa_id)
                                     ->where('estado', 'abierta')
                                     ->first();
            
            if ($comandaExistente) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'La mesa ya tiene una comanda activa',
                    'comanda_existente' => $comandaExistente->load(['mesa', 'pedidos.plato'])
                ], 400);
            }

            $comanda = Comanda::create([
                'mesa_id' => $request->mesa_id,
                'numero_comanda' => Comanda::generarNumeroComanda(),
                'observaciones' => $request->observaciones,
                'estado' => 'abierta',
                'fecha_apertura' => now()
            ]);

            // Crear pedidos si se proporcionan
            \Log::info('Datos recibidos para pedidos:', [
                'has_pedidos' => $request->has('pedidos'),
                'pedidos_data' => $request->pedidos,
                'is_array' => is_array($request->pedidos)
            ]);
            
            if ($request->has('pedidos') && is_array($request->pedidos)) {
                \Log::info('Procesando ' . count($request->pedidos) . ' pedidos');
                
                foreach ($request->pedidos as $index => $pedidoData) {
                    \Log::info("Procesando pedido {$index}:", $pedidoData);
                    
                    $plato = Plato::find($pedidoData['plato_id']);
                    \Log::info("Plato encontrado:", [
                        'plato_id' => $pedidoData['plato_id'],
                        'plato_existe' => $plato ? true : false,
                        'plato_estado' => $plato ? $plato->estado : null
                    ]);
                    
                    if ($plato && $plato->estado === 'activo') {
                        $subtotal = $plato->precio * $pedidoData['cantidad'];
                        
                        $pedidoCreado = $comanda->pedidos()->create([
                            'plato_id' => $pedidoData['plato_id'],
                            'cantidad' => $pedidoData['cantidad'],
                            'precio_unitario' => $plato->precio,
                            'subtotal' => $subtotal,
                            'observaciones' => $pedidoData['observaciones'] ?? null,
                            'estado' => 'pendiente'
                        ]);
                        
                        \Log::info("Pedido creado exitosamente:", [
                            'pedido_id' => $pedidoCreado->id,
                            'plato_id' => $pedidoCreado->plato_id,
                            'cantidad' => $pedidoCreado->cantidad
                        ]);
                    } else {
                        \Log::warning("Pedido no creado - plato no activo o no existe:", [
                            'plato_id' => $pedidoData['plato_id'],
                            'plato_existe' => $plato ? true : false,
                            'plato_estado' => $plato ? $plato->estado : null
                        ]);
                    }
                }
                
                // Actualizar total de la comanda
                $comanda->actualizarTotal();
                \Log::info('Total de comanda actualizado:', ['total' => $comanda->total]);
            } else {
                \Log::warning('No se proporcionaron pedidos o no es un array válido');
            }

            // Cambiar estado de la mesa a ocupado
            $mesa->update(['estado' => Mesa::ESTADO_OCUPADO]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Comanda creada exitosamente',
                'comanda' => $comanda->load(['mesa', 'pedidos.plato'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la comanda: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comanda $comanda)
    {
        $comanda->load(['mesa', 'pedidos.plato.categoria']);
        
        return response()->json([
            'success' => true,
            'comanda' => $comanda
        ]);
    }

    /**
     * Obtener categorías de platos para el modal
     */
    public function getCategorias()
    {
        try {
            $categorias = PlatoCategoria::all();
            
            return response()->json([
                'success' => true,
                'data' => $categorias
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener categorías: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener platos por categoría
     */
    public function getPlatosPorCategoria(Request $request)
    {
        try {
            $categoriaId = $request->get('categoria_id');
            
            if (!$categoriaId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de categoría requerido'
                ], 400);
            }
            
            $platos = Plato::where('idcategoriaplatos', $categoriaId)
                          ->where('estado', 'activo')
                          ->get();
            
            return response()->json([
                'success' => true,
                'data' => $platos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener platos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cerrar una comanda
     */
    public function cerrar(Comanda $comanda)
    {
        try {
            DB::beginTransaction();

            $comanda->update([
                'estado' => 'cerrada',
                'fecha_cierre' => now()
            ]);

            // Cambiar estado de la mesa a por desocupar
            $comanda->mesa->update(['estado' => Mesa::ESTADO_POR_DESOCUPAR]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Comanda cerrada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar la comanda: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancelar una comanda
     */
    public function cancelar(Comanda $comanda)
    {
        try {
            DB::beginTransaction();

            $comanda->update([
                'estado' => 'cancelada',
                'fecha_cierre' => now()
            ]);

            // Cambiar estado de la mesa a disponible
            $comanda->mesa->update(['estado' => Mesa::ESTADO_DISPONIBLE]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Comanda cancelada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar la comanda: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comanda $comanda)
    {
        try {
            DB::beginTransaction();

            // Cambiar estado de la mesa a disponible
            $comanda->mesa->update(['estado' => Mesa::ESTADO_DISPONIBLE]);
            
            $comanda->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Comanda eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la comanda: ' . $e->getMessage()
            ], 500);
        }
    }
}
