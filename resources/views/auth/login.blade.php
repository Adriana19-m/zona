@extends('layout.app')

@section('contenido')
<form method="POST" action="{{ route('login.post') }}">
  @csrf
  <label>Email:</label>
  <input type="email" name="email" required><br>

  <label>Contraseña:</label>
  <input type="password" name="password" required><br>

  <button type="submit">Iniciar Sesión</button>
</form>
@endsection