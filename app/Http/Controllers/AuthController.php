<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->filled('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email' => 'Credenciales incorrectas'])
                ->withInput($request->only('email'));
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Si no está aprobado, lo sacamos
        if ($user->estado !== 'aprobado') {
            Auth::logout();

            return back()
                ->withErrors(['email' => 'Tu cuenta aún está pendiente de aprobación por un administrador.'])
                ->withInput($request->only('email'));
        }

        // Redirección según rol
        if (in_array($user->tipo, ['admin', 'operador'])) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->tipo === 'cliente') {
            return redirect()->route('cliente.dashboard');
        }

        // fallback
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Procesar registro de cliente
    public function register(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email'     => 'required|email|unique:users,email',
            'tipo'      => 'required|in:admin,operador,cliente',
            'password'  => [
                'required',
                'string',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$/',
            ],
        ],[
            'password.regex' => 'La contraseña debe tener mínimo 6 caracteres, una mayúscula, un número y un símbolo.',
        ]);

        $nombreCompleto = trim($request->nombre . ' ' . $request->apellidos);

        // Cliente se aprueba de inmediato, admin/operador quedan pendientes
        $estado = $request->tipo === 'cliente' ? 'aprobado' : 'pendiente';

        $user = User::create([
            'name'     => $nombreCompleto,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'tipo'     => $request->tipo,
            'estado'   => $estado,
        ]);

        // Si es cliente, creamos también el registro en la tabla clientes
        if ($user->tipo === 'cliente') {

            [$apPaterno, $apMaterno] = array_pad(
                explode(' ', $request->apellidos, 2),
                2,
                ''
            );

            Cliente::create([
                'nombre'           => $request->nombre,
                'apellido_paterno' => $apPaterno,
                'apellido_materno' => $apMaterno,
                'email'            => $request->email,
                // ajusta si tienes más campos obligatorios
            ]);

            // ⬇️ AQUÍ CAMBIAMOS: YA NO SE HACE LOGIN AUTOMÁTICO
            return redirect()
                ->route('login')
                ->with('success', 'Tu cuenta de cliente se registró correctamente. Ahora puedes iniciar sesión.');
        }

        // Admin / operador: quedan pendientes, sin login automático
        return redirect()
            ->route('login')
            ->with('success', 'Tu solicitud se registró. Un administrador debe aprobar tu cuenta antes de que puedas iniciar sesión.');
    }

    // -------- LOGOUT --------

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    public function showOperatorForm()
    {
        $user = auth()->user();

        if ($user->tipo !== 'admin') {
            abort(403, 'Solo el administrador puede crear operadores.');
        }

        return view('auth.register-operator');
    }

    public function storeOperator(Request $request)
    {
        $user = auth()->user();

        if ($user->tipo !== 'admin') {
            abort(403, 'Solo el administrador puede crear operadores.');
        }

        $data = $request->validate([
            'nombre'   => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        User::create([
            'name'     => $data['nombre'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'tipo'     => 'operador',
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Operador creado correctamente.');
    }
}
