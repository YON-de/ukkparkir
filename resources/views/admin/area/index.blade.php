@extends('layouts.admin')
@section('title','Kelola Area')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-700">Kelola Area Parkir</h2>
    <a href="{{ route('admin.area.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm transition">
        + Tambah Area
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-max text-sm divide-y divide-gray-200">
            <thead class="bg-blue-600 text-white text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Nama Area</th>
                <th class="px-4 py-3 text-center">Kapasitas</th>
                <th class="px-4 py-3 text-center">Terisi</th>
                <th class="px-4 py-3 text-center">Sisa</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($areas as $i => $area)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3 font-medium">{{ $area->nama_area }}</td>
                <td class="px-4 py-3 text-center">{{ $area->kapasitas }}</td>
                <td class="px-4 py-3 text-center {{ $area->terisi >= $area->kapasitas ? 'text-red-600 font-bold' : '' }}">
                    {{ $area->terisi }}
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 rounded text-xs font-bold
                        {{ $area->sisa > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $area->sisa }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex gap-2 justify-center">
                        <a href="{{ route('admin.area.edit', $area->id_area) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition shadow-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.area.destroy', $area->id_area) }}"
                            onsubmit="return confirm('Yakin hapus area ini?')">
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
                <td colspan="6" class="text-center py-8 text-gray-400">Belum ada area parkir.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection