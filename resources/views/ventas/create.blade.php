@extends('layouts.app')

@section('content')
<h1>Crear Venta</h1>

<form action="{{ route('ventas.store') }}" method="POST">
    @csrf
    <label>ID Venta:</label>
    <input type="text" name="idventa"><br>

    <label>ID Pedido:</label>
    <input type="text" name="idpedidos"><br>

    <label>Nombre Cliente:</label>
    <input type="text" name="nombreCliente"><br>

    <label>Total:</label>
    <input type="number" step="0.01" name="total"><br>

    <button type="submit">Guardar</button>
</form>
@endsection