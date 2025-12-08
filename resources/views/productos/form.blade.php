@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text"
           name="nombre"
           id="nombre"
           class="form-control"
           value="{{ old('nombre', $producto->nombre ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label for="id_categoria" class="form-label">Categoría</label>
    <select name="id_categoria" id="id_categoria" class="form-select" required>
        <option value="">Selecciona una categoría</option>
        @foreach($categorias as $cat)
            <option value="{{ $cat->id_categoria }}"
                @selected(old('id_categoria', $producto->id_categoria ?? '') == $cat->id_categoria)>
                {{ $cat->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea name="descripcion"
              id="descripcion"
              class="form-control"
              rows="3">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="imagen" class="form-label">Imagen (archivo o nombre)</label>
    <input type="text"
           name="imagen"
           id="imagen"
           class="form-control"
           value="{{ old('imagen', $producto->imagen ?? '') }}">
    <small class="text-muted">Ejemplo: ensaladas.jpeg</small>
</div>

<div class="mb-3">
    <label for="precio_venta" class="form-label">Precio de venta</label>
    <input type="number"
           step="0.01"
           min="0"
           name="precio_venta"
           id="precio_venta"
           class="form-control"
           value="{{ old('precio_venta', $producto->precio_venta ?? 0) }}"
           required>
</div>

@php
    $inv = $producto->inventario ?? null;
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number"
               step="0.01"
               min="0"
               name="stock"
               id="stock"
               class="form-control"
               value="{{ old('stock', $inv->stock ?? 0) }}"
               required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="stock_minimo" class="form-label">Stock mínimo</label>
        <input type="number"
               step="0.01"
               min="0"
               name="stock_minimo"
               id="stock_minimo"
               class="form-control"
               value="{{ old('stock_minimo', $inv->stock_minimo ?? 0) }}"
               required>
    </div>
</div>
