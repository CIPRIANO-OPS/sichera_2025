<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;


class ClienteController extends Controller
{   
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = 10;
        
        $query = Cliente::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('apellido', 'LIKE', "%{$search}%")
                  ->orWhere('correo', 'LIKE', "%{$search}%")
                  ->orWhere('celular', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->ajax()) {
            $clientes = $query->paginate($perPage);
            
            $html = view('clientes.partials.table-body', compact('clientes'))->render();
            $pagination = $clientes->appends($request->all())->links()->render();
            $info = "Mostrando " . $clientes->firstItem() . " a " . $clientes->lastItem() . " de " . $clientes->total() . " registros";
            
            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
                'info' => $info
            ]);
        }
        
        $clientes = $query->paginate($perPage);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes|max:255',
            'celular' => 'required|string|max:20'
        ]);

        $cliente = Cliente::create($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente creado exitosamente',
                'cliente' => $cliente
            ]);
        }
        
        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function show(Cliente $cliente)
    {
        if (request()->ajax()) {
            return response()->json($cliente);
        }
        
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        if (request()->ajax()) {
            return response()->json($cliente);
        }
        
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo,' . $cliente->id . '|max:255',
            'celular' => 'required|string|max:20'
        ]);

        $cliente->update($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente actualizado exitosamente',
                'cliente' => $cliente
            ]);
        }
        
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente eliminado exitosamente'
            ]);
        }
        
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado.');
    }
}
