@extends('layouts.app')

@section('content')
<h1>Editar Venta</h1>

<form action="{{ route('ventas.update', $venta->idventa) }}" method="POST">
    @csrf
    @method('PUT')

    <label>ID Pedido:</label>
    <input type="text" name="idpedidos" value="{{ $venta->idpedidos }}"><br>

    <label>Nombre Cliente:</label>
    <input type="text" name="nombreCliente" value="{{ $venta->nombreCliente }}"><br>

    <label>Total:</label>
    <input type="number" step="0.01" name="total" value="{{ $venta->total }}"><br>

    <button type="submit">Actualizar</button>
</form>
@endsection