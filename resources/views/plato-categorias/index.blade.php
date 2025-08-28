@extends('layouts.master')

@section('title', 'Categorías de Platos - Minaati Dashboard')
@section('meta_description', 'Gestión de categorías de platos del restaurante')

@section('breadcrumb')
<div class="row align-items-center">
    <div class="col-md-8 col-lg-8">
        <h4 class="page-title">Categorías de Platos</h4>
        <div class="breadcrumb-list">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categorías de Platos</li>
            </ol>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="widgetbar">
            <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus mr-2"></i>Nueva Categoría
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
                <h5 class="card-title">Lista de Categorías de Platos</h5>
            </div>
            <div class="card-body">
                <!-- Filtros -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Buscar categorías...">
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-secondary" id="clearFilters">
                            <i class="fas fa-sync-alt mr-1"></i>Limpiar
                        </button>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Platos</th>
                                <th>Fecha Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @include('plato-categorias.partials.table-body')
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div id="paginationContainer">
                    {{ $categorias->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
</div>
<!-- End row -->

<!-- Modal Crear -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Categoría de Plato</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="createForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="create_nombre">Nombre *</label>
                        <input type="text" class="form-control" id="create_nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="create_descripcion">Descripción</label>
                        <textarea class="form-control" id="create_descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="create_precio">Precio</label>
                        <input type="number" class="form-control" id="create_precio" name="precio" step="0.01" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Categoría de Plato</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nombre">Nombre *</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_descripcion">Descripción</label>
                        <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_precio">Precio</label>
                        <input type="number" class="form-control" id="edit_precio" name="precio" step="0.01" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Categoría</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar la categoría <strong id="delete_nombre"></strong>?</p>
                <p class="text-danger"><small>Esta acción no se puede deshacer.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let deleteId = null;
    
    // Búsqueda
    $('#searchInput').on('keyup', function() {
        loadTable();
    });
    
    // Limpiar filtros
    $('#clearFilters').on('click', function() {
        $('#searchInput').val('');
        loadTable();
    });
    
    // Crear categoría
    $('#createForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("plato-categorias.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#createModal').modal('hide');
                    $('#createForm')[0].reset();
                    loadTable();
                    new Notyf().success(response.message);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorMsg = Object.values(errors).flat().join('\n');
                    new Notyf().error(errorMsg);
                } else {
                    new Notyf().error('Error al crear la categoría');
                }
            }
        });
    });
    
    // Editar categoría
    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        
        $.ajax({
            url: `/plato-categorias/${id}`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let data = response.data;
                    $('#edit_id').val(data.id);
                    $('#edit_nombre').val(data.nombre);
                    $('#edit_descripcion').val(data.descripcion);
                    $('#edit_precio').val(data.precio);
                    $('#editModal').modal('show');
                }
            },
            error: function() {
                new Notyf().error('Error al cargar los datos');
            }
        });
    });
    
    // Actualizar categoría
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_id').val();
        
        $.ajax({
            url: `/plato-categorias/${id}`,
            method: 'PUT',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#editModal').modal('hide');
                    loadTable();
                    new Notyf().success(response.message);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorMsg = Object.values(errors).flat().join('\n');
                    new Notyf().error(errorMsg);
                } else {
                    new Notyf().error('Error al actualizar la categoría');
                }
            }
        });
    });
    
    // Eliminar categoría
    $(document).on('click', '.btn-delete', function() {
        deleteId = $(this).data('id');
        let nombre = $(this).data('nombre');
        $('#delete_nombre').text(nombre);
        $('#deleteModal').modal('show');
    });
    
    $('#confirmDelete').on('click', function() {
        if (deleteId) {
            $.ajax({
                url: `/plato-categorias/${deleteId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#deleteModal').modal('hide');
                        loadTable();
                        new Notyf().success(response.message);
                    }
                },
                error: function(xhr) {
                    let message = xhr.responseJSON?.message || 'Error al eliminar la categoría';
                    new Notyf().error(message);
                }
            });
        }
    });
    
    // Paginación
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if (url) {
            loadTable(url);
        }
    });
    
    // Función para cargar tabla
    function loadTable(url = null) {
        let searchUrl = url || '{{ route("plato-categorias.index") }}';
        let search = $('#searchInput').val();
        
        $.ajax({
            url: searchUrl,
            method: 'GET',
            data: {
                search: search
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                $('#tableBody').html(response.html);
                $('#paginationContainer').html(response.pagination);
            },
            error: function() {
                new Notyf().error('Error al cargar los datos');
            }
        });
    }
});
</script>
@endsection