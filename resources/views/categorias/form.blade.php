@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text"
           name="nombre"
           id="nombre"
           class="form-control"
           value="{{ old('nombre', $categoria->nombre ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea name="descripcion"
              id="descripcion"
              class="form-control"
              rows="3">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
</div>