<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Centro Médico Biosalud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>

    {{-- header --}}
    <header class="bg-white shadow-sm">
      <div class="container d-flex justify-content-between align-items-center py-2">
        <a href="{{ url('/') }}">
          <img src="{{ asset('images/logo.png') }}" alt="Centro Médico" style="height:50px;">
        </a>
        <div class="d-flex gap-3">
          <a href="{{ route('medicos.index') }}" class="btn btn-primary">Reserva tu hora</a>
          <a href="{{ route('usuarios.index') }}" class="btn btn-link">👤 Personal</a>
        </div>
      </div>
    </header>

    {{-- nav --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('pacientes.index') }}">Información para Pacientes</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('medicos.index') }}">Médicos y Especialistas</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('citas.edit') }}">Modificar Cita</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('citas.destroy') }}">Cancelar Cita</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('nosotros.index') }}">Sobre Nosotros</a></li>
          </ul>
        </div>
      </div>
    </nav>

    {{-- contenido --}}
    <main>
      @yield('content')
    </main>

    {{-- footer --}}
    <footer class="bg-dark text-white mt-5 p-4 text-center">
      <img src="{{ asset('images/logo.png') }}" alt="Centro Médico" style="height:40px;">
      <p class="mt-2">Av. Salud 1234, Viña del Mar, Chile</p>
      <p>📞 +56 32 123 4567 | 📧 contacto@centromedico.cl</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
