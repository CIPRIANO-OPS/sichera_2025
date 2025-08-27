@extends('layouts.master')

@section('title', 'Gestión de Mesas - Minaati Dashboard')
@section('meta_description', 'Gestión y administración de mesas del restaurante')

@section('breadcrumb')
<div class="row align-items-center">
    <div class="col-md-8 col-lg-8">
        <h4 class="page-title">Gestión de Mesas</h4>
        <div class="breadcrumb-list">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mesas</li>
            </ol>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="widgetbar">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMesaModal">
                <i class="ri-add-line"></i> Nueva Mesa
            </button>
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- Start row -->
<div class="row">
    <!-- Start col -->
    <div class="col-lg-12 col-xl-12">
        <div class="card m-b-30">
            <div class="card-header">
                <h5 class="card-title">Lista de Mesas</h5>
            </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="mesasTable">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Estado</th>
                                    <th>Fecha Creación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mesas as $mesa)
                                <tr>
                                    <td><strong>{{ $mesa->numero }}</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $mesa->getColorEstado() }}">
                                            {{ ucfirst(str_replace('_', ' ', $mesa->estado)) }}
                                        </span>
                                    </td>
                                    <td>{{ $mesa->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="editMesa({{ $mesa->pk }})" 
                                                    data-toggle="modal" 
                                                    data-target="#editMesaModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteMesa({{ $mesa->pk }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Mesa -->
<div class="modal fade" id="createMesaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Mesa</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="createMesaForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_numero" class="form-label">Número de Mesa</label>
                        <input type="number" class="form-control" id="create_numero" name="numero" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_estado" class="form-label">Estado</label>
                        <select class="form-control" id="create_estado" name="estado" required>
                            <option value="disponible">Disponible</option>
                            <option value="ocupado">Ocupado</option>
                            <option value="reservado">Reservado</option>
                            <option value="por_desocupar">Por Desocupar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Mesa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Mesa -->
<div class="modal fade" id="editMesaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Mesa</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editMesaForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_mesa_id" name="mesa_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_numero" class="form-label">Número de Mesa</label>
                        <input type="number" class="form-control" id="edit_numero" name="numero" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_estado" class="form-label">Estado</label>
                        <select class="form-control" id="edit_estado" name="estado" required>
                            <option value="disponible">Disponible</option>
                            <option value="ocupado">Ocupado</option>
                            <option value="reservado">Reservado</option>
                            <option value="por_desocupar">Por Desocupar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Mesa</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Crear Mesa
$('#createMesaForm').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: '{{ route("mesas.store") }}',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if(response.success) {
                $('#createMesaModal').modal('hide');
                location.reload();
                alert('Mesa creada exitosamente');
            }
        },
        error: function(xhr) {
            let errors = xhr.responseJSON.errors;
            let errorMessage = 'Error al crear la mesa:\n';
            for(let field in errors) {
                errorMessage += errors[field][0] + '\n';
            }
            alert(errorMessage);
        }
    });
});

// Editar Mesa
function editMesa(mesaId) {
    $.ajax({
        url: `/mesas/${mesaId}/edit`,
        method: 'GET',
        success: function(response) {
            $('#edit_mesa_id').val(mesaId);
            $('#edit_numero').val(response.mesa.numero);
            $('#edit_estado').val(response.mesa.estado);
        }
    });
}

$('#editMesaForm').on('submit', function(e) {
    e.preventDefault();
    
    let mesaId = $('#edit_mesa_id').val();
    
    $.ajax({
        url: `/mesas/${mesaId}`,
        method: 'PUT',
        data: $(this).serialize(),
        success: function(response) {
            if(response.success) {
                $('#editMesaModal').modal('hide');
                location.reload();
                alert('Mesa actualizada exitosamente');
            }
        },
        error: function(xhr) {
            let errors = xhr.responseJSON.errors;
            let errorMessage = 'Error al actualizar la mesa:\n';
            for(let field in errors) {
                errorMessage += errors[field][0] + '\n';
            }
            alert(errorMessage);
        }
    });
});

// Eliminar Mesa
function deleteMesa(mesaId) {
    if(confirm('¿Está seguro de que desea eliminar esta mesa?')) {
        $.ajax({
            url: `/mesas/${mesaId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    location.reload();
                    alert('Mesa eliminada exitosamente');
                }
            },
            error: function(xhr) {
                alert('Error al eliminar la mesa');
            }
        });
    }
}
</script>
@endsection