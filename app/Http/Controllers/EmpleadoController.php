<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Facades\Validator;


class EmpleadoController extends Controller
{   
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $perPage = 10;
        
        $query = Empleado::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('dni', 'LIKE', "%{$search}%")
                  ->orwhere('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('apellido', 'LIKE', "%{$search}%")
                  ->orWhere('whatsapp', 'LIKE', "%{$search}%")
                  ->orWhere('fechanac', 'LIKE', "%{$search}%")
                  ->orWhere('direccion', 'LIKE', "%{$search}%")
                  ->orWhere('sueldo', 'LIKE', "%{$search}%")
                  ->orWhere('cargo', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->ajax()) {
            $empleados = $query->paginate($perPage);
            
            $html = view('Empleados.partials.table-body', compact('empleados'))->render();
            $pagination = $empleados->appends($request->all())->links()->render();
            $info = "Mostrando " . $empleados->firstItem() . " a " . $empleados->lastItem() . " de " . $empleados->total() . " registros";
            
            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
                'info' => $info
            ]);
        }
        
        $comensales = $query->paginate($perPage);
        return view('empleados.index', ['empleados' => $comensales]);
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|unique:empleados|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'whatsapp' => 'required|number|max:255',
            'fechanac' => 'required|string|unique:empleados|max:20',
            'direccion' => 'required|string|max:255',
            'sueldo' => 'required|number|max:255',
            'cargo' => 'required|string||max:255',
    
        ]);

        $empleado = Empleado::create($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Empleado creado exitosamente',
                'empleado' => $empleado
            ]);
        }
        
        return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function show(Empleado $empleado)
    {
        if (request()->ajax()) {
            return response()->json($empleado);
        }
        
        return view('empleados.show', compact('empleado'));
    }

    public function edit(Empleado $empleado)
    {
        if (request()->ajax()) {
            return response()->json($empleado);
        }
        
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'dni' => 'required|string|unique:empleados|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'whatsapp' => 'required|number|unique:empleados|max:255',
            'fechanac' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'sueldo' => 'required|number|max:255',
            'cargo' => 'required|string||max:255',
            
        ]);
 
        $empleado->update($request->all());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Empleado actualizado exitosamente',
                'empleado' => $empleado
            ]);
        }
        
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado.');
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Empleado eliminado exitosamente'
            ]);
        }
        
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado.');
    }
}
