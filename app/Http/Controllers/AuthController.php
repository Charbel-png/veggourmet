<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // -------- LOGIN --------

    // Formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirección según el tipo de usuario
            switch ($user->tipo) {
                case 'admin':
                    return redirect()->route('admin.dashboard');

                case 'operador':
                    return redirect()->route('operador.dashboard');

                case 'cliente':
                    return redirect()->route('cliente.dashboard');

                default:
                    Auth::logout();
                    return redirect()
                        ->route('login')
                        ->withErrors(['email' => 'Tipo de usuario no válido.']);
            }
        }

        return back()->withErrors([
            'email' => 'Correo y/o contraseña incorrectos.',
        ])->onlyInput('email');
    }

    // -------- REGISTRO (sólo clientes) --------

    // Formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Procesar registro de cliente
    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre'   => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $data['nombre'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'tipo'     => 'cliente',
        ]);

        Auth::login($user);

        return redirect()->route('cliente.dashboard');
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
