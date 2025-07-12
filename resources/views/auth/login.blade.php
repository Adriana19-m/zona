@extends('layout.app')

@section('contenido')
<style>
    body {
        background: linear-gradient(to right, #d1e9e9, #f3f4f6);
    }
</style>

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-10 border border-gray-200">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Bienvenido 👋</h1>
            <p class="text-sm text-gray-500">Inicia sesión para continuar</p>
        </div>

        @if(session('error'))
            <div class="mb-4 text-sm text-red-700 bg-red-100 border border-red-400 p-3 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <input id="email" type="email" name="email" required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-gray-50"
                    placeholder="ejemplo@correo.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input id="password" type="password" name="password" required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-gray-50"
                    placeholder="••••••••">
            </div>

               <div class="pt-2" style="text-align: center;">
                  <button type="submit" 
                          style="display: inline-block; 
                                padding: 12px 24px; 
                                background-color: #3B82F6; 
                                color: white; 
                                font-weight: bold; 
                                border-radius: 8px; 
                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
                                transition: all 0.3s ease; 
                                border: none; 
                                cursor: pointer;
                                font-size: 16px;"
                          onmouseover="this.style.backgroundColor='#2563EB'" 
                          onmouseout="this.style.backgroundColor='#3B82F6'">
                      Iniciar Sesión
                  </button>
              </div>
  <!----<p class="text-center text-sm text-gray-600 mt-6">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-green-600 font-medium hover:underline">Regístrate</a>
        </p>
    </div>------>
</div>
@endsection
