@extends('layouts.master')

@section('title', 'Clientes - Minaati Dashboard')
@section('meta_description', 'Gestión de clientes del restaurante')

@section('breadcrumb')
<div class="row align-items-center">
    <div class="col-md-8 col-lg-8">
        <h4 class="page-title">Gestión de Clientes</h4>
        <div class="breadcrumb-list">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
            </ol>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="widgetbar">
            <button class="btn btn-primary" data-toggle="modal" data-target="#createClienteModal">
                <i class="fas fa-plus"></i> Nuevo Cliente
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
                <h5 class="card-title">Lista de Clientes</h5>
                <div class="card-header-right">
                    <div class="input-group">
                        <input type="text" id="searchClientes" class="form-control" placeholder="Buscar clientes...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless" id="clientesTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Celular</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="clientesTableBody">
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
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" id="clientesInfo"></div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate" id="clientesPagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
</div>
<!-- End row -->

<!-- Modal Crear Cliente -->
<div class="modal fade" id="createClienteModal" tabindex="-1" role="dialog" aria-labelledby="createClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClienteModalLabel">Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createClienteForm">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="create_nombre">Nombre</label>
                        <input type="text" class="form-control" id="create_nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="create_apellido">Apellido</label>
                        <input type="text" class="form-control" id="create_apellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="create_correo">Correo</label>
                        <input type="email" class="form-control" id="create_correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="create_celular">Celular</label>
                        <input type="text" class="form-control" id="create_celular" name="celular" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Cliente -->
<div class="modal fade" id="editClienteModal" tabindex="-1" role="dialog" aria-labelledby="editClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClienteModalLabel">Editar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editClienteForm">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_cliente_id" name="cliente_id">
                    <div class="form-group">
                        <label for="edit_nombre">Nombre</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_apellido">Apellido</label>
                        <input type="text" class="form-control" id="edit_apellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_correo">Correo</label>
                        <input type="email" class="form-control" id="edit_correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_celular">Celular</label>
                        <input type="text" class="form-control" id="edit_celular" name="celular" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ver Cliente -->
<div class="modal fade" id="viewClienteModal" tabindex="-1" role="dialog" aria-labelledby="viewClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewClienteModalLabel">Detalles del Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nombre:</strong>
                        <p id="view_nombre"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Apellido:</strong>
                        <p id="view_apellido"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Correo:</strong>
                        <p id="view_correo"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Celular:</strong>
                        <p id="view_celular"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Búsqueda en tiempo real
    $('#searchClientes').on('keyup', function() {
        let searchTerm = $(this).val();
        searchClientes(searchTerm);
    });

    // Crear cliente
    $('#createClienteForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("clientes.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#createClienteModal').modal('hide');
                $('#createClienteForm')[0].reset();
                notyf.success('Cliente creado exitosamente');
                loadClientes();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'Error al crear el cliente';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join(', ');
                }
                notyf.error(errorMessage);
            }
        });
    });

    // Editar cliente
    $('#editClienteForm').on('submit', function(e) {
        e.preventDefault();
        
        let clienteId = $('#edit_cliente_id').val();
        
        $.ajax({
            url: `/clientes/${clienteId}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editClienteModal').modal('hide');
                notyf.success('Cliente actualizado exitosamente');
                loadClientes();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'Error al actualizar el cliente';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join(', ');
                }
                notyf.error(errorMessage);
            }
        });
    });
});

// Función para cargar clientes
function loadClientes(page = 1, search = '') {
    $.ajax({
        url: '{{ route("clientes.index") }}',
        method: 'GET',
        data: {
            page: page,
            search: search,
            ajax: true
        },
        success: function(response) {
            $('#clientesTableBody').html(response.html);
            $('#clientesPagination').html(response.pagination);
            $('#clientesInfo').html(response.info);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

// Función para buscar clientes
function searchClientes(searchTerm) {
    loadClientes(1, searchTerm);
}

// Función para ver cliente
function viewCliente(id) {
    $.ajax({
        url: `/clientes/${id}`,
        method: 'GET',
        success: function(response) {
            $('#view_nombre').text(response.nombre);
            $('#view_apellido').text(response.apellido);
            $('#view_correo').text(response.correo);
            $('#view_celular').text(response.celular);
            $('#viewClienteModal').modal('show');
        },
        error: function() {
            notyf.error('Error al cargar los datos del cliente');
        }
    });
}

// Función para editar cliente
function editCliente(id) {
    $.ajax({
        url: `/clientes/${id}/edit`,
        method: 'GET',
        success: function(response) {
            $('#edit_cliente_id').val(response.id);
            $('#edit_nombre').val(response.nombre);
            $('#edit_apellido').val(response.apellido);
            $('#edit_correo').val(response.correo);
            $('#edit_celular').val(response.celular);
            $('#editClienteModal').modal('show');
        },
        error: function() {
            notyf.error('Error al cargar los datos del cliente');
        }
    });
}

// Función para eliminar cliente
function deleteCliente(id) {
    if (confirm('¿Está seguro de que desea eliminar este cliente?')) {
        $.ajax({
            url: `/clientes/${id}`,
            method: 'DELETE',
            success: function(response) {
                notyf.success('Cliente eliminado exitosamente');
                loadClientes();
            },
            error: function() {
                notyf.error('Error al eliminar el cliente');
            }
        });
    }
}
</script>
@endsection