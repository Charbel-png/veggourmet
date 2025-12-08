<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Puesto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    // GET /empleados
    public function index()
    {
        $user = auth()->user();

        if (! $user || $user->tipo !== 'admin') {
            abort(403, 'Solo el admin puede ver empleados.');
        }

        $empleados = Empleado::with('puesto')->orderBy('nombre')->paginate(15);

        return view('empleados.index', compact('empleados'));
    }

    // GET /empleados/create
    public function create()
    {
        $user = auth()->user();

        if (! $user || $user->tipo !== 'admin') {
            abort(403);
        }

        $puestos = Puesto::orderBy('nombre')->get();

        return view('empleados.create', compact('puestos'));
    }

    // POST /empleados
    public function store(Request $request)
    {
        $user = auth()->user();

        if (! $user || $user->tipo !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nombre'    => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'id_puesto' => 'required|exists:puestos,id_puesto',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        // 1) Crear empleado
        $empleado = Empleado::create([
            'nombre'    => $request->nombre,
            'email'     => $request->email,
            'id_puesto' => $request->id_puesto,
        ]);

        // 2) Crear usuario tipo operador
        User::create([
            'name'     => $empleado->nombre,
            'email'    => $empleado->email,
            'password' => Hash::make($request->password),
            'tipo'     => 'operador',
        ]);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado / operador creado correctamente.');
    }

    // GET /empleados/{empleado}/edit
    public function edit(Empleado $empleado)
    {
        $user = auth()->user();

        if (! $user || $user->tipo !== 'admin') {
            abort(403);
        }

        $puestos = Puesto::orderBy('nombre')->get();

        return view('empleados.edit', compact('empleado', 'puestos'));
    }

    // PUT /empleados/{empleado}
    public function update(Request $request, Empleado $empleado)
    {
        $user = auth()->user();

        if (! $user || $user->tipo !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nombre'    => 'required|string|max:100',
            'email'     => 'required|email',
            'id_puesto' => 'required|exists:puestos,id_puesto',
        ]);

        $empleado->update([
            'nombre'    => $request->nombre,
            'email'     => $request->email,
            'id_puesto' => $request->id_puesto,
        ]);

        // Opcional: podrías buscar el User y actualizar nombre/email también

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado correctamente.');
    }

    // DELETE /empleados/{empleado}
    public function destroy(Empleado $empleado)
    {
        $user = auth()->user();

        if (! $user || $user->tipo !== 'admin') {
            abort(403);
        }

        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado correctamente.');
    }
}
