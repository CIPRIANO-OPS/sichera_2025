@extends('layouts.app')

@section('content')
<h2 class="mb-4">Lista de Empleados</h2>
<a href="{{ route('empleados.create') }}" class="btn btn-success mb-3">Registrar Nuevo Empleado</a>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cargo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($empleados as $empleado)
        <tr>
            <td>{{ $empleado->dni }}</td>
            <td>{{ $empleado->nombre }}</td>
            <td>{{ $empleado->apellido }}</td>
            <td>{{ $empleado->cargo }}</td>
            <td>
                <a href="{{ route('empleados.show', $empleado) }}" class="btn btn-sm btn-info">Ver</a>
                <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este empleado?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No hay empleados registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection