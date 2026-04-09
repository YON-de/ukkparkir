@extends('layouts.admin')
@section('title','Log Aktivitas')
@section('content')

<h2 class="text-2xl font-bold text-gray-700 mb-6">Log Aktivitas</h2>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-max text-sm divide-y divide-gray-200">
            <thead class="bg-blue-600 text-white text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Waktu</th>
                <th class="px-4 py-3 text-left">User</th>
                <th class="px-4 py-3 text-left">Role</th>
                <th class="px-4 py-3 text-left">Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $i => $log)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3">{{ $logs->firstItem() + $i }}</td>
                <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">
                    {{ $log->waktu_aktivitas }}
                </td>
                <td class="px-4 py-3 font-medium">{{ $log->user->nama_lengkap ?? '-' }}</td>
                <td class="px-4 py-3">
                    @if($log->user)
                    <span class="px-2 py-1 rounded text-xs font-bold
                        {{ $log->user->role === 'admin' ? 'bg-blue-100 text-blue-700' :
                          ($log->user->role === 'petugas' ? 'bg-green-100 text-green-700' :
                           'bg-yellow-100 text-yellow-700') }}">
                        {{ strtoupper($log->user->role) }}
                    </span>
                    @else
                    <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-4 py-3">{{ $log->aktivitas }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-8 text-gray-400">Belum ada log aktivitas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $logs->links() }}
    </div>
</div>

@endsection