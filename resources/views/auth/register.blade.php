@extends('layout.app')

@section('contenido')
<form method="POST" action="{{ route('register.post') }}">
  @csrf
  <label>Nombre:</label>
  <input type="text" name="name" required><br>

  <label>Email:</label>
  <input type="email" name="email" required><br>

  <label>Contraseña:</label>
  <input type="password" name="password" required><br>

  <label>Rol:</label>
  <select name="role" required>
    <option value="admin">Administrador</option>
    <option value="visitante">Visitante</option>
  </select><br>

  <button type="submit">Registrarse</button>
</form>
@endsection