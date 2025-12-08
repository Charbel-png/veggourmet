@csrf

<div class="mb-3">
    <label for="id_cliente" class="form-label">Cliente (opcional)</label>
    <select name="id_cliente" id="id_cliente" class="form-select">
        <option value="">Sin cliente</option>
        @foreach($clientes as $cliente)
            <option value="{{ $cliente->id_cliente }}"
                @selected(old('id_cliente', $pedido->id_cliente ?? null) == $cliente->id_cliente)>
                {{ $cliente->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="fecha" class="form-label">Fecha y hora</label>
    <input type="datetime-local"
           name="fecha"
           id="fecha"
           class="form-control"
           value="{{ old('fecha', $fechaDefault ?? null) }}">
</div>

<div class="mb-3">
    <label for="id_estado" class="form-label">Estado</label>
    <select name="id_estado" id="id_estado" class="form-select">
        @foreach($estados as $estado)
            <option value="{{ $estado->id_estado }}"
                @selected(old('id_estado', $pedido->id_estado ?? null) == $estado->id_estado)>
                {{ $estado->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="tipo" class="form-label">Tipo</label>
    <select name="tipo" id="tipo" class="form-select">
        @php
            $tipoValue = old('tipo', $pedido->tipo ?? 'Local');
        @endphp
        <option value="Local"    {{ $tipoValue === 'Local' ? 'selected' : '' }}>Local</option>
        <option value="Delivery" {{ $tipoValue === 'Delivery' ? 'selected' : '' }}>Delivery</option>
    </select>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-success" title="Guardar">
        <i class="bi bi-check-lg"></i>
    </button>

    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary" title="Cancelar">
        <i class="bi bi-x-lg"></i>
    </a>
</div>
