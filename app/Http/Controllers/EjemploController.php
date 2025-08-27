<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class EjemploController extends Controller
{
    /**
     * Display the ejemplo view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Obtener estadísticas reales o datos de ejemplo
            $totalClientes = $this->getTotalClientes();
            $totalEmpleados = $this->getTotalEmpleados();
            $totalVentas = $this->getTotalVentas();
            $totalIngresos = $this->getTotalIngresos();
            $ventasRecientes = $this->getVentasRecientes();
            $empleadosDestacados = $this->getEmpleadosDestacados();

            return view('ejemplo', compact(
                'totalClientes',
                'totalEmpleados', 
                'totalVentas',
                'totalIngresos',
                'ventasRecientes',
                'empleadosDestacados'
            ));
        } catch (\Exception $e) {
            // En caso de error, mostrar datos de ejemplo
            return view('ejemplo', [
                'totalClientes' => 125,
                'totalEmpleados' => 15,
                'totalVentas' => 89,
                'totalIngresos' => 45250.75,
                'ventasRecientes' => $this->getEjemploVentas(),
                'empleadosDestacados' => $this->getEjemploEmpleados()
            ]);
        }
    }

    /**
     * Get total clients count
     */
    private function getTotalClientes()
    {
        try {
            return Cliente::count();
        } catch (\Exception $e) {
            return 125; // Dato de ejemplo
        }
    }

    /**
     * Get total employees count
     */
    private function getTotalEmpleados()
    {
        try {
            return Empleado::count();
        } catch (\Exception $e) {
            return 15; // Dato de ejemplo
        }
    }

    /**
     * Get total sales count for current month
     */
    private function getTotalVentas()
    {
        try {
            return Venta::whereMonth('created_at', now()->month)
                       ->whereYear('created_at', now()->year)
                       ->count();
        } catch (\Exception $e) {
            return 89; // Dato de ejemplo
        }
    }

    /**
     * Get total income for current month
     */
    private function getTotalIngresos()
    {
        try {
            return Venta::whereMonth('created_at', now()->month)
                       ->whereYear('created_at', now()->year)
                       ->sum('total') ?? 0;
        } catch (\Exception $e) {
            return 45250.75; // Dato de ejemplo
        }
    }

    /**
     * Get recent sales
     */
    private function getVentasRecientes()
    {
        try {
            $ventas = Venta::with('cliente')
                          ->latest()
                          ->take(5)
                          ->get();

            if ($ventas->isEmpty()) {
                return $this->getEjemploVentas();
            }

            return $ventas->map(function ($venta) {
                return [
                    'id' => $venta->id,
                    'cliente' => $venta->cliente->nombre ?? 'Cliente N/A',
                    'fecha' => $venta->created_at->format('d/m/Y'),
                    'total' => $venta->total,
                    'estado' => 'Completada'
                ];
            })->toArray();
        } catch (\Exception $e) {
            return $this->getEjemploVentas();
        }
    }

    /**
     * Get featured employees
     */
    private function getEmpleadosDestacados()
    {
        try {
            $empleados = Empleado::take(3)->get();

            if ($empleados->isEmpty()) {
                return $this->getEjemploEmpleados();
            }

            return $empleados->map(function ($empleado) {
                return [
                    'nombre' => $empleado->nombre,
                    'puesto' => $empleado->puesto ?? 'Empleado',
                    'ventas' => rand(5000, 15000) // Ventas simuladas
                ];
            })->toArray();
        } catch (\Exception $e) {
            return $this->getEjemploEmpleados();
        }
    }

    /**
     * Get example sales data
     */
    private function getEjemploVentas()
    {
        return [
            [
                'id' => 'V001',
                'cliente' => 'María González',
                'fecha' => now()->format('d/m/Y'),
                'total' => 1250.00,
                'estado' => 'Completada'
            ],
            [
                'id' => 'V002',
                'cliente' => 'Carlos Rodríguez',
                'fecha' => now()->subDay()->format('d/m/Y'),
                'total' => 890.50,
                'estado' => 'Completada'
            ],
            [
                'id' => 'V003',
                'cliente' => 'Ana Martínez',
                'fecha' => now()->subDays(2)->format('d/m/Y'),
                'total' => 2100.75,
                'estado' => 'Completada'
            ],
            [
                'id' => 'V004',
                'cliente' => 'Luis Fernández',
                'fecha' => now()->subDays(3)->format('d/m/Y'),
                'total' => 675.25,
                'estado' => 'Completada'
            ],
            [
                'id' => 'V005',
                'cliente' => 'Carmen López',
                'fecha' => now()->subDays(4)->format('d/m/Y'),
                'total' => 1450.00,
                'estado' => 'Completada'
            ]
        ];
    }

    /**
     * Get example employees data
     */
    private function getEjemploEmpleados()
    {
        return [
            [
                'nombre' => 'Juan Pérez',
                'puesto' => 'Gerente de Ventas',
                'ventas' => 12500.00
            ],
            [
                'nombre' => 'Laura Silva',
                'puesto' => 'Ejecutiva Comercial',
                'ventas' => 9800.50
            ],
            [
                'nombre' => 'Roberto Díaz',
                'puesto' => 'Asesor de Ventas',
                'ventas' => 7650.25
            ]
        ];
    }
}