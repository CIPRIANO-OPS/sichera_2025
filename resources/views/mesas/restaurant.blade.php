@extends('layouts.master')

@section('title', 'Vista Restaurante - Mesas - Minaati Dashboard')
@section('meta_description', 'Vista de restaurante con mesas en formato de cuadrados')

@section('breadcrumb')
<div class="row align-items-center">
    <div class="col-md-8 col-lg-8">
        <h4 class="page-title">Vista de Restaurante</h4>
        <div class="breadcrumb-list">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mesas.index') }}">Mesas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Restaurante</li>
            </ol>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="widgetbar">
            <a href="{{ route('mesas.index') }}" class="btn btn-outline-secondary mr-2">
                <i class="ri-list-check"></i> Vista Lista
            </a>
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
                <h5 class="card-title">Mesas del Restaurante</h5>
            </div>
                <div class="card-body">
                    <div class="row g-3" id="mesasContainer">
                        @foreach($mesas as $mesa)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <div class="mesa-card card h-100 border-{{ $mesa->getColorEstado() }} position-relative" 
                                 data-mesa-id="{{ $mesa->pk }}" 
                                 onclick="showMesaOptions({{ $mesa->pk }}, '{{ $mesa->numero }}', '{{ $mesa->estado }}')">
                                <div class="card-body text-center p-3">
                                    <div class="mesa-icon mb-2">
                                        <i class="fas fa-square fa-3x text-{{ $mesa->getColorEstado() }}"></i>
                                    </div>
                                    <h5 class="card-title mb-1">Mesa {{ $mesa->numero }}</h5>
                                    <span class="badge bg-{{ $mesa->getColorEstado() }} mb-2">
                                        {{ ucfirst(str_replace('_', ' ', $mesa->estado)) }}
                                    </span>
                                    <div class="mesa-actions">
                                        <small class="text-muted d-block">Click para opciones</small>
                                    </div>
                                </div>
                                <!-- Indicador de estado en esquina -->
                                <div class="position-absolute top-0 end-0 p-2">
                                    <div class="status-indicator bg-{{ $mesa->getColorEstado() }}" 
                                         style="width: 12px; height: 12px; border-radius: 50%;"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($mesas->isEmpty())
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay mesas registradas</h5>
                                <p class="text-muted">Crea tu primera mesa para comenzar</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Opciones de Mesa -->
<div class="modal fade" id="mesaOptionsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mesaOptionsTitle">Opciones de Mesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" 
                                onclick="separarMesa()">
                            <i class="fas fa-cut fa-2x mb-2"></i>
                            <span>Separar Mesa</span>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" 
                                onclick="crearComanda()">
                            <i class="fas fa-receipt fa-2x mb-2"></i>
                            <span>Crear Comanda</span>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" 
                                 onclick="editarMesa()" 
                                 data-toggle="modal" 
                                 data-target="#editMesaModal">
                            <i class="fas fa-edit fa-2x mb-2"></i>
                            <span>Editar Mesa</span>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-danger w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" 
                                onclick="eliminarMesa()">
                            <i class="fas fa-trash fa-2x mb-2"></i>
                            <span>Eliminar Mesa</span>
                        </button>
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

@section('styles')
<style>
.mesa-card {
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 150px;
}

.mesa-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.mesa-icon {
    position: relative;
}

.status-indicator {
    box-shadow: 0 0 0 2px white;
}

.mesa-actions {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mesa-card:hover .mesa-actions {
    opacity: 1;
}

@media (max-width: 768px) {
    .mesa-card {
        min-height: 120px;
    }
    
    .mesa-icon i {
        font-size: 2rem !important;
    }
}
</style>
@endsection

@section('scripts')
<script>
let currentMesaId = null;
let currentMesaNumero = null;
let currentMesaEstado = null;

// Mostrar opciones de mesa
function showMesaOptions(mesaId, numero, estado) {
    currentMesaId = mesaId;
    currentMesaNumero = numero;
    currentMesaEstado = estado;
    
    $('#mesaOptionsTitle').text(`Mesa ${numero} - ${estado.charAt(0).toUpperCase() + estado.slice(1).replace('_', ' ')}`);
    $('#mesaOptionsModal').modal('show');
}

// Separar Mesa (funcionalidad vacía)
function separarMesa() {
    $.ajax({
        url: `/mesas/${currentMesaId}/separar`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#mesaOptionsModal').modal('hide');
            alert(response.message);
        },
        error: function() {
            alert('Error al separar la mesa');
        }
    });
}

// Crear Comanda (funcionalidad vacía)
function crearComanda() {
    $.ajax({
        url: `/mesas/${currentMesaId}/crear-comanda`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#mesaOptionsModal').modal('hide');
            alert(response.message);
        },
        error: function() {
            alert('Error al crear la comanda');
        }
    });
}

// Editar Mesa
function editarMesa() {
    $('#mesaOptionsModal').modal('hide');
    
    $.ajax({
        url: `/mesas/${currentMesaId}/edit`,
        method: 'GET',
        success: function(response) {
            $('#edit_mesa_id').val(currentMesaId);
            $('#edit_numero').val(response.mesa.numero);
            $('#edit_estado').val(response.mesa.estado);
        }
    });
}

// Eliminar Mesa
function eliminarMesa() {
    $('#mesaOptionsModal').modal('hide');
    
    if(confirm(`¿Está seguro de que desea eliminar la Mesa ${currentMesaNumero}?`)) {
        $.ajax({
            url: `/mesas/${currentMesaId}`,
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
            error: function() {
                alert('Error al eliminar la mesa');
            }
        });
    }
}

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

// Actualizar Mesa
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
</script>
@endsection