<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Universal Gold') - {{ config('app.name', 'Sistema de Referidos') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-[#1e5128] text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold">
                            Universal Gold
                        </a>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="text-sm hover:text-[#bc9313] transition">Dashboard</a>
                                <a href="{{ route('admin.influencers') }}" class="text-sm hover:text-[#bc9313] transition">Influencers</a>
                                <a href="{{ route('admin.leads') }}" class="text-sm hover:text-[#bc9313] transition">Leads</a>
                                <a href="{{ route('admin.qr-scanner') }}" class="text-sm hover:text-[#bc9313] transition">Escanear QR</a>
                                <a href="{{ route('admin.change-password') }}" class="text-sm hover:text-[#bc9313] transition">Cambiar Contraseña</a>
                            @endif
                        @endauth
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <span class="text-sm">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm hover:text-[#bc9313] transition">
                                    Cerrar Sesión
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-100 border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-600">
                &copy; {{ date('Y') }} Universal Gold. Todos los derechos reservados.
            </div>
        </footer>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>

