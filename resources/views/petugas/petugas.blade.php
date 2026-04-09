<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", "Petugas") — Parkir</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-slate-50 font-sans antialiased">

<nav class="bg-emerald-700 text-white px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-3 shadow fixed w-full top-0 z-50">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl bg-white text-emerald-700 grid place-items-center shadow-sm">
            <span class="text-lg font-bold">P</span>
        </div>
        <div>
            <h1 class="text-lg font-semibold">Aplikasi Parkir</h1>
            <p class="text-sm text-emerald-100">Panel Petugas</p>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <span class="text-sm text-emerald-100">{{ auth()->user()->nama_lengkap }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="rounded-full bg-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-600">Logout</button>
        </form>
    </div>
</nav>

<div class="flex pt-16">
    <aside class="hidden md:block md:w-56 bg-white shadow-md min-h-screen fixed top-16 left-0">
        <div class="p-4 bg-emerald-50 border-b border-emerald-100">
            <p class="text-xs text-slate-500">Login sebagai</p>
            <p class="font-bold text-emerald-700">PETUGAS</p>
        </div>
        <ul class="p-3 space-y-2">
            <li>
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-2 rounded-2xl px-4 py-3 text-sm font-medium transition @if(request()->routeIs('petugas.dashboard')) bg-emerald-600 text-white shadow-sm @else text-slate-700 hover:bg-slate-100 @endif">Dashboard</a>
            </li>
        </ul>
    </aside>

    <main class="flex-1 ml-0 md:ml-56 p-4 md:p-8">
        <div class="max-w-7xl mx-auto">
            @if(session("success"))
                <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">{{ session("success") }}</div>
            @endif
            @if(session("error"))
                <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm">{{ session("error") }}</div>
            @endif
            @yield("content")
        </div>
    </main>
</div>
</body>
</html>
