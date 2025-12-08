<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // LISTA de usuarios PENDIENTES
    public function index()
    {
        $user = auth()->user();

        if (! $user || $user->tipo !== 'admin') {
            abort(403, 'No tienes permisos para ver esta sección.');
        }

        $pendientes = User::where('estado', 'pendiente')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.solicitudes', compact('pendientes'));
    }

    // APROBAR usuario
    public function aprobar(User $user)
    {
        $admin = auth()->user();

        if (! $admin || $admin->tipo !== 'admin') {
            abort(403, 'No tienes permisos para esta acción.');
        }

        if ($user->estado === 'pendiente') {
            $user->estado = 'aprobado';
            $user->save();
        }

        return back()->with('success', 'Usuario aprobado correctamente.');
    }

    // RECHAZAR usuario
    public function rechazar(User $user)
    {
        $admin = auth()->user();

        if (! $admin || $admin->tipo !== 'admin') {
            abort(403, 'No tienes permisos para esta acción.');
        }

        if ($user->estado === 'pendiente') {
            $user->estado = 'rechazado';
            $user->save();     // o $user->delete() si quieres borrarlo
        }

        return back()->with('success', 'Solicitud rechazada.');
    }
}
