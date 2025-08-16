@extends('layouts.app')

@section('content')
<h2 class="mb-4">Registrar Nuevo Empleado</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('empleados.store') }}" method="POST" class="row g-3">
    @csrf

    <div class="col-md-6">
        <label class="form-label">DNI</label>
        <input type="text" name="dni" class="form-control" value="{{ old('dni') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Apellido</label>
        <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">WhatsApp</label>
        <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}">
    </div>

    <div class="col-md-12">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Fecha de Nacimiento</label>
        <input type="date" name="fechanac" class="form-control" value="{{ old('fechanac') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Sueldo</label>
        <input type="number" step="0.01" name="sueldo" class="form-control" value="{{ old('sueldo') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Cargo</label>
        <input type="text" name="cargo" class="form-control" value="{{ old('cargo') }}">
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
@endsection