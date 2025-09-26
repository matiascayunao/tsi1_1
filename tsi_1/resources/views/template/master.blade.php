<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Centro Médico Biosalud</title>

  {{-- Bootstrap CSS (5.3.3). Puedes dejarlo sin integrity para evitar bloqueos --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  {{-- HEADER --}}
  <header class="bg-white shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-2">
      <a href="{{ route('home.index') }}">
        <img src="{{ asset('images/bio.png') }}" alt="Centro Médico" width="150">
      </a>

      <div class="d-flex gap-3 align-items-center">
        {{-- Siempre visible --}}
        <a href="{{ route('citas.index') }}" class="btn btn-primary">Reserva tu hora</a>

        {{-- Invitado (no logueado) --}}
        @guest
          <a href="{{ route('login') }}" class="btn btn-link">👤 Personal</a>
        @endguest

        {{-- Autenticado --}}
        @auth
          <div class="dropdown">
            <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              👤 {{ Auth::user()->nombre }}
              <span class="badge text-bg-secondary ms-1">{{ Auth::user()->rol }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              @if(Auth::user()->rol === 'secretaria')
                <li><a class="dropdown-item" href="#">Gestión de Pacientes</a></li>
                <li><a class="dropdown-item" href="#">Gestión de Médicos</a></li>
                <li><a class="dropdown-item" href="#">Ver todas las citas</a></li>
                <li><hr class="dropdown-divider"></li>
              @endif

              @if(Auth::user()->rol === 'medico')
                <li><a class="dropdown-item" href="#">Mis Pacientes</a></li>
                <li><a class="dropdown-item" href="#">Mis Citas</a></li>
                <li><hr class="dropdown-divider"></li>
              @endif

              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">Cerrar sesión</button>
                </form>
              </li>
            </ul>
          </div>
        @endauth
      </div>
    </div>
  </header>

  {{-- NAV --}}
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Mostrar navegación">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('home.info') }}">Información para Pacientes</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('citas.index') }}">Médicos y Especialistas</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('citas.buscarPorRut') }}">Modificar Cita</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('citas.cancelarPorRut') }}">Cancelar Cita</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('home.sobre') }}">Sobre Nosotros</a></li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- CONTENIDO --}}
  <main class="w-100 my-3 bg-white rounded">
    <div class="p-3 pt-1">
      @yield('contenido')
    </div>
  </main>

  {{-- FOOTER --}}
  <footer class="bg-dark text-white mt-5 p-4 text-center">
    <p class="mt-2 mb-1">Luis Cousiño 1753, Quintero, Valparaíso</p>
    <p class="mb-0">32 2934803 | biosaludquintero@hotmail.com</p>
  </footer>

  {{-- Bootstrap Bundle JS (incluye Popper). Debe ir antes de </body> --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
