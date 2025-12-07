@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text"
           name="nombre"
           id="nombre"
           class="form-control"
           value="{{ old('nombre', $cliente->nombre ?? '') }}"
           required>
    @error('nombre')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="ap_paterno" class="form-label">Apellido paterno</label>
    <input type="text"
           name="ap_paterno"
           id="ap_paterno"
           class="form-control"
           value="{{ old('ap_paterno', $cliente->ap_paterno ?? '') }}">
    @error('ap_paterno')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="ap_materno" class="form-label">Apellido materno</label>
    <input type="text"
           name="ap_materno"
           id="ap_materno"
           class="form-control"
           value="{{ old('ap_materno', $cliente->ap_materno ?? '') }}">
    @error('ap_materno')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="imagen" class="form-label">Imagen (archivo)</label>
    <input type="text" name="imagen" id="imagen"
           class="form-control"
           value="{{ old('imagen', $producto->imagen ?? '') }}">
    <small class="text-muted">Ejemplo: ensaladas.jpg</small>
</div>
