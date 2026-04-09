@extends("layouts.owner")

@section("content")
<div class="space-y-6">
    <div class="rounded-3xl bg-white p-6 shadow-sm shadow-slate-200">
        <h2 class="text-2xl font-semibold text-slate-900">Rekap Transaksi</h2>
        <p class="mt-2 text-sm text-slate-500">Daftar transaksi parkir terbaru dan total biaya.</p>
    </div>

    <div class="overflow-x-auto rounded-3xl bg-white shadow-sm shadow-slate-200">
        <table class="min-w-full divide-y divide-slate-200 text-left">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">No</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Plat</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Jenis</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Masuk</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Keluar</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Durasi</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @foreach($transaksi as $t)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $t->kendaraan->plat_nomor }}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $t->kendaraan->jenis_kendaraan }}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $t->waktu_masuk }}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $t->waktu_keluar }}</td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ $t->durasi_jam }} jam</td>
                    <td class="px-6 py-4 text-sm text-slate-700">Rp {{ number_format($t->biaya_total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
