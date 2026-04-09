<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Aplikasi Parkir</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="min-h-screen bg-slate-900 text-slate-100">

<div class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-md rounded-[32px] border border-white/10 bg-slate-950/95 p-8 shadow-2xl shadow-slate-950/50 backdrop-blur-sm">
        <div class="text-center mb-8">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-600 text-white shadow-lg shadow-blue-500/20">
                <span class="text-3xl font-bold">P</span>
            </div>
            <h1 class="mt-4 text-3xl font-bold">Aplikasi Parkir</h1>
            <p class="mt-2 text-sm text-slate-400">Silakan login untuk melanjutkan.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-2">Username</label>
                <input type="text" name="username" class="w-full rounded-2xl border border-slate-700 bg-slate-900 px-4 py-3 text-base text-slate-100 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-2">Password</label>
                <input type="password" name="password" class="w-full rounded-2xl border border-slate-700 bg-slate-900 px-4 py-3 text-base text-slate-100 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" required>
            </div>
            <button type="submit" class="w-full rounded-2xl bg-blue-600 px-4 py-3 text-base font-semibold text-white transition hover:bg-blue-700">Login</button>
        </form>
    </div>
</div>

</body>
</html>
