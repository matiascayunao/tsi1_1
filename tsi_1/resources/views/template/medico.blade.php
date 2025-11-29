<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Centro Médico Biosalud</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  {{-- header --}}
  <header class="bg-white shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-2">
      <a href="{{ route('medico.index') }}">
        <img src="{{ asset('images/bio.png') }}" alt="Centro Médico" width="150">
      </a>

      {{-- login --}}
      @guest
        <a href="{{ route('login') }}" class="btn">👤 Personal</a>
      @endguest

      {{-- autenticado --}}
      @auth
        <div class="dropdown">
          <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            👤 {{ Auth::user()->nombre }}
            <span class="badge text-bg-secondary ms-1">{{ Auth::user()->rol }}</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            @if(Auth::user()->rol === 'medico')
                <li><a class="dropdown-item" href="{{ route('medico.pacientes') }}">Mis Pacientes</a></li>
                <li><a class="dropdown-item" href="{{ route('medico.citas') }}">Mis Citas</a></li>
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
    </div> {{-- <-- solo este div cierra el .container --}}
  </header>

  {{-- nav --}}
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Mostrar navegación">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        {{-- gap-3 agrega separación entre los items --}}
        <ul class="navbar-nav mx-auto gap-3">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('medico.pacientes') }}">Mis Pacientes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('medico.citas') }}">Mis Citas</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- contenido --}}
  <main class="w-100 my-3 bg-white rounded">
    <div class="p-3 pt-1">
      @yield('contenido')
    </div>
  </main>

  {{-- footer --}}
  <footer class="bg-dark text-white mt-5 p-4 text-center">
    <p class="mt-2 mb-1">Luis Cousiño 1753, Quintero, Valparaíso</p>
    <p class="mb-0">32 2934803 | biosaludquintero@hotmail.com</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
