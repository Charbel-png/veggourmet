{{-- resources/views/productos/form.blade.php --}}

<div class="mb-3">
    <label for="id_categoria" class="form-label">Categoría *</label>
    <select name="id_categoria" id="id_categoria"
            class="form-select @error('id_categoria') is-invalid @enderror"
            required>
        <option value="">-- Selecciona una categoría --</option>
        @foreach ($categorias as $cat)
            <option value="{{ $cat->id_categoria }}"
                {{ old('id_categoria', $producto->id_categoria ?? '') == $cat->id_categoria ? 'selected' : '' }}>
                {{ $cat->nombre }}
            </option>
        @endforeach
    </select>
    @error('id_categoria')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre *</label>
    <input type="text"
           id="nombre"
           name="nombre"
           class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $producto->nombre ?? '') }}"
           required>
    @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea id="descripcion"
              name="descripcion"
              rows="3"
              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="precio_venta" class="form-label">Precio de venta *</label>
    <input type="number"
           step="0.01"
           min="0"
           id="precio_venta"
           name="precio_venta"
           class="form-control @error('precio_venta') is-invalid @enderror"
           value="{{ old('precio_venta', $producto->precio_venta ?? '') }}"
           required>
    @error('precio_venta')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="estado" class="form-label">Estado *</label>
    <select name="estado" id="estado"
            class="form-select @error('estado') is-invalid @enderror"
            required>
        <option value="1" {{ old('estado', $producto->estado ?? 1) == 1 ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ old('estado', $producto->estado ?? 1) == 0 ? 'selected' : '' }}>Inactivo</option>
    </select>
    @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="imagen" class="form-label">Imagen (opcional)</label>
    <input type="file"
           id="imagen"
           name="imagen"
           class="form-control @error('imagen') is-invalid @enderror"
           accept="image/*">
    @error('imagen')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if (!empty($producto->imagen))
        <small class="text-muted d-block mt-1">
            Imagen actual:
            <img src="{{ asset('storage/'.$producto->imagen) }}"
                 alt="Imagen actual"
                 style="max-height:60px;">
        </small>
    @endif
</div>