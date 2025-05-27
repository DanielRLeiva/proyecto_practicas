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
    <footer class="bg-dark text-secondary p-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8 text-light p-4 ps-lg-5">
                    <p class="mb-1">C.P.I.F.P. Alan Turing</p>
                    <p class="mb-1">Telf: 951.040.449 | C/ Frederick Terman, 3</p>
                    <p class="mb-1">29590 Campanillas (Málaga)</p>
                    <p class="">2920231.info@g.educaand.es</>
                </div>

                <div class="col-12 col-lg-4 text-center">
                    <img src="https://fpalanturing.es/wp-content/uploads/2024/01/cpifpat_logos_footer.webp"
                        alt="Junta de Andalucía. Málaga Tech Park"
                        class="img-fluid mt-3 mt-lg-0"
                        style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>

        <hr>
        </hr>

        <div class="text-center pt-3">
            <div class="mb-3 d-flex justify-content-center gap-4">
                <!-- Facebook -->
                <a href="https://www.facebook.com/cpifpalanturing" target="_blank" title="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="grey" viewBox="0 0 24 24">
                        <path d="M22.675 0h-21.35C.6 0 0 .6 0 1.337v21.326C0 23.4.6 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.464.097 2.797.141v3.24h-1.92c-1.504 0-1.796.715-1.796 1.763v2.31h3.587l-.467 3.622h-3.12V24h6.116C23.4 24 24 23.4 24 22.663V1.337C24 .6 23.4 0 22.675 0z" />
                    </svg>
                </a>

                <!-- Twitter -->
                <a href="https://twitter.com/cpifpalanturing" target="_blank" title="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="grey" viewBox="0 0 24 24">
                        <path d="M24 4.557a9.83 9.83 0 0 1-2.828.775 4.932 4.932 0 0 0 2.165-2.724c-.951.564-2.005.974-3.127 1.195A4.916 4.916 0 0 0 16.616 3c-2.717 0-4.924 2.206-4.924 4.924 0 .386.045.762.127 1.124-4.092-.205-7.719-2.165-10.148-5.144a4.822 4.822 0 0 0-.666 2.475c0 1.708.869 3.213 2.188 4.096a4.904 4.904 0 0 1-2.229-.616c-.054 1.985 1.397 3.841 3.444 4.256a4.934 4.934 0 0 1-2.224.084 4.928 4.928 0 0 0 4.604 3.417A9.867 9.867 0 0 1 0 19.54a13.94 13.94 0 0 0 7.548 2.212c9.058 0 14.01-7.513 14.01-14.01 0-.213-.005-.425-.014-.636A10.025 10.025 0 0 0 24 4.557z" />
                    </svg>
                </a>

                <!-- LinkedIn -->
                <a href="https://es.linkedin.com/company/cpifpalanturing" target="_blank" title="LinkedIn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="grey" viewBox="0 0 24 24">
                        <path d="M4.98 3.5C4.98 5.43 3.43 7 1.5 7S-1.98 5.43-1.98 3.5 0.57 0 2.5 0 4.98 1.57 4.98 3.5zM.5 8h4v16h-4V8zm7.5 0h3.64v2.02h.05c.51-.96 1.76-1.98 3.64-1.98 3.89 0 4.61 2.56 4.61 5.89V24h-4V14.7c0-2.22-.04-5.07-3.1-5.07-3.11 0-3.59 2.43-3.59 4.93V24h-4V8z" />
                    </svg>
                </a>

                <!-- Instagram -->
                <a href="https://www.instagram.com/cpifpalanturing/" target="_blank" title="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="grey" viewBox="0 0 24 24">
                        <path d="M12 2.2c3.2 0 3.584.012 4.85.07 1.17.054 1.97.24 2.43.403a4.9 4.9 0 0 1 1.78 1.15 4.9 4.9 0 0 1 1.15 1.78c.163.46.35 1.26.403 2.43.058 1.266.07 1.65.07 4.85s-.012 3.584-.07 4.85c-.054 1.17-.24 1.97-.403 2.43a4.9 4.9 0 0 1-1.15 1.78 4.9 4.9 0 0 1-1.78 1.15c-.46.163-1.26.35-2.43.403-1.266.058-1.65.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.054-1.97-.24-2.43-.403a4.9 4.9 0 0 1-1.78-1.15 4.9 4.9 0 0 1-1.15-1.78c-.163-.46-.35-1.26-.403-2.43C2.212 15.784 2.2 15.4 2.2 12s.012-3.584.07-4.85c.054-1.17.24-1.97.403-2.43a4.9 4.9 0 0 1 1.15-1.78 4.9 4.9 0 0 1 1.78-1.15c.46-.163 1.26-.35 2.43-.403C8.416 2.212 8.8 2.2 12 2.2zm0 1.8c-3.17 0-3.535.012-4.782.068-1.03.047-1.59.216-1.96.36a3.1 3.1 0 0 0-1.16.757 3.1 3.1 0 0 0-.757 1.16c-.144.37-.313.93-.36 1.96-.056 1.247-.068 1.612-.068 4.782s.012 3.535.068 4.782c.047 1.03.216 1.59.36 1.96.174.435.412.832.757 1.16.328.345.725.583 1.16.757.37.144.93.313 1.96.36 1.247.056 1.612.068 4.782.068s3.535-.012 4.782-.068c1.03-.047 1.59-.216 1.96-.36a3.1 3.1 0 0 0 1.16-.757 3.1 3.1 0 0 0 .757-1.16c.144-.37.313-.93.36-1.96.056-1.247.068-1.612.068-4.782s-.012-3.535-.068-4.782c-.047-1.03-.216-1.59-.36-1.96a3.1 3.1 0 0 0-.757-1.16 3.1 3.1 0 0 0-1.16-.757c-.37-.144-.93-.313-1.96-.36-1.247-.056-1.612-.068-4.782-.068zm0 3.3a6.5 6.5 0 1 1 0 13 6.5 6.5 0 0 1 0-13zm0 2.2a4.3 4.3 0 1 0 0 8.6 4.3 4.3 0 0 0 0-8.6zm6.6-2.4a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4z" />
                    </svg>
                </a>

                <!-- YouTube -->
                <a href="https://www.youtube.com/@cpifpalanturing" target="_blank" title="YouTube">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="grey" viewBox="0 0 24 24">
                        <path d="M23.5 6.2s-.2-1.6-.8-2.3c-.8-.9-1.7-.9-2.1-1C17.6 2.5 12 2.5 12 2.5h-.1s-5.6 0-8.6.4c-.4.1-1.3.1-2.1 1-.6.7-.8 2.3-.8 2.3S0 8.2 0 10.2v1.7c0 2 .2 4 .2 4s.2 1.6.8 2.3c.8.9 1.9.9 2.4 1 1.8.2 7.6.4 7.6.4s5.6 0 8.6-.4c.4-.1 1.3-.1 2.1-1 .6-.7.8-2.3.8-2.3s.2-2 .2-4v-1.7c0-2-.2-4-.2-4zM9.5 15.5v-7l6.5 3.5-6.5 3.5z" />
                    </svg>
                </a>
            </div>

            <div class="text-center pt-4">
                <p>&copy; Inventariado TIC CPIFP Alan Turing 2025</p>
            </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    {{-- Scripts adicionales --}}
    @stack('scripts')

</body>

</html>