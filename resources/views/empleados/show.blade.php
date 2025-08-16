@extends('layouts.app')

@section('content')
<h2 class="mb-4">Detalles del Empleado</h2>

<div class="card">
    <div class="card-body">
        <p><strong>DNI:</strong> {{ $empleado->dni }}</p>
        <p><strong>Nombre:</strong> {{ $empleado->nombre }}</p>
        <p><strong>Apellido:</strong> {{ $empleado->apellido }}</p>
        <p><strong>WhatsApp:</strong> {{ $empleado->whatsapp }}</p>
        <p><strong>Dirección:</strong> {{ $empleado->direccion }}</p>
        <p><strong>Fecha de Nacimiento:</strong> {{ $empleado->fechanac }}</p>
        <p><strong>Sueldo:</strong> S/. {{ number_format($empleado->sueldo, 2) }}</p>
        <p><strong>Cargo:</strong> {{ $empleado->cargo }}</p>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
