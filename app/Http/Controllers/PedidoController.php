<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Comanda;
use App\Models\Plato;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pedido::with(['comanda.mesa', 'plato']);
        
        if ($request->has('comanda_id')) {
            $query->where('comanda_id', $request->comanda_id);
        }
        
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }
        
        $pedidos = $query->orderBy('created_at', 'desc')->paginate(10);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $pedidos
            ]);
        }
        
        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $comandas = Comanda::where('estado', 'abierta')->with('mesa')->get();
        $platos = Plato::with('categoria')->where('disponible', true)->get();
        
        return view('pedidos.create', compact('comandas', 'platos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comanda_id' => 'required|exists:comandas,id',
            'plato_id' => 'required|exists:platos,id',
            'cantidad' => 'required|integer|min:1',
            'observaciones' => 'nullable|string|max:500'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Verificar que la comanda esté abierta
            $comanda = Comanda::findOrFail($request->comanda_id);
            if ($comanda->estado !== 'abierta') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pueden agregar pedidos a una comanda cerrada'
                ], 400);
            }
            
            // Obtener el plato y su precio
            $plato = Plato::findOrFail($request->plato_id);
            if (!$plato->disponible) {
                return response()->json([
                    'success' => false,
                    'message' => 'El plato no está disponible'
                ], 400);
            }
            
            $pedido = new Pedido();
            $pedido->comanda_id = $request->comanda_id;
            $pedido->plato_id = $request->plato_id;
            $pedido->cantidad = $request->cantidad;
            $pedido->precio_unitario = $plato->precio;
            $pedido->observaciones = $request->observaciones;
            $pedido->save();
            
            DB::commit();
            
            $pedido->load(['plato', 'comanda.mesa']);
            
            return response()->json([
                'success' => true,
                'message' => 'Pedido agregado exitosamente',
                'data' => $pedido
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el pedido: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pedido = Pedido::with(['comanda.mesa', 'plato.categoria'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $pedido
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pedido = Pedido::with(['comanda', 'plato'])->findOrFail($id);
        $platos = Plato::with('categoria')->where('disponible', true)->get();
        
        return view('pedidos.edit', compact('pedido', 'platos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|integer|min:1',
            'observaciones' => 'nullable|string|max:500',
            'estado' => 'sometimes|in:pendiente,preparando,listo,entregado,cancelado'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            $pedido = Pedido::findOrFail($id);
            
            // Verificar que la comanda esté abierta para modificaciones de cantidad
            if ($request->has('cantidad') && $pedido->comanda->estado !== 'abierta') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede modificar la cantidad en una comanda cerrada'
                ], 400);
            }
            
            if ($request->has('cantidad')) {
                $pedido->cantidad = $request->cantidad;
            }
            
            if ($request->has('observaciones')) {
                $pedido->observaciones = $request->observaciones;
            }
            
            if ($request->has('estado')) {
                $pedido->estado = $request->estado;
            }
            
            $pedido->save();
            
            DB::commit();
            
            $pedido->load(['plato', 'comanda.mesa']);
            
            return response()->json([
                'success' => true,
                'message' => 'Pedido actualizado exitosamente',
                'data' => $pedido
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el pedido: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            
            $pedido = Pedido::findOrFail($id);
            
            // Verificar que la comanda esté abierta
            if ($pedido->comanda->estado !== 'abierta') {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pueden eliminar pedidos de una comanda cerrada'
                ], 400);
            }
            
            $pedido->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pedido eliminado exitosamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el pedido: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Cambiar el estado de un pedido
     */
    public function cambiarEstado(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'estado' => 'required|in:pendiente,preparando,listo,entregado,cancelado'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $pedido = Pedido::findOrFail($id);
            $pedido->estado = $request->estado;
            $pedido->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Estado del pedido actualizado exitosamente',
                'data' => $pedido
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }
}
