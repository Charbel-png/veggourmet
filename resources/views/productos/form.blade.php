@php
    // Aseguramos tener el inventario cargado (solo para mostrar valores)
    $inv = $producto->inventario ?? null;
@endphp

<div class="row g-3">

    {{-- Nombre --}}
    <div class="col-12">
        <label class="form-label">Nombre *</label>
        <input type="text"
               name="nombre"
               class="form-control @error('nombre') is-invalid @enderror"
               value="{{ old('nombre', $producto->nombre) }}"
               required>
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Categoría --}}
    <div class="col-12">
        <label class="form-label">Categoría *</label>
        <select name="id_categoria"
                class="form-select @error('id_categoria') is-invalid @enderror"
                required>
            <option value="">Selecciona una categoría...</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id_categoria }}"
                    @selected(old('id_categoria', $producto->id_categoria) == $cat->id_categoria)>
                    {{ $cat->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_categoria')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Descripción --}}
    <div class="col-12">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion"
                  rows="3"
                  class="form-control @error('descripcion') is-invalid @enderror"
                  placeholder="Descripción breve del producto">{{ old('descripcion', $producto->descripcion) }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Imagen: texto y archivo --}}
    <div class="col-12">
        <label class="form-label">Imagen (URL o ruta interna)</label>
        <input type="text"
               name="imagen"
               class="form-control mb-2 @error('imagen') is-invalid @enderror"
               value="{{ old('imagen', $producto->imagen) }}"
               placeholder="https://... o img/productos/archivo.jpg">
        @error('imagen')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <label class="form-label small text-muted mb-1">
            O bien selecciona un archivo de imagen (tendrá prioridad sobre el campo de texto):
        </label>
        <input type="file"
               name="imagen_archivo"
               accept="image/*"
               class="form-control @error('imagen_archivo') is-invalid @enderror">
        @error('imagen_archivo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if(!empty($producto->imagen))
            @php
                $preview = $producto->imagen;
                if (!preg_match('#^https?://#', $preview)) {
                    $preview = asset($preview);
                }
            @endphp
            <div class="mt-2">
                <small class="text-muted d-block mb-1">Vista previa:</small>
                <img src="{{ $preview }}"
                     alt="Imagen actual"
                     style="max-width: 160px; max-height: 160px; object-fit: cover;"
                     class="border rounded">
            </div>
        @endif
    </div>

    {{-- Precio --}}
    <div class="col-md-4">
        <label class="form-label">Precio venta *</label>
        <input type="number"
               step="0.01"
               min="0"
               name="precio_venta"
               class="form-control @error('precio_venta') is-invalid @enderror"
               value="{{ old('precio_venta', $producto->precio_venta) }}"
               required>
        @error('precio_venta')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Stock actual (solo vista) --}}
    <div class="col-md-4">
        <label class="form-label">Stock actual (solo vista)</label>
        <input type="number"
               class="form-control"
               value="{{ $inv?->stock ?? 0 }}"
               disabled>
    </div>

    {{-- Stock mínimo (solo vista) --}}
    <div class="col-md-4">
        <label class="form-label">Stock mínimo (solo vista)</label>
        <input type="number"
               class="form-control"
               value="{{ $inv?->stock_minimo ?? 0 }}"
               disabled>
    </div>

    {{-- Estado --}}
    <div class="col-md-4">
        <label class="form-label">Estado *</label>
        <select name="estado"
                class="form-select @error('estado') is-invalid @enderror"
                required>
            <option value="1" @selected(old('estado', $producto->estado) == 1)>Activo</option>
            <option value="0" @selected(old('estado', $producto->estado) == 0)>Inactivo</option>
        </select>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
