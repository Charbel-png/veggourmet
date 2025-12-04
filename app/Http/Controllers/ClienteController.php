<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // GET /clientes
    public function index()
    {
        $clientes = Cliente::orderBy('id_cliente', 'ASC')->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    // GET /clientes/create
    public function create()
    {
        return view('clientes.create');
    }

    // POST /clientes
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:100',
            'ap_paterno'  => 'nullable|string|max:100',
            'ap_materno'  => 'nullable|string|max:100',
        ]);

        Cliente::create($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    // GET /clientes/{cliente}/edit
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    // PUT /clientes/{cliente}
    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:100',
            'ap_paterno'  => 'nullable|string|max:100',
            'ap_materno'  => 'nullable|string|max:100',
        ]);

        $cliente->update($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    // DELETE /clientes/{cliente}
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
