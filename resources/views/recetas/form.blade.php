@csrf

<div class="mb-3">
    <label for="id_ingrediente" class="form-label">Ingrediente</label>
    <select name="id_ingrediente" id="id_ingrediente" class="form-select" required>
        <option value="">-- Selecciona un ingrediente --</option>
        @foreach($ingredientes as $ing)
            <option value="{{ $ing->id_ingrediente }}"
                {{ old('id_ingrediente') == $ing->id_ingrediente ? 'selected' : '' }}>
                {{ $ing->nombre }}
            </option>
        @endforeach
    </select>
    @error('id_ingrediente')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="cantidad" class="form-label">Cantidad</label>
    <input type="number"
           step="0.001"
           min="0"
           name="cantidad"
           id="cantidad"
           class="form-control"
           value="{{ old('cantidad', $receta->cantidad ?? '') }}"
           required>
    @error('cantidad')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>
