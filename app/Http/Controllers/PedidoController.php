<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        return 'Listado de pedidos (CRUD pendiente)';
    }

    public function create()
    {
        return 'Formulario para crear pedido (CRUD pendiente)';
    }

    public function store(Request $request) {}
    public function show($id) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
