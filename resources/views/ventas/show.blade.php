@extends('layouts.app')

@section('content')
<h1>Detalle de Venta</h1>

<p><strong>ID Venta:</strong> {{ $venta->idventa }}</p>
<p><strong>ID Pedido:</strong> {{ $venta->idpedidos }}</p>
<p><strong>Cliente:</strong> {{ $venta->nombreCliente }}</p>
<p><strong>Total:</strong> {{ $venta->total }}</p>

<a href="{{ route('ventas.index') }}">Volver al listado</a>
@endsection