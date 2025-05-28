@extends('layouts.app')

@section('title', 'Lista de Aulas')

@section('content')

<div class="container-fluid my-5 px-1 px-md-2 px-lg-3 px-xl-4">
    <div class="d-flex flex-column mb-4">
        <span class="navbar-text fw-bold">
            Bienvenido, {{ Auth::user()->name }}
        </span>

        <h1>Usuarios Registrados</h1>
    </div>
</div>

<hr>
</hr>

@if ($users->isEmpty())
<p class="mb-5">No hay Usuarios registradas aún.</p>

@else
<div class="table-responsive mb-5">
    <table class="table table-bordered table-striped align-middle mb-5">
        <h3 class="my-3">Lista de Usuarios</h3>

        <thead>
            <tr>
                <th class="sticky-header">Nombre</th>
                <th class="sticky-header">Email</th>
                <th class="sticky-header">Rol</th>
                <th class="sticky-header">Cambiar Rol</th>
                <th class="sticky-header">Acción</th>
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
</div>
@endif

<div class="text-center mb-5">
    <a href="{{ route('aulas.index') }}" class="btn btn-primary">Volver a la Lista de Aulas</a>
</div>
</div>

@endsection