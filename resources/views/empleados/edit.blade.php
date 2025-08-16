@extends('layouts.app')

@section('content')
<h2 class="mb-4">Editar Empleado</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('empleados.update', $empleado) }}" method="POST" class="row g-3">
    @csrf @method('PUT')

    <div class="col-md-6">
        <label class="form-label">DNI</label>
        <input type="text" name="dni" class="form-control" value="{{ old('dni', $empleado->dni) }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $empleado->nombre) }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Apellido</label>
        <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $empleado->apellido) }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">WhatsApp</label>
        <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $empleado->whatsapp) }}">
    </div>

    <div class="col-md-12">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $empleado->direccion) }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Fecha de Nacimiento</label>
        <input type="date" name="fechanac" class="form-control" value="{{ old('fechanac', $empleado->fechanac) }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Sueldo</label>
        <input type="number" step="0.01" name="sueldo" class="form-control" value="{{ old('sueldo', $empleado->sueldo) }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Cargo</label>
        <input type="text" name="cargo" class="form-control" value="{{ old('cargo', $empleado->cargo) }}">
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
@endsection