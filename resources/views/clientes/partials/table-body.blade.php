@foreach($clientes as $cliente)
<tr data-id="{{ $cliente->id }}">
    <td>{{ $cliente->nombre }}</td>
    <td>{{ $cliente->apellido }}</td>
    <td>{{ $cliente->correo }}</td>
    <td>{{ $cliente->celular }}</td>
    <td>
        <button class="btn btn-info btn-sm" onclick="viewCliente({{ $cliente->id }})" data-toggle="tooltip" title="Ver">
            <i class="fas fa-eye"></i>
        </button>
        <button class="btn btn-warning btn-sm" onclick="editCliente({{ $cliente->id }})" data-toggle="tooltip" title="Editar">
            <i class="fas fa-edit"></i>
        </button>
        <button class="btn btn-danger btn-sm" onclick="deleteCliente({{ $cliente->id }})" data-toggle="tooltip" title="Eliminar">
            <i class="fas fa-trash"></i>
        </button>
    </td>
</tr>
@endforeach

@if($clientes->count() == 0)
<tr>
    <td colspan="5" class="text-center">
        <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle"></i> No se encontraron clientes.
        </div>
    </td>
</tr>
@endif