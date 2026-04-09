<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased">

<nav class="bg-blue-700 text-white px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-3 shadow fixed w-full top-0 z-50">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
            <span class="text-blue-700 font-bold text-sm">P</span>
        </div>
        <h1 class="text-lg font-bold">Aplikasi Parkir</h1>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm text-blue-200">{{ auth()->user()->nama_lengkap }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm transition">Logout</button>
        </form>
    </div>
</nav>

<div class="flex pt-16">
    <aside class="hidden md:block md:w-56 bg-white shadow-md min-h-screen fixed top-16 left-0">
        <div class="p-4 bg-blue-50 border-b border-blue-100">
            <p class="text-xs text-gray-500">Login sebagai</p>
            <p class="font-bold text-blue-700">ADMIN</p>
        </div>
        <ul class="p-3 space-y-1">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded text-sm {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    Kelola User
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tarif.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded text-sm {{ request()->routeIs('admin.tarif*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    Kelola Tarif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.area.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded text-sm {{ request()->routeIs('admin.area*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    Kelola Area
                </a>
            </li>
            <li>
                <a href="{{ route('admin.kendaraan.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded text-sm {{ request()->routeIs('admin.kendaraan*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    Kelola Kendaraan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.log.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded text-sm {{ request()->routeIs('admin.log*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    Log Aktivitas
                </a>
            </li>
        </ul>
    </aside>

    <main class="flex-1 ml-0 md:ml-56 p-4 md:p-8">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>