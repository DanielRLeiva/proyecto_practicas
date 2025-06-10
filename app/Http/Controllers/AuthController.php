<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     * Si el usuario ya está autenticado, lo redirige a la lista de aulas.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('aulas.index');
        }

        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión.
     * Valida email y contraseña y usa el método Auth::attempt para autenticar.
     */
    public function login(Request $request)
    {
        // Validación de campos obligatorios y formato de email
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.email' => 'Por favor, introduce un correo electrónico válido.',
        ]);

        $credentials = $request->only('email', 'password');

        // Intentar autenticar con las credenciales
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Previene ataques de sesión
            return redirect()->intended('aulas'); // Redirige a la página deseada o por defecto
        }

        // Retorna con error si las credenciales no son correctas
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.'
        ]);
    }

    /**
     * Muestra el formulario de registro.
     * Si el usuario está autenticado, redirige a aulas.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('aulas.index');
        }

        return view('auth.register');
    }

    /**
     * Registra un nuevo usuario en el sistema.
     * Valida datos, crea el usuario, asigna rol por defecto y lo autentica.
     */
    public function register(Request $request)
    {
        // Validación de datos de registro
        $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        // Crear usuario con contraseña hasheada
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignar rol 'viewer' por defecto al nuevo usuario
        $user->assignRole('viewer');

        // Forzar auditoría para registrar la asignación del rol
        $user->auditEvent = 'updated';
        $user->save();

        // Autenticar al usuario recién registrado
        Auth::login($user);

        // Mensaje flash de éxito en sesión
        $request->session()->flash('success', 'Usuario registrado correctamente.');

        return redirect()->route('aulas.index');
    }

    /**
     * Cierra la sesión del usuario.
     * Invalida la sesión y regenera el token CSRF para seguridad.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalida y regenera la sesión para evitar reutilización
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirige al formulario de login
        return redirect()->route('login');
    }
}
