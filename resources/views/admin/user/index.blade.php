@extends('layouts.admin')
@section('title','Kelola User')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-700">Kelola User</h2>
    <a href="{{ route('admin.users.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm transition">
        + Tambah User
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-max text-sm divide-y divide-gray-200">
            <thead class="bg-blue-600 text-white text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Nama Lengkap</th>
                <th class="px-4 py-3 text-left">Username</th>
                <th class="px-4 py-3 text-left">Role</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3 font-medium">{{ $user->nama_lengkap }}</td>
                <td class="px-4 py-3">{{ $user->username }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-xs font-bold
                        {{ $user->role === 'admin' ? 'bg-blue-100 text-blue-700' :
                          ($user->role === 'petugas' ? 'bg-green-100 text-green-700' :
                           'bg-yellow-100 text-yellow-700') }}">
                        {{ strtoupper($user->role) }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-xs font-bold
                        {{ $user->status_aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $user->status_aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex gap-2 justify-center">
                        <a href="{{ route('admin.users.edit', $user->id_user) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition shadow-sm">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id_user) }}"
                            onsubmit="return confirm('Yakin hapus/nonaktifkan user ini?')">
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
                <td colspan="6" class="text-center py-8 text-gray-400">Belum ada user.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection