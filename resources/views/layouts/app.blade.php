<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Inventariado TIC CPIFP Alan Turing')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome CSS --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- CSS adicional --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

</head>

<body class="bg-light body-fondo" @auth data-role="{{ Auth::user()->getRoleNames()->first() }}" @endauth>

    {{-- NAVBAR --}}
    <header class="bg-info">
        <nav class="navbar navbar-expand-lg pt-0 pb-0">
            <div class="container-fluid d-flex align-items-center py-3 px-2 px-md-3 px-lg-4 px-xl-5">
                <a class="navbar-brand" href="{{ route('aulas.index') }}">
                    <img decoding="async" width="150" src="https://private-user-images.githubusercontent.com/94998377/448342504-c324c919-7636-42be-aac0-0b15cd61ffee.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3NDg0MzAxMTgsIm5iZiI6MTc0ODQyOTgxOCwicGF0aCI6Ii85NDk5ODM3Ny80NDgzNDI1MDQtYzMyNGM5MTktNzYzNi00MmJlLWFhYzAtMGIxNWNkNjFmZmVlLnBuZz9YLUFtei1BbGdvcml0aG09QVdTNC1ITUFDLVNIQTI1NiZYLUFtei1DcmVkZW50aWFsPUFLSUFWQ09EWUxTQTUzUFFLNFpBJTJGMjAyNTA1MjglMkZ1cy1lYXN0LTElMkZzMyUyRmF3czRfcmVxdWVzdCZYLUFtei1EYXRlPTIwMjUwNTI4VDEwNTY1OFomWC1BbXotRXhwaXJlcz0zMDAmWC1BbXotU2lnbmF0dXJlPWI0Yzc1YTQwNTZiZTNjYjEwNmQ0NTU5YjY0MWJlM2M2NGQ4YzYyOGYxOTBiYzM1MTQ2YTE2NWI4YTg1OTA1ZDYmWC1BbXotU2lnbmVkSGVhZGVycz1ob3N0In0.kTMDnd15QgslYKuEoocEyXFxgJkggijZHWnY7QSF0wA" alt="Logo" style="vertical-align: middle;">
                </a>

                <h5>Inventariado TIC</h5>

                {{-- Botón hamburguesa --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido" aria-controls="navbarContenido" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Contenido colapsable --}}
                <div class="collapse navbar-collapse justify-content-end mt-3" id="navbarContenido">
                    <ul class="navbar-nav">
                        @auth
                        {{-- Enlaces visibles directamente en pantallas grandes --}}
                        @role('admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('auditoria.index') }}">Auditorías</a></li>
                        @endrole
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="usufructosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Usufructos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="usufructosDropdown">
                                <li><a class="dropdown-item" href="{{ route('usufructos.index') }}">Usufructos</a></li>
                                <li><a class="dropdown-item" href="{{ route('usufructos.create') }}">Nuevo Usufructo</a></li>
                                <li><a class="dropdown-item" href="{{ route('profesors.index') }}">Profesores</a></li>
                                <li><a class="dropdown-item" href="{{ route('portatils.index') }}">Portátiles</a></li>
                            </ul>
                        </li>
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
    <div class="container-fluid px-2 px-md-3 px-lg-4 mt-3">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    {{-- FOOTER --}}
    <footer class="bg-dark text-secondary py-4">
        <div class="container-fluid  py-4 px-2 px-md-3 px-lg-4 px-xl-5">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8 text-light py-4 ">
                    <p class="mb-1">C.P.I.F.P. Alan Turing</p>
                    <p class="mb-1">Telf: 951.040.449 | C/ Frederick Terman, 3</p>
                    <p class="mb-1">29590 Campanillas (Málaga)</p>
                    <p class="">29020231.info@g.educaand.es</p>
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
                    <i class="fab fa-facebook-square fa-2x text-secondary social-icon"></i>
                </a>

                <!-- Twitter -->
                <a href="https://twitter.com/cpifpalanturing" target="_blank" title="Twitter">
                    <i class="fab fa-twitter-square fa-2x text-secondary social-icon"></i>
                </a>

                <!-- LinkedIn -->
                <a href="https://es.linkedin.com/company/cpifpalanturing" target="_blank" title="LinkedIn">
                    <i class="fab fa-linkedin fa-2x text-secondary social-icon"></i>
                </a>

                <!-- Instagram -->
                <a href="https://www.instagram.com/cpifpalanturing/" target="_blank" title="Instagram">
                    <i class="fab fa-instagram-square fa-2x text-secondary social-icon"></i>
                </a>

                <!-- YouTube -->
                <a href="https://www.youtube.com/@cpifpalanturing" target="_blank" title="YouTube">
                    <i class="fab fa-youtube-square fa-2x text-secondary social-icon"></i>
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