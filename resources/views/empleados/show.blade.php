@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle del Empleado</h2>

    <ul class="list-group">
        <li class="list-group-item"><strong>DNI:</strong> {{ $empleado->dni }}</li>
        <li class="list-group-item"><strong>Nombre:</strong> {{ $empleado->nombre }}</li>
        <li class="list-group-item"><strong>Apellido:</strong> {{ $empleado->apellido }}</li>
        <li class="list-group-item"><strong>Whatsapp:</strong> {{ $empleado->whatsapp }}</li>
        <li class="list-group-item"><strong>Direccion:</strong> {{ $empleado->direccion }}</li>
        <li class="list-group-item"><strong>Fecha de Nacimiento:</strong> {{ $empleado->fechanac }}</li>
        <li class="list-group-item"><strong>Sueldo:</strong> S/.{{ number_format($empleado->sueldo, 2) }}</li>
        <li class="list-group-item"><strong>Cargo:</strong> {{ $empleado->cargo }}</li>
        
    </ul>
    <div class="mt-3">
        <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
