<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Admin') — Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: #f7fafc; }</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.tarif*') ? 'active' : '' }}" href="{{ route('admin.tarif.index') }}">Tarif</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.area*') ? 'active' : '' }}" href="{{ route('admin.area.index') }}">Area</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.kendaraan*') ? 'active' : '' }}" href="{{ route('admin.kendaraan.index') }}">Kendaraan</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.log*') ? 'active' : '' }}" href="{{ route('admin.log.index') }}">Log</a></li>
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf
                <button class="btn btn-danger btn-sm" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>