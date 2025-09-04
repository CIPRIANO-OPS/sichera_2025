@extends('layouts.master')

@section('title', 'Empleados - Minaati Dashboard')
@section('meta_description', 'Gestión de empleados del restaurante')

@section('breadcrumb')
<div class="row align-items-center">
    <div class="col-md-8 col-lg-8">
        <h4 class="page-title">Gestión de Empleados</h4>
        <div class="breadcrumb-list">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Empleados</li>
            </ol>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="widgetbar">
            <button class="btn btn-primary" data-toggle="modal" data-target="#createEmpleadoModal">
                <i class="fas fa-plus"></i> Nuevo Empleado
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
                <h5 class="card-title">Lista de Empleados</h5>
                <div class="card-header-right">
                    <div class="input-group">
                        <input type="text" id="searchEmpleados" class="form-control" placeholder="Buscar empleados...">
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
                    <table class="table table-hover table-striped table-bordered" id="empleadosTable">
                        <thead thead class="thead-dark">
                            <tr>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Whatsapp</th>
                                <th>Direccion</th>
                                <th>fechanac</th>
                                <th>sueldo</th>
                                <th>cargo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="empleadosTableBody">
                            @foreach($empleados as $empleado)
                            <tr data-dni="{{ $empleado->dni }}">
                                <td>{{ $empleado->nombre }}</td>
                                <td>{{ $empleado->apellido }}</td>
                                <td>{{ $empleado->whatsapp }}</td>
                                <td>{{ $empleado->direccion }}</td>
                                <td>{{ $empleado->fechanac }}</td>
                                <td>{{ $empleado->sueldo }}</td>
                                <td>{{ $empleado->cargo }}</td>
                                
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="viewEmpleado({{ $empleado->dni }})" data-toggle="tooltip" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="editEmpleado({{ $empleado->dni }})" data-toggle="tooltip" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteEmpleado({{ $empleado->dni }})" data-toggle="tooltip" title="Eliminar">
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
                        <div class="dataTables_info" id="empleadosInfo"></div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate" id="empleadosPagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
</div>
<!-- End row -->

 <!-- Modal Crear Empleados -->
<div class="modal fade" id="createEmpleadoModal" tabindex="-1" role="dialog" aria-labelledby="createEmpleadoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEmpleadoModalLabel">Nuevo Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createEmpleadoForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="create_dni">DNI</label>
                            <input type="number" class="form-control" id="create_dni" name="dni" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="create_nombre">Nombre</label>
                            <input type="text" class="form-control" id="create_nombre" name="nombre" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="create_apellido">Apellido</label>
                            <input type="text" class="form-control" id="create_apellido" name="apellido" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="create_whatsapp">Whatsapp</label>
                            <input type="text" class="form-control" id="create_whatsapp" name="whatsapp" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="create_direccion">Dirección</label>
                            <input type="text" class="form-control" id="create_direccion" name="direccion" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="create_fechanac">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="create_fechanac" name="fechanac" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="create_sueldo">Sueldo</label>
                            <input type="number" step="0.01" class="form-control" id="create_sueldo" name="sueldo" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="create_cargo">Cargo</label>
                            <input type="text" class="form-control" id="create_cargo" name="cargo" placeholder="Ejm Cocinero" required>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Empleado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Empleado -->
<div class="modal fade" id="editEmpleadoModal" tabindex="-1" role="dialog" aria-labelledby="editEmpleadoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmpleadoModalLabel">Editar Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editEmpleadoForm">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_empleado_id" name="empleado_id">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="edit_dni">DNI</label>
                            <input type="number" class="form-control" id="edit_dni" name="dni" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="edit_nombre">Nombre</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="edit_apellido">Apellido</label>
                            <input type="text" class="form-control" id="edit_apellido" name="apellido" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="edit_whatsapp">Whatsapp</label>
                            <input type="text" class="form-control" id="edit_whatsapp" name="whatsapp" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="edit_direccion">Dirección</label>
                            <input type="text" class="form-control" id="edit_direccion" name="direccion" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="edit_fechanac">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="edit_fechanac" name="fechanac" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="edit_sueldo">Sueldo</label>
                            <input type="number" step="0.01" class="form-control" id="edit_sueldo" name="sueldo" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="edit_cargo">Cargo</label>
                            <input type="text" class="form-control" id="edit_cargo" name="cargo" placeholder="Ejm Cocinero" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ver Empleado -->
