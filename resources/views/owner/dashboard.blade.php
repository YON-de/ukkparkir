@extends("layouts.owner")

@section("content")
<div class="space-y-6">
    <div class="rounded-3xl bg-white p-6 shadow-sm shadow-slate-200">
        <h2 class="text-2xl font-semibold text-slate-900">Dashboard Owner</h2>
        <p class="mt-2 text-sm text-slate-500">Ringkasan rekap dan laporan pendapatan parkir.</p>
    </div>

    <div class="grid gap-6 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <div class="bg-white rounded-xl shadow p-5 text-center border-t-4 border-blue-500">
            <div class="text-4xl font-bold text-blue-600">{{ $totalTransaksi }}</div>
            <div class="text-gray-500 mt-1 text-sm">Total Transaksi</div>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center border-t-4 border-green-500">
            <div class="text-4xl font-bold text-green-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            <div class="text-gray-500 mt-1 text-sm">Total Pendapatan</div>
        </div>
        <div class="bg-white rounded-xl shadow p-5 text-center border-t-4 border-yellow-500">
            <div class="text-4xl font-bold text-yellow-600">{{ $kendaraanAktif }}</div>
            <div class="text-gray-500 mt-1 text-sm">Kendaraan Aktif</div>
        </div>
    </div>
</div>
@endsection
