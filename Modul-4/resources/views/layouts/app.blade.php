<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library SI - @yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>📚 Library SI</h1>
            <p>Temukan bacaan favoritmu di sini</p>
        </div>
    </header>

    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">Daftar Buku</a>
        </div>
    </nav>

    <main class="konten container">
        @yield('content')
    </main>

    <footer class="footer">
        &copy; {{ date('Y') }} Library SI
    </footer>
@yield('scripts')
</body>
</html>