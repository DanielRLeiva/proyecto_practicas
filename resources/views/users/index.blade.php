@extends('layouts.app')

@section('title', 'Lista de Aulas')

@section('content')

@push('styles')
<style>
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 2;
        padding: 1rem !important;
        border: 1px solid #dee2e6;
        white-space: nowrap;
    }
</style>
@endpush

<div class="container mt-5 mb-5">
    <div class="mb-4">
        <span class="navbar-text">
            Bienvenido, {{ Auth::user()->name }}
        </span>

        <h1>Usuarios Registrados</h1>
    </div>

    <hr>
    </hr>

    @if ($users->isEmpty())
    <p class="mb-5">No hay Usuarios registradas aún.</p>

    @else
    <div class="table-responsive mb-5">
        <table class="table table-bordered table-striped align-middle mt-5 mb-5">
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

    <div class="text-center">
        <a href="{{ route('aulas.index') }}" class="btn btn-primary mb-4">Volver a la Lista de Aulas</a>
    </div>
</div>

@endsection