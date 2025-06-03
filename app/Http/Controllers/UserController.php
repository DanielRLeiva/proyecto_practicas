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
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')
            ->where('email', '!=', 'admin@admin.com')
            ->get();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|exists:roles,name',
        ]);

        $oldValues = [
            'name'  => $user->getOriginal('name'),
            'email' => $user->getOriginal('email'),
            'roles' => implode(', ', $user->getRoleNames()->toArray()),
        ];

        User::withoutAuditing(function () use ($request, $user) {
            // Actualizar nombre y email (sin disparar auditoría)
            $user->name  = $request->name;
            $user->email = $request->email;
            $user->save();

            // Sincronizar roles (sin auditoría automática)
            $user->syncRoles($request->role);
        });

        // Capturar valores nuevos (NEW)
        $newValues = [
            'name'  => $user->name,
            'email' => $user->email,
            'roles' => implode(', ', $user->getRoleNames()->toArray()),
        ];

        // Si hay cambios, crear UN SOLO registro manual
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
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->email === 'admin@admin.com') {
            return redirect()->back()->withErrors(['error' => 'No se puede eliminar al administrador principal.']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
