@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre(s)</label>
    <input type="text"
           name="nombre"
           id="nombre"
           class="form-control"
           value="{{ old('nombre', $cliente->nombre ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label for="ap_paterno" class="form-label">Apellido paterno</label>
    <input type="text"
           name="ap_paterno"
           id="ap_paterno"
           class="form-control"
           value="{{ old('ap_paterno', $cliente->ap_paterno ?? '') }}">
</div>

<div class="mb-3">
    <label for="ap_materno" class="form-label">Apellido materno</label>
    <input type="text"
           name="ap_materno"
           id="ap_materno"
           class="form-control"
           value="{{ old('ap_materno', $cliente->ap_materno ?? '') }}">
</div>

<div class="mb-3">
    <label for="email" class="form-label">Correo electrónico</label>
    <input type="email"
           name="email"
           id="email"
           class="form-control"
           value="{{ old('email', $cliente->email ?? '') }}">
</div>
