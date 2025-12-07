@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre del producto</label>
    <input type="text"
           name="nombre"
           id="nombre"
           class="form-control"
           value="{{ old('nombre', $producto->nombre ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea name="descripcion"
              id="descripcion"
              rows="3"
              class="form-control">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="precio_venta" class="form-label">Precio de venta</label>
    <input type="number"
           step="0.01"
           name="precio_venta"
           id="precio_venta"
           class="form-control"
           value="{{ old('precio_venta', $producto->precio_venta ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label for="id_categoria" class="form-label">Categoría</label>
    <select name="id_categoria" id="id_categoria" class="form-select" required>
        <option value="">-- Selecciona una categoría --</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id_categoria }}"
                {{ (old('id_categoria', $producto->id_categoria ?? null) == $categoria->id_categoria) ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="imagen" class="form-label">Nombre de imagen</label>
    <input type="text"
           name="imagen"
           id="imagen"
           class="form-control"
           value="{{ old('imagen', $producto->imagen ?? '') }}">
    <small class="text-muted">Ejemplo: ensaladas.jpg (no se muestra ningún ID)</small>
</div>

<div class="mb-3">
    <label for="estado" class="form-label">Estado</label>
    <select name="estado" id="estado" class="form-select">
        <option value="1" {{ old('estado', $producto->estado ?? 1) == 1 ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ old('estado', $producto->estado ?? 1) == 0 ? 'selected' : '' }}>Inactivo</option>
    </select>
</div>
