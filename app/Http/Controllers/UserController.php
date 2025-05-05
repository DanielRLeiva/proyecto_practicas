<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Models\Audit;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $oldRoles = implode(', ', $user->getRoleNames()->toArray());
        $user->syncRoles($request->role);
        $newRoles = implode(', ', $user->getRoleNames()->toArray());


        // Solo si hubo cambio
        if ($oldRoles !== $newRoles) {
            Audit::create([
                'user_type'       => get_class(Auth::user()),
                'user_id'         => Auth::id(),
                'event'           => 'updated',
                'auditable_type'  => get_class($user),
                'auditable_id'    => $user->id,
                'old_values'      => ['roles' => $oldRoles],
                'new_values'      => ['roles' => $newRoles],
                'url'             => request()->fullUrl(),
                'ip_address'      => request()->ip(),
                'user_agent'      => request()->userAgent(),
                'tags'            => 'role-change',
            ]);
        }

        return redirect()->back()->with('success', 'Rol actualizado con éxito.');
    }
}
