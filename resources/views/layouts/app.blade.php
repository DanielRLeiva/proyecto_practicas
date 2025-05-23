<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Inventariado TIC CPIFP Alan Turing')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS adicional --}}
    @stack('styles')
</head>

<body @auth data-role="{{ Auth::user()->getRoleNames()->first() }}" @endauth>

    {{-- NAVBAR --}}
    <header>
        <nav class="navbar navbar-expand-lg navbar-info bg-info pt-4 pb-4">
            <div class="container">
                <a class="navbar-brand" href="{{ route('aulas.index') }}">Inventariado TIC CPIFP Alan Turing</a>

                {{-- Botón hamburguesa --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido" aria-controls="navbarContenido" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Contenido colapsable --}}
                <div class="collapse navbar-collapse justify-content-end" id="navbarContenido">
                    <ul class="navbar-nav">
                        @auth
                        {{-- Enlaces visibles directamente en pantallas grandes --}}
                        @role('admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('auditoria.index') }}">Auditorías</a></li>
                        @endrole
                        <li class="nav-item"><a class="nav-link" href="{{ route('usufructos.index') }}">Usufructos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('equipos.all') }}">Todos los Equipos</a></li>

                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-link nav-link text-danger" type="submit">Cerrar sesión</button>
                            </form>
                        </li>
                        @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="container mt-3">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    {{-- FOOTER --}}
    <footer class="text-center bg-dark text-white p-5">
        &copy; {{ date('Y') }} Inventariado TIC CPIFP Alan Turing
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    {{-- Scripts adicionales --}}
    @stack('scripts')

</body>

</html>