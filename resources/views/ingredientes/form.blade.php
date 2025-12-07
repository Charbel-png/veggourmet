@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text"
           name="nombre"
           id="nombre"
           class="form-control"
           value="{{ old('nombre', $ingrediente->nombre ?? '') }}"
           required>
    @error('nombre')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="id_unidad" class="form-label">Unidad de medida</label>
    <select name="id_unidad" id="id_unidad" class="form-select" required>
        <option value="">-- Selecciona una unidad --</option>
        @foreach($unidades as $u)
            <option value="{{ $u->id_unidad }}"
                {{ old('id_unidad', $ingrediente->id_unidad ?? '') == $u->id_unidad ? 'selected' : '' }}>
                {{ $u->nombre }} ({{ $u->abreviatura }})
            </option>
        @endforeach
    </select>
    @error('id_unidad')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="activo" class="form-label">Activo</label>
    @php
        $activo = old('activo', $ingrediente->activo ?? 1);
    @endphp
    <select name="activo" id="activo" class="form-select" required>
        <option value="1" {{ $activo == 1 ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ $activo == 0 ? 'selected' : '' }}>No</option>
    </select>
    @error('activo')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>