<div class="modal fade" id="viewEmpleadoModal" tabindex="-1" role="dialog" aria-labelledby="viewEmpleadoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewEmpleadoModalLabel">Detalles del Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>DNI:</strong>
                        <p id="view_dni"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nombre:</strong>
                        <p id="view_nombre"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Apellido:</strong>
                        <p id="view_apellido"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Whatsapp:</strong>
                        <p id="view_whatsapp"></p>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Dirección:</strong>
                        <p id="view_direccion"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Fecha Nacimiento:</strong>
                        <p id="view_fechanac"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Sueldo:</strong>
                        <p id="view_sueldo"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Cargo:</strong>
                        <p id="view_cargo"></p>
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
    $('#searchEmpleado').on('keyup', function() {
        let searchTerm = $(this).val();
        searchEmpleado(searchTerm);
    });

    // Crear empleado
    $('#createEmpleadoForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("empleados.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#createEmpleadoModal').modal('hide');
                $('#createEmpleadoForm')[0].reset();
                notyf.success('Empleado creado exitosamente');
                loadEmpleado();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'Error al crear el empleado';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join(', ');
                }
                notyf.error(errorMessage);
            }
        });
    });

    // Editar  empleado
    $('#editEmpleadoForm').on('submit', function(e) {
        e.preventDefault();
        
        let empleadoId = $('#edit_empleado_id').val();
        
        $.ajax({
            url: `/empleados/${empleadoId}`,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                $('#editEmpleadoModal').modal('hide');
                notyf.success('Empleado actualizado exitosamente');
                loadEmpleados();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'Error al actualizar el empleado';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join(', ');
                }
                notyf.error(errorMessage);
            }
        });
    });
});

// Función para cargar empleados
function loadEmpleados(page = 1, search = '') {
    $.ajax({
        url: '{{ route("empleados.index") }}',
        method: 'GET',
        data: {
            page: page,
            search: search,
            ajax: true
        },
        success: function(response) {
            $('#empleadosTableBody').html(response.html);
            $('#empleadosPagination').html(response.pagination);
            $('#empleadosInfo').html(response.info);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

// Función para buscar empleados
function searchEmpleados(searchTerm) {
    loadEmpleados(1, searchTerm);
}

// Función para ver empleado
function viewEmpleado(id) {
    $.ajax({
        url: `/empleados/${id}`,
        method: 'GET',
        success: function(response) {
            $('#view_dni').text(response.dni);
            $('#view_nombre').text(response.nombre);
            $('#view_apellido').text(response.apellido);
            $('#view_whatsapp').text(response.whatsapp);
            $('#view_direccion').text(response.direccion);
            $('#view_fechanac').text(response.fechanac);
            $('#view_sueldo').text(response.sueldo);
            $('#view_cargo').text(response.cargo);
            $('#viewEmpleadoModal').modal('show');
        },
        error: function() {
            notyf.error('Error al cargar los datos del empleado');
        }
    });
}

// Función para editar empleado
function editEmpleado(id) {
    $.ajax({
        url: `/empleados/${id}/edit`,
        method: 'GET',
        success: function(response) {
            $('#edit_empleado_id').val(response.id);
            $('#edit_dni').val(response.dni);
            $('#edit_nombre').val(response.nombre);
            $('#edit_apellido').val(response.apellido);
            $('#edit_whatsapp').val(response.whatsapp);
            $('#edit_direccion').val(response.direccion);
            $('#edit_fechanac').val(response.fechanac);
            $('#edit_sueldo').val(response.sueldo);
            $('#edit_cargo').val(response.cargo);
            
            $('#editEmpleadoModal').modal('show');
        },
        error: function() {
            notyf.error('Error al cargar los datos del empleado');
        }
    });
}

// Función para eliminar empleado
function deleteEmpleado(id) {
    if (confirm('¿Está seguro de que desea eliminar este empleado?')) {
        $.ajax({
            url: `/empleados/${id}`,
            method: 'DELETE',
            success: function(response) {
                notyf.success('Empleado eliminado exitosamente');
                loadEmpleados();
            },
            error: function() {
                notyf.error('Error al eliminar el empleado');
            }
        });
    }
}
</script>
@endsection