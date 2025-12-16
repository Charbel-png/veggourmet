{{-- resources/views/productos/form.blade.php --}}
{{-- Aquí NO va <form>, sólo los campos --}}

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre *</label>
    <input type="text" name="nombre" id="nombre"
           class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $producto->nombre ?? '') }}" required>
    @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="id_categoria" class="form-label">Categoría *</label>
    <select name="id_categoria" id="id_categoria"
            class="form-select @error('id_categoria') is-invalid @enderror" required>
        <option value="">Seleccione una categoría</option>
        @foreach($categorias as $cat)
            <option value="{{ $cat->id_categoria }}"
                {{ (int) old('id_categoria', $producto->id_categoria ?? 0) === (int) $cat->id_categoria ? 'selected' : '' }}>
                {{ $cat->nombre }}
            </option>
        @endforeach
    </select>
    @error('id_categoria')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea name="descripcion" id="descripcion" rows="3"
              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="imagen" class="form-label">Imagen (URL o ruta interna)</label>
    <input
        type="text"
        name="imagen"
        id="imagen"
        class="form-control @error('imagen') is-invalid @enderror"
        value="{{ old('imagen', $producto->imagen ?? '') }}"
        placeholder="https://...jpg  o  img/productos/avena_overnight.jpg">
    @error('imagen')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



<div class="row">
    <div class="col-md-4 mb-3">
        <label for="precio_venta" class="form-label">Precio venta *</label>
        <input type="number" step="0.01"
               name="precio_venta" id="precio_venta"
               class="form-control @error('precio_venta') is-invalid @enderror"
               value="{{ old('precio_venta', $producto->precio_venta ?? 0) }}" required>
        @error('precio_venta')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="stock" class="form-label">Stock actual *</label>
        <input type="number" step="0.01"
               name="stock" id="stock"
               class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $producto->inventario->stock ?? 0) }}" required>
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="stock_minimo" class="form-label">Stock mínimo *</label>
        <input type="number" step="0.01"
               name="stock_minimo" id="stock_minimo"
               class="form-control @error('stock_minimo') is-invalid @enderror"
               value="{{ old('stock_minimo', $producto->inventario->stock_minimo ?? 0) }}" required>
        @error('stock_minimo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="estado" class="form-label">Estado *</label>
    <select name="estado" id="estado"
            class="form-select @error('estado') is-invalid @enderror" required>
        <option value="1" {{ old('estado', $producto->estado ?? 1) == 1 ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ old('estado', $producto->estado ?? 1) == 0 ? 'selected' : '' }}>Inactivo</option>
    </select>
    @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>