@extends('template.master')

@section('contenido')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow">
        <div class="card-body">
          <h4 class="mb-3">Iniciar Sesión</h4>

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
              <label for="rut">RUT</label>
              <input type="text" name="rut" id="rut" class="form-control"
                     value="{{ old('rut') }}" required>
            </div>
            <div class="mb-3">
              <label for="password">Contraseña</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
