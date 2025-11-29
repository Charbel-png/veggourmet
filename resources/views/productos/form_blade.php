@csrf

<div class="mb-3">
    <label for="id_categoria" class="form-label">Categoría</label>
    <select name="id_categoria" id="id_categoria" class="form-select" required>
        <option value="">-- Selecciona una categoría --</option>
        @foreach($categorias as $cat)
            <option value="{{ $cat->id_categoria }}"
                {{ old('id_categoria', $producto->id_categoria ?? '') == $cat->id_categoria ? 'selected' : '' }}>
                {{ $cat->nombre }}
            </option>
        @endforeach
    </select>
    @error('id_categoria')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text"
           name="nombre"
           id="nombre"
           class="form-control"
           value="{{ old('nombre', $producto->nombre ?? '') }}"
           required>
    @error('nombre')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea name="descripcion"
              id="descripcion"
              class="form-control"
              rows="3">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
    @error('descripcion')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="estado" class="form-label">Estado</label>
    @php
        $estadoActual = old('estado', $producto->estado ?? 1);
    @endphp
    <select name="estado" id="estado" class="form-select" required>
        <option value="1" {{ $estadoActual == 1 ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ $estadoActual == 0 ? 'selected' : '' }}>Inactivo</option>
    </select>
    @error('estado')
    <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>
