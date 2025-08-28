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
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                        <div class="mesa-card card h-100 border-{{ $mesa->getColorEstado() }} position-relative"
                            data-mesa-id="{{ $mesa->pk }}"
                            onclick="showMesaOptions({{ $mesa->pk }}, '{{ $mesa->numero }}', '{{ $mesa->estado }}')">
                            <div class="card-body text-center p-3 pt-2">
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
                            onclick="abrirModalComanda()">
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

<!-- Modal Comanda -->
<div class="modal fade" id="comandaModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comandaModalTitle">Comanda - Mesa <span id="comandaMesaNumero"></span></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Sección de categorías y platos -->
                    <div class="col-md-6">
                        <h6>Agregar Platos</h6>
                        <div class="mb-3">
                            <label for="categoriaSelect" class="form-label">Categoría</label>
                            <select class="form-control" id="categoriaSelect">
                                <option value="">Seleccione una categoría</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="platoSelect" class="form-label">Plato</label>
                            <select class="form-control" id="platoSelect" disabled>
                                <option value="">Seleccione un plato</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="cantidadInput" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidadInput" value="1" min="1">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-primary w-100" onclick="agregarPedido()">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="observacionesInput" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observacionesInput" rows="2" placeholder="Observaciones especiales..."></textarea>
                        </div>
                    </div>

                    <!-- Sección de pedidos actuales -->
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6>Pedidos Actuales</h6>
                            <span class="badge badge-info" id="totalPedidos">0 items</span>
                        </div>
                        <div id="pedidosContainer" style="max-height: 400px; overflow-y: auto;">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-utensils fa-2x mb-2"></i>
                                <p>No hay pedidos agregados</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Total: <span id="totalComanda">$0.00</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="cerrarComanda()" id="cerrarComandaBtn" style="display: none;">
                    <i class="fas fa-check"></i> Cerrar Comanda
                </button>
                <button type="button" class="btn btn-success" onclick="guardarComanda()" id="guardarComandaBtn">
                    <i class="fas fa-save"></i> Guardar Comanda
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Comanda Existente -->
<div class="modal fade" id="verComandaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verComandaModalTitle">Comanda Existente</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="comandaExistenteContainer">
                    <!-- Contenido de la comanda existente -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editarComandaExistente()">
                    <i class="fas fa-edit"></i> Editar Comanda
                </button>
            </div>
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
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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

    // Función para recargar solo las mesas
    function loadMesas() {
        $.ajax({
            url: '{{ route("mesas.json") }}',
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    renderMesas(response.mesas);
                }
            },
            error: function() {
                notyf.error('Error al cargar las mesas');
            }
        });
    }

    // Función para renderizar las mesas dinámicamente
    function renderMesas(mesas) {
        let html = '';

        if (mesas.length === 0) {
            html = `
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay mesas registradas</h5>
                    <p class="text-muted">Crea tu primera mesa para comenzar</p>
                </div>
            </div>
        `;
        } else {
            mesas.forEach(function(mesa) {
                let colorEstado = getColorEstado(mesa.estado);
                let estadoTexto = mesa.estado.charAt(0).toUpperCase() + mesa.estado.slice(1).replace('_', ' ');

                html += `
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="mesa-card card h-100 border-${colorEstado} position-relative"
                         data-mesa-id="${mesa.pk}"
                         onclick="showMesaOptions(${mesa.pk}, '${mesa.numero}', '${mesa.estado}')">
                        <div class="card-body text-center p-3 pt-2">
                            <div class="mesa-icon mb-2">
                                <i class="fas fa-square fa-3x text-${colorEstado}"></i>
                            </div>
                            <h5 class="card-title mb-1">Mesa ${mesa.numero}</h5>
                            <span class="badge bg-${colorEstado} mb-2">
                                ${estadoTexto}
                            </span>
                            <div class="mesa-actions">
                                <small class="text-muted d-block">Click para opciones</small>
                            </div>
                        </div>
                        <div class="position-absolute top-0 end-0 p-2">
                            <div class="status-indicator bg-${colorEstado}"
                                 style="width: 12px; height: 12px; border-radius: 50%;"></div>
                        </div>
                    </div>
                </div>
            `;
            });
        }

        $('#mesasContainer').html(html);
    }

    // Función auxiliar para obtener el color del estado
    function getColorEstado(estado) {
        switch (estado) {
            case 'disponible':
                return 'success';
            case 'ocupado':
                return 'danger';
            case 'reservado':
                return 'warning';
            case 'por_desocupar':
                return 'info';
            default:
                return 'secondary';
        }
    }

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
                if (response.success) {
                    notyf.success(response.message);
                }
            },
            error: function() {
                notyf.error('Error al separar la mesa');
            }
        });
    }

    // Variables globales para comandas
    let currentComandaId = null;
    let pedidosActuales = [];
    let totalComandaActual = 0;

    // Abrir modal de comanda
    function abrirModalComanda() {
        $('#mesaOptionsModal').modal('hide');

        // Verificar si la mesa ya tiene una comanda activa
        $.ajax({
            url: `/comandas`,
            method: 'GET',
            data: {
                mesa_id: currentMesaId,
                estado: 'abierta'
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success && response.data && response.data.data && response.data.data.length > 0) {
                    // Ya existe una comanda activa
                    let comanda = response.data.data[0];
                    notyf.info(`La mesa ya tiene una comanda activa (#${comanda.numero_comanda})`);
                    mostrarComandaExistente(comanda);
                } else {
                    // No hay comanda activa, crear nueva
                    mostrarModalNuevaComanda();
                }
            },
            error: function(xhr) {
                console.log('Error al verificar comandas:', xhr);
                // Si hay error, asumir que no hay comanda y crear nueva
                mostrarModalNuevaComanda();
            }
        });
    }

    // Mostrar modal para nueva comanda
    function mostrarModalNuevaComanda() {
        currentComandaId = null;
        pedidosActuales = [];
        totalComandaActual = 0;

        $('#comandaMesaNumero').text(currentMesaNumero);
        $('#comandaModalTitle').text(`Nueva Comanda - Mesa ${currentMesaNumero}`);
        $('#cerrarComandaBtn').hide();
        $('#guardarComandaBtn').show().text('Crear Comanda');

        // Limpiar formulario
        $('#categoriaSelect').val('');
        $('#platoSelect').val('').prop('disabled', true);
        $('#cantidadInput').val(1);
        $('#observacionesInput').val('');

        // Cargar categorías
        cargarCategorias();

        // Limpiar pedidos
        actualizarPedidosContainer();

        $('#comandaModal').modal('show');
    }

    // Mostrar comanda existente
    function mostrarComandaExistente(comanda) {
        currentComandaId = comanda.id;

        $('#verComandaModalTitle').text(`Comanda #${comanda.numero_comanda} - Mesa ${currentMesaNumero}`);

        let html = `
            <div class="card">
                <div class="card-header">
                    <h6>Información de la Comanda</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Número:</strong> ${comanda.numero_comanda}</p>
                            <p><strong>Estado:</strong> <span class="badge badge-${comanda.estado === 'abierta' ? 'success' : 'secondary'}">${comanda.estado}</span></p>
                            <p><strong>Fecha:</strong> ${new Date(comanda.fecha_apertura).toLocaleString()}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total:</strong> $${parseFloat(comanda.total || 0).toFixed(2)}</p>
                            <p><strong>Observaciones:</strong> ${comanda.observaciones || 'Ninguna'}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        if (comanda.pedidos && comanda.pedidos.length > 0) {
            html += `
                <div class="card mt-3">
                    <div class="card-header">
                        <h6>Pedidos (${comanda.pedidos.length} items)</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Plato</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unit.</th>
                                        <th>Subtotal</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
            `;

            comanda.pedidos.forEach(function(pedido) {
                html += `
                    <tr>
                        <td>${pedido.plato ? pedido.plato.nombre : 'N/A'}</td>
                        <td>${pedido.cantidad}</td>
                        <td>$${parseFloat(pedido.precio_unitario).toFixed(2)}</td>
                        <td>$${parseFloat(pedido.subtotal).toFixed(2)}</td>
                        <td><span class="badge badge-info">${pedido.estado}</span></td>
                    </tr>
                `;
            });

            html += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `;
        }

        $('#comandaExistenteContainer').html(html);
        $('#verComandaModal').modal('show');
    }

    // Editar comanda existente
    function editarComandaExistente() {
        $('#verComandaModal').modal('hide');

        // Cargar datos de la comanda para edición
        $.ajax({
            url: `/comandas/${currentComandaId}`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let comanda = response.data;
                    pedidosActuales = comanda.pedidos || [];
                    totalComandaActual = parseFloat(comanda.total || 0);

                    $('#comandaMesaNumero').text(currentMesaNumero);
                    $('#comandaModalTitle').text(`Editar Comanda #${comanda.numero_comanda} - Mesa ${currentMesaNumero}`);
                    $('#cerrarComandaBtn').show();
                    $('#guardarComandaBtn').show().text('Actualizar Comanda');

                    // Cargar categorías
                    cargarCategorias();

                    // Actualizar vista de pedidos
                    actualizarPedidosContainer();

                    $('#comandaModal').modal('show');
                }
            },
            error: function() {
                notyf.error('Error al cargar la comanda');
            }
        });
    }

    // Cargar categorías
    function cargarCategorias() {
        $.ajax({
            url: '{{ route("comandas.categorias") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    let html = '<option value="">Seleccione una categoría</option>';
                    response.data.forEach(function(categoria) {
                        html += `<option value="${categoria.id}">${categoria.nombre}</option>`;
                    });
                    $('#categoriaSelect').html(html);
                } else {
                    notyf.error('Error al cargar las categorías');
                }
            },
            error: function(xhr) {
                console.error('Error al cargar categorías:', xhr);
                notyf.error('Error al cargar las categorías');
            }
        });
    }

    // Cargar platos por categoría
    function cargarPlatosPorCategoria(categoriaId) {
        if (!categoriaId) {
            $('#platoSelect').html('<option value="">Seleccione un plato</option>').prop('disabled', true);
            return;
        }

        $.ajax({
            url: '{{ route("comandas.platos-categoria") }}',
            method: 'GET',
            data: {
                categoria_id: categoriaId
            },
            success: function(response) {
                if (response.success) {
                    let html = '<option value="">Seleccione un plato</option>';
                    response.data.forEach(function(plato) {
                        html += `<option value="${plato.id}" data-precio="${plato.precio}">${plato.nombre} - $${parseFloat(plato.precio).toFixed(2)}</option>`;
                    });
                    $('#platoSelect').html(html).prop('disabled', false);
                } else {
                    notyf.error('Error al cargar los platos');
                }
            },
            error: function(xhr) {
                console.error('Error al cargar platos:', xhr);
                notyf.error('Error al cargar los platos');
            }
        });
    }

    // Agregar pedido
    function agregarPedido() {
        let platoId = $('#platoSelect').val();
        let cantidad = parseInt($('#cantidadInput').val());
        let observaciones = $('#observacionesInput').val();

        if (!platoId) {
            notyf.error('Debe seleccionar un plato');
            return;
        }

        if (cantidad < 1) {
            notyf.error('La cantidad debe ser mayor a 0');
            return;
        }

        let platoOption = $('#platoSelect option:selected');
        let platoNombre = platoOption.text().split(' - $')[0];
        let precioUnitario = parseFloat(platoOption.data('precio'));
        let subtotal = cantidad * precioUnitario;

        // Si ya existe una comanda, agregar el pedido directamente
        if (currentComandaId) {
            $.ajax({
                url: '{{ route("pedidos.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    comanda_id: currentComandaId,
                    plato_id: platoId,
                    cantidad: cantidad,
                    observaciones: observaciones
                },
                success: function(response) {
                    if (response.success) {
                        pedidosActuales.push(response.data);
                        actualizarPedidosContainer();
                        limpiarFormularioPedido();
                        notyf.success('Pedido agregado exitosamente');
                    }
                },
                error: function(xhr) {
                    let message = 'Error al agregar el pedido';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    notyf.error(message);
                }
            });
        } else {
            // Agregar a la lista temporal
            let pedidoTemp = {
                id: 'temp_' + Date.now(),
                plato_id: platoId,
                plato: {
                    nombre: platoNombre
                },
                cantidad: cantidad,
                precio_unitario: precioUnitario,
                subtotal: subtotal,
                observaciones: observaciones,
                estado: 'pendiente',
                temp: true
            };

            pedidosActuales.push(pedidoTemp);
            actualizarPedidosContainer();
            limpiarFormularioPedido();
        }
    }

    // Limpiar formulario de pedido
    function limpiarFormularioPedido() {
        $('#platoSelect').val('');
        $('#cantidadInput').val(1);
        $('#observacionesInput').val('');
    }

    // Actualizar container de pedidos
    function actualizarPedidosContainer() {
        let html = '';
        let total = 0;

        if (pedidosActuales.length === 0) {
            html = `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-utensils fa-2x mb-2"></i>
                    <p>No hay pedidos agregados</p>
                </div>
            `;
        } else {
            pedidosActuales.forEach(function(pedido, index) {
                let subtotal = parseFloat(pedido.subtotal);
                total += subtotal;

                html += `
                    <div class="card mb-2">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">${pedido.plato.nombre}</h6>
                                    <small class="text-muted">Cantidad: ${pedido.cantidad} x $${parseFloat(pedido.precio_unitario).toFixed(2)}</small>
                                    ${pedido.observaciones ? `<br><small class="text-info">Obs: ${pedido.observaciones}</small>` : ''}
                                </div>
                                <div class="text-right">
                                    <strong>$${subtotal.toFixed(2)}</strong>
                                    <br>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarPedido(${index})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        $('#pedidosContainer').html(html);
        $('#totalPedidos').text(`${pedidosActuales.length} items`);
        $('#totalComanda').text(`$${total.toFixed(2)}`);
        totalComandaActual = total;
    }

    // Eliminar pedido
    function eliminarPedido(index) {
        let pedido = pedidosActuales[index];

        if (pedido.temp) {
            // Es un pedido temporal, solo remover de la lista
            pedidosActuales.splice(index, 1);
            actualizarPedidosContainer();
        } else {
            // Es un pedido guardado, eliminar del servidor
            if (confirm('¿Está seguro de eliminar este pedido?')) {
                $.ajax({
                    url: `/pedidos/${pedido.id}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            pedidosActuales.splice(index, 1);
                            actualizarPedidosContainer();
                            notyf.success('Pedido eliminado exitosamente');
                        }
                    },
                    error: function() {
                        notyf.error('Error al eliminar el pedido');
                    }
                });
            }
        }
    }

    // Guardar comanda
    function guardarComanda() {
        if (pedidosActuales.length === 0) {
            notyf.error('Debe agregar al menos un pedido');
            return;
        }

        if (currentComandaId) {
            // Actualizar comanda existente - solo agregar nuevos pedidos
            let pedidosTemporales = pedidosActuales.filter(p => p.temp);
            if (pedidosTemporales.length > 0) {
                // Agregar pedidos uno por uno
                let promesas = pedidosTemporales.map(pedido => {
                    return $.ajax({
                        url: '{{ route("pedidos.store") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            comanda_id: currentComandaId,
                            plato_id: pedido.plato_id,
                            cantidad: pedido.cantidad,
                            observaciones: pedido.observaciones
                        }
                    });
                });
                
                Promise.all(promesas).then(() => {
                    notyf.success('Pedidos agregados exitosamente');
                    $('#comandaModal').modal('hide');
                    loadMesas();
                }).catch(() => {
                    notyf.error('Error al agregar algunos pedidos');
                });
            } else {
                notyf.info('No hay nuevos pedidos para agregar');
                $('#comandaModal').modal('hide');
            }
        } else {
            // Crear nueva comanda
            let pedidosData = pedidosActuales.filter(p => p.temp).map(p => ({
                plato_id: p.plato_id,
                cantidad: p.cantidad,
                observaciones: p.observaciones || null
            }));
            
            if (pedidosData.length === 0) {
                notyf.error('Debe agregar al menos un pedido');
                return;
            }
            
            $.ajax({
                url: '{{ route("comandas.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    mesa_id: currentMesaId,
                    pedidos: pedidosData,
                    observaciones: $('#observacionesInput').val() || null
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    if (response.success) {
                        notyf.success('Comanda creada exitosamente');
                        $('#comandaModal').modal('hide');
                        
                        // Limpiar variables globales
                        currentComandaId = null;
                        pedidosActuales = [];
                        totalComandaActual = 0;
                        
                        // Recargar mesas después de un pequeño delay
                        setTimeout(() => {
                            loadMesas();
                        }, 500);
                    } else {
                        notyf.error(response.message || 'Error al crear la comanda');
                    }
                },
                error: function(xhr) {
                    console.log('Error al crear comanda:', xhr);
                    console.log('Status:', xhr.status);
                    console.log('Response:', xhr.responseJSON);
                    
                    let message = 'Error al crear la comanda';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                        
                        // Si hay una comanda existente, mostrarla
                        if (xhr.responseJSON.comanda_existente) {
                            console.log('Comanda existente encontrada:', xhr.responseJSON.comanda_existente);
                            mostrarComandaExistente(xhr.responseJSON.comanda_existente);
                            return;
                        }
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        message = 'Errores de validación: ';
                        for (let field in errors) {
                            message += errors[field][0] + ' ';
                        }
                    }
                    notyf.error(message);
                }
            });
        }
    }

    // Cerrar comanda
    function cerrarComanda() {
        if (!currentComandaId) {
            notyf.error('No hay comanda para cerrar');
            return;
        }

        if (confirm('¿Está seguro de cerrar esta comanda? Esta acción no se puede deshacer.')) {
            $.ajax({
                url: `/comandas/${currentComandaId}/cerrar`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        notyf.success('Comanda cerrada exitosamente');
                        $('#comandaModal').modal('hide');
                        loadMesas();
                    }
                },
                error: function(xhr) {
                    let message = 'Error al cerrar la comanda';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    notyf.error(message);
                }
            });
        }
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

    // Crear Mesa
    $(document).ready(function() {
        // Event listeners para comandas
        $('#categoriaSelect').on('change', function() {
            let categoriaId = $(this).val();
            cargarPlatosPorCategoria(categoriaId);
        });

        $('#agregarPedidoBtn').on('click', function() {
            agregarPedido();
        });

        $('#guardarComandaBtn').on('click', function() {
            guardarComanda();
        });

        $('#cerrarComandaBtn').on('click', function() {
            cerrarComanda();
        });

        $('#editarComandaBtn').on('click', function() {
            editarComandaExistente();
        });

        // Eliminar Mesa
        window.eliminarMesa = function() {
            $('#mesaOptionsModal').modal('hide');

            if (confirm(`¿Está seguro de que desea eliminar la Mesa ${currentMesaNumero}?`)) {
                $.ajax({
                    url: `/mesas/${currentMesaId}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.success) {
                            notyf.success(response.message);
                            // Recargar solo la sección de mesas
                            loadMesas();
                        }
                    },
                    error: function() {
                        notyf.error('Error al eliminar la mesa');
                    }
                });
            }
        };

        $('#createMesaForm').on('submit', function(e) {
            e.preventDefault();
            console.log('Form submit intercepted by AJAX');

            $.ajax({
                url: '{{ route("mesas.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (response.success) {
                        $('#createMesaModal').modal('hide');
                        $('#createMesaForm')[0].reset();
                        notyf.success(response.message);
                        // Recargar solo la sección de mesas
                        loadMesas();
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = 'Error al crear la mesa: ';
                        for (let field in errors) {
                            errorMessage += errors[field][0] + ' ';
                        }
                        notyf.error(errorMessage);
                    } else {
                        notyf.error('Error al crear la mesa');
                    }
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
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (response.success) {
                        $('#editMesaModal').modal('hide');
                        notyf.success(response.message);
                        // Recargar solo la sección de mesas
                        loadMesas();
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = 'Error al actualizar la mesa: ';
                        for (let field in errors) {
                            errorMessage += errors[field][0] + ' ';
                        }
                        notyf.error(errorMessage);
                    } else {
                        notyf.error('Error al actualizar la mesa');
                    }
                }
            });
        });
    });
</script>
@endsection
