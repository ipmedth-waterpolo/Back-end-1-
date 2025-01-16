<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <!-- Include a CSS file -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <main class="main">
        @yield('content') <!-- Placeholder for additional content -->
    </main>
    <footer class="footer">
        <p>&copy; 2025 Waterpolo Admin Panel</p>
    </footer>
</body>
</html>
