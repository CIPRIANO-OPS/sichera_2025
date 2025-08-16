@extends('layouts.app')

@section('content')
<h1>Listado de Ventas</h1>
<a href="{{ route('ventas.create') }}">Crear nueva venta</a>

<table border="1">
    <thead>
        <tr>
            <th>ID Venta</th>
            <th>ID Pedido</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->idventa }}</td>
            <td>{{ $venta->idpedidos }}</td>
            <td>{{ $venta->nombreCliente }}</td>
            <td>{{ $venta->total }}</td>
            <td>
                <a href="{{ route('ventas.show', $venta->idventa) }}">Ver</a>
                <a href="{{ route('ventas.edit', $venta->idventa) }}">Editar</a>
                <form action="{{ route('ventas.destroy', $venta->idventa) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection