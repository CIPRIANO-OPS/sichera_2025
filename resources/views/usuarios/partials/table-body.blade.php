@if($usuarios->count() > 0)
    @foreach($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->id }}</td>
            <td>{{ $usuario->name }}</td>
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
            <td>
                @include('usuarios.partials.actions', ['usuario' => $usuario])
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="5" class="text-center">No se encontraron usuarios</td>
    </tr>
@endif