@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle del Cliente</h2>

    <ul class="list-group">
        <li class="list-group-item"><strong>Nombre:</strong> {{ $cliente->nombre }}</li>
        <li class="list-group-item"><strong>Apellido:</strong> {{ $cliente->apellido }}</li>
        <li class="list-group-item"><strong>Celular:</strong> {{ $cliente->celular }}</li>
        <li class="list-group-item"><strong>Fecha de Nacimiento:</strong> {{ $cliente->fechaNac }}</li>
        <li class="list-group-item"><strong>Dirección:</strong> {{ $cliente->dirección }}</li>
        <li class="list-group-item"><strong>Correo:</strong> {{ $cliente->correo }}</li>
        
       
        
        
    </ul>

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection