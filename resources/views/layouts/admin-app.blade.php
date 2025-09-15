<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Gastu')</title>

    {{-- Iconos de FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    {{-- DataTables CSS (si lo necesitas globalmente) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Estilos globales con Vite --}}
    @vite('resources/css/nav-bar.css')
    @vite('resources/js/nav-bar.js')
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/css/header.css')
    @vite('resources/js/egresos.js')

    {{-- Espacio para estilos específicos de cada vista --}}
    @stack('styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="layout">
        {{-- Sidebar --}}
        @include('components.sidenav')
        @include('components.header')

        {{-- Contenido principal --}}
        <main class="page-content">
            @yield('content')
        </main>
        <!-- Modal global -->
    <div class="modal fade" id="globalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="globalModalContent">
                <!-- Aquí se cargarán los partials vía include o JS -->
            </div>
        </div>
    </div>

    @vite(['resources/js/modal-handler.js'])
    </div>


    {{-- jQuery y DataTables (si lo quieres global) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    {{-- Script global --}}
    @vite('resources/js/nav-bar.js')
    
    {{-- Scripts específicos de cada vista --}}
    @stack('scripts')
 
</body>
</html>
