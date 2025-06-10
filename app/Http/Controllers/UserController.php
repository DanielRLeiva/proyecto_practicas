<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Models\Audit as AuditModel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Mostrar la lista de usuarios excluyendo al admin principal.
     * Carga también los roles para mostrar o gestionar.
     */
    public function index()
    {
        $users = User::with('roles')
            ->where('email', '!=', 'admin@admin.com') // Excluir admin principal
            ->get();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Mostrar formulario para crear un nuevo usuario.
     * Se cargan todos los roles disponibles para asignar.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Validar y guardar un nuevo usuario con un rol asignado.
     * Se encripta la contraseña con bcrypt.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed', // Confirmación de contraseña requerida
            'role'     => 'required|exists:roles,name', // Validar que el rol exista
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Asignar rol al usuario
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar formulario para editar un usuario existente.
     * Se cargan todos los roles para poder cambiar.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Actualizar un usuario validando datos y sincronizando roles.
     * Además se registra manualmente la auditoría si hay cambios, 
     * evitando múltiples registros automáticos.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id, // Validar email excluyendo el actual
            'role'  => 'required|exists:roles,name',
        ]);

        // Guardar valores antiguos para comparar cambios después
        $oldValues = [
            'name'  => $user->getOriginal('name'),
            'email' => $user->getOriginal('email'),
            'roles' => implode(', ', $user->getRoleNames()->toArray()),
        ];

        // Actualizar usuario y roles sin disparar auditoría automática
        User::withoutAuditing(function () use ($request, $user) {
            $user->name  = $request->name;
            $user->email = $request->email;
            $user->save();

            $user->syncRoles($request->role);
        });

        // Valores nuevos después de la actualización
        $newValues = [
            'name'  => $user->name,
            'email' => $user->email,
            'roles' => implode(', ', $user->getRoleNames()->toArray()),
        ];

        // Crear un solo registro manual de auditoría si hay cambios reales
        if ($oldValues != $newValues) {
            Audit::create([
                'user_type'      => get_class(Auth::user()),
                'user_id'        => Auth::id(),
                'event'          => 'updated',
                'auditable_type' => User::class,
                'auditable_id'   => $user->id,
                'old_values'     => $oldValues,
                'new_values'     => $newValues,
                'url'            => request()->fullUrl(),
                'ip_address'     => request()->ip(),
                'user_agent'     => request()->userAgent(),
                'tags'           => 'user-update',
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar un usuario, excepto el admin principal para evitar borrados accidentales.
     */
    public function destroy(User $user)
    {
        if ($user->email === 'admin@admin.com') {
            // No permite eliminar al usuario administrador principal
            return redirect()->back()->withErrors(['error' => 'No se puede eliminar al administrador principal.']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
