<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        // Todas las solicitudes de admin / operador, con su estado
        $solicitudes = User::whereIn('tipo', ['admin', 'operador'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        if (auth()->user()->tipo === 'cliente') {
            $pedidos = $pedidos->where('p.id_cliente', auth()->user()->id_cliente);
        }

        return view('admin.solicitudes.index', compact('solicitudes'));
    }

    public function aprobar(User $user)
    {
        $user->estado = 'aprobado';
        $user->save();

        // Crear / actualizar registro en empleados para admin u operador
        if (in_array($user->tipo, ['admin', 'operador'])) {
            Empleado::updateOrCreate(
                ['id_usuario' => $user->id],
                [
                    'nombre' => $user->name,
                    // completa aquí más campos si los tienes:
                    // 'apellido_paterno' => '...',
                    // 'apellido_materno' => '...',
                ]
            );
        }

        return back()->with('success', 'Solicitud aprobada correctamente.');
    }

    public function rechazar(User $user)
    {
        // Si todavía está pendiente, sólo marcamos como rechazado
        if ($user->estado === 'pendiente') {
            $user->estado = 'rechazado';
            $user->save();

            return back()->with('status', 'Solicitud rechazada correctamente.');
        }

        // Si ya estaba aprobada / rechazada, ahora sí eliminamos el registro
        $user->delete();

        return back()->with('status', 'Registro de solicitud eliminado.');
    }
}
