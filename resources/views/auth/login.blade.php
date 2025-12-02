@extends('layouts.auth')

@section('title', 'Iniciar Sesión')
@section('subtitle', 'Accede a tu cuenta')

@section('content')
<div class="bg-white py-8 px-6 shadow rounded-lg">
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
            <input id="email" name="email" type="email" required autofocus
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#1e5128] focus:border-[#1e5128]"
                value="{{ old('email') }}">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input id="password" name="password" type="password" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#1e5128] focus:border-[#1e5128]">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox"
                    class="h-4 w-4 text-[#1e5128] focus:ring-[#1e5128] border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Recordarme
                </label>
            </div>
        </div>

        @if ($errors->has('email'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                {{ $errors->first('email') }}
            </div>
        @endif

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#1e5128] hover:bg-[#1a4520] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e5128]">
                Iniciar Sesión
            </button>
        </div>
    </form>
</div>
@endsection


