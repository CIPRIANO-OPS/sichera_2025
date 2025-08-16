<div class="mb-3">
    <label>Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $cliente->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label>Apellido</label>
    <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $cliente->apellido ?? '') }}">
</div>

<div class="mb-3">
    <label>Correo</label>
    <input type="email" name="correo" class="form-control" value="{{ old('correo', $cliente->correo ?? '') }}">
</div>

<div class="mb-3">
    <label>Celular</label>
    <input type="text" name="celular" class="form-control" value="{{ old('celular', $cliente->celular ?? '') }}">
</div>

<div class="mb-3">
    <label>Teléfono</label>
    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono ?? '') }}">
</div>

<div class="mb-3">
    <label>Fecha de Nacimiento</label>
    <input type="date" name="fecha_nac" class="form-control" value="{{ old('fecha_nac', $cliente->fecha_nac ?? '') }}">
</div>

<div class="mb-3">
    <label>Dirección</label>
    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion ?? '') }}">
</div>