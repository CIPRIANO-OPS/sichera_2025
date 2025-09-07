@foreach($productos as $producto)
<tr>
    <td>{{ $producto->id }}</td>
    <td>
        <strong>{{ $producto->nombre }}</strong>
    </td>
    <td>
        <span class="badge badge-primary">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</span>
    </td>
    <td>
        <span class="text-muted">{{ Str::limit($producto->descripcion, 60) }}</span>
    </td>
    <td>
        <span class="badge badge-success">S/{{ number_format($producto->precio, 2) }}</span>
    </td>
    <td>
        <span class="badge badge-secondary">{{ $producto->tipo }}</span>
    </td>
    <td>
        <small class="text-muted">{{ $producto->created_at->format('d/m/Y H:i') }}</small>
    </td>
    <td>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-outline-info btn-edit" 
                    data-id="{{ $producto->id }}" 
                    data-toggle="tooltip" 
                    title="Editar">
                <i class="fas fa-edit"></i>
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete" 
                    data-id="{{ $producto->id }}" 
                    data-nombre="{{ $producto->nombre }}"
                    data-toggle="tooltip" 
                    title="Eliminar">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach

@if($productos->isEmpty())
<tr>
    <td colspan="8" class="text-center py-4">
        <div class="empty-state">
            <i class="fas fa-utensils" style="font-size: 48px; color: #ccc;"></i>
            <h5 class="mt-3 text-muted">No hay productos registrados</h5>
            <p class="text-muted">Comience creando un nuevo producto para el menú</p>
        </div>
    </td>
</tr>
@endif