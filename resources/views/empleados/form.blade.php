@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre completo</label>
    <input type="text"
           name="nombre"
           id="nombre"
           class="form-control"
           value="{{ old('nombre', $empleado->nombre ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Correo electrónico</label>
    <input type="email"
           name="email"
           id="email"
           class="form-control"
           value="{{ old('email', $empleado->email ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label for="id_puesto" class="form-label">Puesto</label>
    <select name="id_puesto"
            id="id_puesto"
            class="form-select"
            required>
        <option value="">Selecciona un puesto</option>
        @foreach($puestos as $puesto)
            <option value="{{ $puesto->id_puesto }}"
                @selected(old('id_puesto', $empleado->id_puesto ?? '') == $puesto->id_puesto)>
                {{ $puesto->nombre }}
            </option>
        @endforeach
    </select>
</div>

{{-- Solo al crear mostramos la opción de operador --}}
@if(Route::currentRouteName() === 'empleados.create')
    <hr>
    <h5>Cuenta de acceso al sistema</h5>

    <div class="form-check form-switch mb-3">
        <input class="form-check-input"
               type="checkbox"
               id="es_operador"
               name="es_operador"
               value="1"
               {{ old('es_operador') ? 'checked' : '' }}>
        <label class="form-check-label" for="es_operador">
            Dar acceso como operador
        </label>
    </div>

    <div id="campos-operador" style="{{ old('es_operador') ? '' : 'display:none;' }}">
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password"
                   name="password"
                   id="password"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
            <input type="password"
                   name="password_confirmation"
                   id="password_confirmation"
                   class="form-control">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chk = document.getElementById('es_operador');
            const box = document.getElementById('campos-operador');

            if (chk) {
                chk.addEventListener('change', function () {
                    box.style.display = this.checked ? '' : 'none';
                });
            }
        });
    </script>
@endif
