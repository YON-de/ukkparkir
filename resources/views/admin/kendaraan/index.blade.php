@extends('layouts.admin')
@section('title','Kelola Kendaraan')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-700">Kelola Kendaraan</h2>
    <a href="{{ route('admin.kendaraan.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm transition">
        + Tambah Kendaraan
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-max text-sm divide-y divide-gray-200">
            <thead class="bg-blue-600 text-white text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Plat Nomor</th>
                <th class="px-4 py-3 text-left">ID Premotor</th>
                <th class="px-4 py-3 text-left">Jenis</th>
                <th class="px-4 py-3 text-left">Warna</th>
                <th class="px-4 py-3 text-left">Pemilik</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kendaraans as $i => $k)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3 font-bold">{{ $k->plat_nomor }}</td>
                <td class="px-4 py-3 font-mono text-xs">{{ $k->id_premotor ?? '-' }}</td>
                <td class="px-4 py-3 capitalize">{{ $k->jenis_kendaraan }}</td>
                <td class="px-4 py-3 capitalize">{{ $k->warna }}</td>
                <td class="px-4 py-3">{{ $k->pemilik }}</td>
                <td class="px-4 py-3 text-center">
                    <div class="flex gap-2 justify-center">
                        <a href="{{ route('admin.kendaraan.edit', $k->id_kendaraan) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition shadow-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.kendaraan.destroy', $k->id_kendaraan) }}"
                            onsubmit="return confirm('Yakin hapus kendaraan ini?')">
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
                <td colspan="6" class="text-center py-8 text-gray-400">Belum ada kendaraan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection