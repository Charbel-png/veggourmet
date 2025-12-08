<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Lista de clientes (admin y operador)
    public function index()
    {
        $user = auth()->user();

        if (! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'No tienes permisos para ver clientes.');
        }

        $clientes = Cliente::orderBy('nombre')->paginate(15);

        return view('clientes.index', compact('clientes'));
    }

    // Formulario de creación (solo admin)
    public function create()
    {
        $user = auth()->user();

        if ($user->tipo !== 'admin') {
            abort(403, 'Solo el administrador puede crear clientes.');
        }

        return view('clientes.create');
    }

    // Guardar nuevo cliente (solo admin)
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->tipo !== 'admin') {
            abort(403, 'Solo el administrador puede crear clientes.');
        }

        $data = $request->validate([
            'nombre'      => 'required|string|max:100',
            'ap_paterno'  => 'nullable|string|max:100',
            'ap_materno'  => 'nullable|string|max:100',
        ]);

        Cliente::create($data);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    // Formulario de edición (admin y operador)
    public function edit(Cliente $cliente)
    {
        $user = auth()->user();

        if (! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'No tienes permisos para editar clientes.');
        }

        return view('clientes.edit', compact('cliente'));
    }

    // Actualizar cliente (admin y operador)
    public function update(Request $request, Cliente $cliente)
    {
        $user = auth()->user();

        if (! in_array($user->tipo, ['admin', 'operador'])) {
            abort(403, 'No tienes permisos para actualizar clientes.');
        }

        $data = $request->validate([
            'nombre'      => 'required|string|max:100',
            'ap_paterno'  => 'nullable|string|max:100',
            'ap_materno'  => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255'
        ]);

        $cliente->update($data);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    // Eliminar cliente (solo admin)
    public function destroy(Cliente $cliente)
    {
        $user = auth()->user();

        if ($user->tipo !== 'admin') {
            abort(403, 'Solo el administrador puede eliminar clientes.');
        }

        // Aquí de momento hacemos DELETE físico.
        // Si luego quieres baja lógica, le agregamos campo `activo` a la tabla.
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
