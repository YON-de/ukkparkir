@extends('layouts.admin')
@section('title','Kelola Tarif')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-700">Kelola Tarif Parkir</h2>
    <a href="{{ route('admin.tarif.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm transition">
        + Tambah Tarif
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-max text-sm divide-y divide-gray-200">
            <thead class="bg-blue-600 text-white text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Jenis Kendaraan</th>
                <th class="px-4 py-3 text-left">Tarif per Jam</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tarifs as $i => $tarif)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3 font-medium capitalize">{{ $tarif->jenis_kendaraan }}</td>
                <td class="px-4 py-3">Rp {{ number_format($tarif->tarif_per_jam, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-center">
                    <div class="flex gap-2 justify-center">
                        <a href="{{ route('admin.tarif.edit', $tarif->id_tarif) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition shadow-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.tarif.destroy', $tarif->id_tarif) }}"
                            onsubmit="return confirm('Yakin hapus tarif ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-8 text-gray-400">Belum ada tarif.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection