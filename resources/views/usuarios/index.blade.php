@extends('layouts.master')

@section('title', 'Usuarios - Minaati Dashboard')
@section('meta_description', 'Gestión de usuarios del sistema')

@section('breadcrumb')
<div class="row align-items-center">
    <div class="col-md-8 col-lg-8">
        <h4 class="page-title">Gestión de Usuarios</h4>
        <div class="breadcrumb-list">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
            </ol>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="widgetbar">
            <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus mr-2"></i>Nuevo Usuario
            </button>
        </div>
    </div>
</div>
<!-- Modal Eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar al usuario <strong id="delete_name"></strong>?</p>
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

@section('content')
<!-- Start row -->
<div class="row">
    <!-- Start col -->
    <div class="col-lg-12 col-xl-12">
        <div class="card m-b-30">
            <div class="card-header">
                <h5 class="card-title">Lista de Usuarios</h5>
            </div>
            <div class="card-body">
                <!-- Filtros -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Buscar usuarios...">
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
                                <th>Email</th>
                                <th>Fecha Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @include('usuarios.partials.table-body')
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div id="paginationContainer">
                    {{ $usuarios->links() }}
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
                <h5 class="modal-title">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="createForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="create_name">Nombre *</label>
                        <input type="text" class="form-control" id="create_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="create_email">Email *</label>
                        <input type="email" class="form-control" id="create_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="create_password">Contraseña *</label>
                        <input type="password" class="form-control" id="create_password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="create_password_confirmation">Confirmar Contraseña *</label>
                        <input type="password" class="form-control" id="create_password_confirmation" name="password_confirmation" required>
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
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Nombre *</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email *</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_password">Nueva Contraseña (opcional)</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="edit_password_confirmation">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation">
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
    
    // Crear usuario
    $('#createForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("usuarios.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    $('#createModal').modal('hide');
                    $('#createForm')[0].reset();
                    loadTable();
                    notyf.success(response.message);
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        notyf.error(errors[key][0]);
                    });
                } else {
                    notyf.error('Error al crear el usuario');
                }
            }
        });
    });
    
    // Editar usuario
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const email = $(this).data('email');
        
        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_email').val(email);
        $('#edit_password').val('');
        $('#edit_password_confirmation').val('');
        
        $('#editModal').modal('show');
    });
    
    // Actualizar usuario
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        
        const id = $('#edit_id').val();
        
        $.ajax({
            url: '{{ route("usuarios.index") }}/' + id,
            method: 'PUT',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    $('#editModal').modal('hide');
                    loadTable();
                    notyf.success(response.message);
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        notyf.error(errors[key][0]);
                    });
                } else {
                    notyf.error('Error al actualizar el usuario');
                }
            }
        });
    });
    
    // Eliminar usuario
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        $('#delete_name').text(name);
        $('#confirmDelete').data('id', id);
        $('#deleteModal').modal('show');
    });
    
    $('#confirmDelete').on('click', function() {
        const id = $(this).data('id');
        
        $.ajax({
            url: '{{ route("usuarios.index") }}/' + id,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    $('#deleteModal').modal('hide');
                    loadTable();
                    notyf.success(response.message);
                }
            },
            error: function(xhr) {
                notyf.error('Error al eliminar el usuario');
            }
        });
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
        let searchUrl = url || '{{ route("usuarios.index") }}';
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