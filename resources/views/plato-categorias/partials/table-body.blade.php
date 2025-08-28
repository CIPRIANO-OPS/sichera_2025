@foreach($categorias as $categoria)
<tr>
    <td>{{ $categoria->id }}</td>
    <td>
        <strong>{{ $categoria->nombre }}</strong>
    </td>
    <td>
        <span class="text-muted">{{ Str::limit($categoria->descripcion, 50) ?? 'Sin descripción' }}</span>
    </td>
    <td>
        @if($categoria->precio)
            <span class="badge badge-success">${{ number_format($categoria->precio, 2) }}</span>
        @else
            <span class="text-muted">No definido</span>
        @endif
    </td>
    <td>
        <span class="badge badge-info">{{ $categoria->platos_count ?? $categoria->platos()->count() }}</span>
    </td>
    <td>
        <small class="text-muted">{{ $categoria->created_at->format('d/m/Y H:i') }}</small>
    </td>
    <td>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-outline-info btn-edit" 
                    data-id="{{ $categoria->id }}" 
                    data-toggle="tooltip" 
                    title="Editar">
                <i class="fas fa-edit"></i>
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete" 
                    data-id="{{ $categoria->id }}" 
                    data-nombre="{{ $categoria->nombre }}"
                    data-toggle="tooltip" 
                    title="Eliminar">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach

@if($categorias->isEmpty())
<tr>
    <td colspan="7" class="text-center py-4">
        <div class="empty-state">
            <i class="fas fa-folder-open" style="font-size: 48px; color: #ccc;"></i>
            <h5 class="mt-3 text-muted">No hay categorías registradas</h5>
            <p class="text-muted">Comience creando una nueva categoría de plato</p>
        </div>
    </td>
</tr>
@endif