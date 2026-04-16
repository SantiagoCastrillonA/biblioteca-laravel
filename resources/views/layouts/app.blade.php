<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Biblioteca') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    @yield('styles')
</head>
<body>
    <nav class="nav">
        <div class="nav-container">
            <a href="{{ route('books.index') }}" class="brand">📚 Mi Biblioteca</a>
            <div class="nav-links">
                <a href="{{ route('books.index') }}" class="btn">Libros</a>
                <a href="{{ route('authors.index') }}" class="btn">Autores</a>
                <a href="{{ route('categories.index') }}" class="btn">Categorías</a>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <!-- Toast Container -->
    <div id="toast-container"></div>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- App JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Flash Toasts from Laravel Session -->
    <script>
    $(document).ready(function() {
        @if(session('success'))
            showToast(@json(session('success')), 'success');
        @endif
        @if(session('error'))
            showToast(@json(session('error')), 'error');
        @endif
        @if(session('warning'))
            showToast(@json(session('warning')), 'warning');
        @endif
        @if(session('info'))
            showToast(@json(session('info')), 'info');
        @endif
    });
    </script>

    @yield('scripts')
</body>
</html>
