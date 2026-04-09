<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Petugas') — Parkir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #eef2ff; }
        .petugas-app { min-height: 100vh; display: flex; background: #eef2ff; }
        .petugas-sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100vh; background: linear-gradient(180deg, #111827 0%, #0f172a 100%); color: #e2e8f0; display: flex; flex-direction: column; overflow-y: auto; z-index: 1000; border-right: 1px solid rgba(148,163,184,.15); }
        .petugas-sidebar a { color: #e2e8f0; text-decoration: none; }
        .petugas-sidebar a.active, .petugas-sidebar a:hover { background: rgba(255,255,255,.08); color: #fff; }
        .petugas-main { margin-left: 250px; flex: 1; }
        .petugas-sidebar .brand { font-size: 1.2rem; letter-spacing: .08em; font-weight: 800; text-transform: uppercase; }
        .petugas-sidebar .nav-group { margin-top: 2rem; }
        .petugas-sidebar .nav-group a { display: flex; align-items: center; gap: .75rem; padding: .9rem 1rem; border-radius: 18px; transition: background .2s ease, transform .2s ease; margin-bottom: .5rem; }
        .petugas-sidebar .nav-group a:hover { transform: translateX(1px); }
        .petugas-sidebar .nav-group a .icon { width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; font-size: 1rem; }
        .petugas-sidebar .nav-group a span.label { flex: 1; font-size: .95rem; }
        .petugas-sidebar .nav-group a .badge { background: #e2e8f0; color: #0f172a; padding: .15rem .5rem; border-radius: 999px; font-size: .72rem; }
        .petugas-sidebar footer { margin-top: auto; padding: 1rem; }
        .petugas-sidebar footer button { width: 100%; border-radius: 999px; padding: .8rem; font-weight: 600; }
        .page-header { display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 1rem; }
        .page-header .subtitle { color: #64748b; }
        @media (max-width: 991px) {
            .petugas-sidebar { position: static; width: 100%; height: auto; border-right: 0; }
            .petugas-main { margin-left: 0; }
        }
        @media print {
            .no-print { display: none !important; }
            .petugas-sidebar { display: none; }
            .petugas-main { margin-left: 0; }
            body { background: #fff; }
            .struk { box-shadow: none !important; margin: 0; border-radius: 0; }
            .struk-buttons { display: none !important; }
        }
    </style>
</head>
<body>

<div class="petugas-app">
    <aside class="petugas-sidebar p-6">
        <div class="brand text-white">PETUGAS PARKIR</div>
        <div class="nav-group">
            <a class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" href="{{ route('petugas.dashboard') }}"><span class="icon">🏠</span><span class="label">Dashboard</span></a>
            <a class="{{ request()->routeIs('petugas.transaksi') ? 'active' : '' }}" href="{{ route('petugas.transaksi') }}"><span class="icon">🧾</span><span class="label">Transaksi</span></a>
            <a class="{{ request()->routeIs('petugas.ai') ? 'active' : '' }}" href="{{ route('petugas.ai') }}"><span class="icon">🤖</span><span class="label">AI Chatbot</span></a>
        </div>
        <footer>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </footer>
    </aside>

    <main class="petugas-main p-6 lg:p-8">
        @if(session('success'))
            <div class="alert alert-success no-print">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger no-print">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>