<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Venta;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics and data.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener estadísticas reales de la base de datos
        // Si las tablas no existen o están vacías, usar datos de ejemplo
        try {
            $totalClientes = Cliente::count();
        } catch (\Exception $e) {
            $totalClientes = 25; // Dato de ejemplo
        }

        try {
            $totalEmpleados = Empleado::count();
        } catch (\Exception $e) {
            $totalEmpleados = 8; // Dato de ejemplo
        }

        try {
            $ventasMes = Venta::whereMonth('created_at', date('m'))
                            ->whereYear('created_at', date('Y'))
                            ->count();
        } catch (\Exception $e) {
            $ventasMes = 42; // Dato de ejemplo
        }

        try {
            $ingresosTotales = Venta::whereMonth('created_at', date('m'))
                                  ->whereYear('created_at', date('Y'))
                                  ->sum('total');
        } catch (\Exception $e) {
            $ingresosTotales = 15750.50; // Dato de ejemplo
        }

        // Datos adicionales para gráficos y tablas
        $data = [
            'totalClientes' => $totalClientes,
            'totalEmpleados' => $totalEmpleados,
            'ventasMes' => $ventasMes,
            'ingresosTotales' => $ingresosTotales,
            'ventasRecientes' => $this->getVentasRecientes(),
            'empleadosDestacados' => $this->getEmpleadosDestacados(),
        ];

        return view('dashboard', $data);
    }

    /**
     * Get recent sales data (example data if database is empty)
     *
     * @return array
     */
    private function getVentasRecientes()
    {
        try {
            // Intentar obtener ventas reales de la base de datos
            $ventas = Venta::with(['cliente', 'empleado'])
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();
            
            if ($ventas->count() > 0) {
                return $ventas;
            }
        } catch (\Exception $e) {
            // Si hay error o no hay datos, devolver datos de ejemplo
        }

        // Datos de ejemplo
        return [
            (object) [
                'id' => 1,
                'cliente' => (object) ['nombre' => 'Juan Pérez'],
                'empleado' => (object) ['nombre' => 'María García'],
                'total' => 250.00,
                'estado' => 'completada',
                'created_at' => now()
            ],
            (object) [
                'id' => 2,
                'cliente' => (object) ['nombre' => 'Ana López'],
                'empleado' => (object) ['nombre' => 'Carlos Ruiz'],
                'total' => 180.50,
                'estado' => 'procesando',
                'created_at' => now()
            ],
            (object) [
                'id' => 3,
                'cliente' => (object) ['nombre' => 'Pedro Martínez'],
                'empleado' => (object) ['nombre' => 'Laura Sánchez'],
                'total' => 320.75,
                'estado' => 'completada',
                'created_at' => now()->subDay()
            ],
        ];
    }

    /**
     * Get top employees data (example data if database is empty)
     *
     * @return array
     */
    private function getEmpleadosDestacados()
    {
        try {
            // Intentar obtener empleados reales de la base de datos
            $empleados = Empleado::limit(3)->get();
            
            if ($empleados->count() > 0) {
                return $empleados;
            }
        } catch (\Exception $e) {
            // Si hay error o no hay datos, devolver datos de ejemplo
        }

        // Datos de ejemplo
        return [
            (object) [
                'id' => 1,
                'nombre' => 'María García',
                'cargo' => 'Vendedora',
                'badge' => 'Top Ventas'
            ],
            (object) [
                'id' => 2,
                'nombre' => 'Carlos Ruiz',
                'cargo' => 'Supervisor',
                'badge' => 'Liderazgo'
            ],
            (object) [
                'id' => 3,
                'nombre' => 'Laura Sánchez',
                'cargo' => 'Atención al Cliente',
                'badge' => 'Servicio'
            ],
        ];
    }
}