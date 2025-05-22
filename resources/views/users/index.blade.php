@extends('layouts.app')

@section('title', 'Lista de Aulas')

@section('content')

<div class="container mt-5 mb-5">
    <h1 class="mb-5">Usuarios</h1>

    @if ($users->isEmpty())
    <p>No hay Usuarios registradas aún.</p>

    @else
    <table class="table table-bordered table-striped align-middle mb-5">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Cambiar Rol</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->getRoleNames()->first() ?? 'Sin rol' }}</td>
                <td>
                    <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="role" class="form-select" {{ ($user->id === Auth::id() && $user->hasRole('admin')) ? 'disabled' : '' }}>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                            @endforeach
                        </select>
                </td>
                <td class="text-center">
                    <button type="submit" class="btn btn-success">Actualizar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="text-center">
        <a href="{{ route('aulas.index') }}" class="btn btn-primary mb-4">Volver a la Lista de Aulas</a>
    </div>
</div>

@endsection