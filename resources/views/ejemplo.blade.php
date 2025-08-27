@extends('layouts.master')

@section('title', 'Ejemplo - Minaati Dashboard')
@section('meta_description', 'Vista de ejemplo usando la plantilla HTML original integrada con Laravel')

@section('breadcrumb')
<div class="row align-items-center">
    <div class="col-md-8 col-lg-8">
        <h4 class="page-title">Vista de Ejemplo</h4>
        <div class="breadcrumb-list">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ejemplo</li>
            </ol>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="widgetbar">
            <button class="btn btn-primary">Nuevo Elemento</button>
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- Start Breadcrumbbar -->

<!-- End Breadcrumbbar -->

<!-- Start Contentbar -->
<!-- Start row -->
<div class="row">
    <!-- Start col -->
    <div class="col-lg-12 col-xl-12">
        <div class="card m-b-30">
            <div class="card-header">
                <h5 class="card-title">Ejemplo de Integración</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">¡Integración Exitosa!</h4>
                            <p>Esta vista demuestra cómo la plantilla HTML original ha sido perfectamente integrada con Laravel y el sistema de autenticación.</p>
                            <hr>
                            <p class="mb-0">Usuario actual: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
</div>
<!-- End row -->

<!-- End row -->
<!-- End Contentbar -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Mensaje de bienvenida
        toastr.success('Vista de ejemplo cargada correctamente', 'Éxito');
    });
</script>
@endsection