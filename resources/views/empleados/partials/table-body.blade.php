@foreach($empleados as $empleado)
<tr data-id="{{ $empleado->id }}">
    <td>{{ $empleado->nombre }}</td>
    <td>{{ $empleado->nombre }}</td>
    <td>{{ $empleado->apellido }}</td>
    <td>{{ $empleado->celular }}</td>
    <td>{{ $empleado->fechaNac }}</td>
    <td>{{ $empleado->direccion  }}</td>
    <td>{{ $empleado->correo }}</td>
    
    <td>
        <button class="btn btn-info btn-sm" onclick="viewEmpleado({{ $empleado->id }})" data-toggle="tooltip" title="Ver">
            <i class="fas fa-eye"></i>
        </button>
        <button class="btn btn-warning btn-sm" onclick="editEmpleado({{ $empleado->id }})" data-toggle="tooltip" title="Editar">
            <i class="fas fa-edit"></i>
        </button>
        <button class="btn btn-danger btn-sm" onclick="deleteEmpleado({{ $empleado->id }})" data-toggle="tooltip" title="Eliminar">
            <i class="fas fa-trash"></i>
        </button>
    </td>
</tr>
@endforeach

@if($empleado->count() == 0)
<tr>
    <td colspan="5" class="text-center">
        <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle"></i> No se encontraron empleados.
        </div>
    </td>
</tr>
@endif