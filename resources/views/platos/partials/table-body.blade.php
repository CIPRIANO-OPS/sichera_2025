@foreach($platos as $plato)
<tr>
    <td>{{ $plato->id }}</td>
    <td>
        <strong>{{ $plato->nombre }}</strong>
    </td>
    <td>
        <span class="badge badge-primary">{{ $plato->categoria->nombre ?? 'Sin categoría' }}</span>
    </td>
    <td>
        <span class="text-muted">{{ Str::limit($plato->descripcion, 60) }}</span>
    </td>
    <td>
        <span class="badge badge-success">${{ number_format($plato->precio, 2) }}</span>
    </td>
    <td>
        <span class="badge badge-secondary">{{ $plato->tipo }}</span>
    </td>
    <td>
        <small class="text-muted">{{ $plato->created_at->format('d/m/Y H:i') }}</small>
    </td>
    <td>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-outline-info btn-edit" 
                    data-id="{{ $plato->id }}" 
                    data-toggle="tooltip" 
                    title="Editar">
                <i class="fas fa-edit"></i>
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete" 
                    data-id="{{ $plato->id }}" 
                    data-nombre="{{ $plato->nombre }}"
                    data-toggle="tooltip" 
                    title="Eliminar">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach

@if($platos->isEmpty())
<tr>
    <td colspan="8" class="text-center py-4">
        <div class="empty-state">
            <i class="fas fa-utensils" style="font-size: 48px; color: #ccc;"></i>
            <h5 class="mt-3 text-muted">No hay platos registrados</h5>
            <p class="text-muted">Comience creando un nuevo plato para el menú</p>
        </div>
    </td>
</tr>
@endif