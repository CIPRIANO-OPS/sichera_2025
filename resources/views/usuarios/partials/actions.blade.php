<button type="button" class="btn btn-sm btn-primary edit-btn" 
        data-id="{{ $usuario->id }}" 
        data-name="{{ $usuario->name }}" 
        data-email="{{ $usuario->email }}" 
        data-toggle="tooltip" 
        title="Editar">
    <i class="fa fa-edit"></i>
</button>

@if(Auth::id() !== $usuario->id)
    <button type="button" class="btn btn-sm btn-danger delete-btn" 
            data-id="{{ $usuario->id }}" 
            data-name="{{ $usuario->name }}" 
            data-toggle="tooltip" 
            title="Eliminar">
        <i class="fa fa-trash"></i>
    </button>
@endif