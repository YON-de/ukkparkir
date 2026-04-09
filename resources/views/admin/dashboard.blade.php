@extends('layouts.admin')
@section('title','Dashboard')
@section('content')

<div class="page-header mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-900">Dashboard Admin</h2>
        <p class="subtitle text-slate-600">Lihat ringkasan pengguna, area, kendaraan, dan transaksi harian secara cepat.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-5 text-center border-t-4 border-blue-500">
        <div class="text-4xl font-bold text-blue-600">{{ $totalUser }}</div>
        <div class="text-gray-500 mt-1 text-sm">User Aktif</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 text-center border-t-4 border-green-500">
        <div class="text-4xl font-bold text-green-600">{{ $totalArea }}</div>
        <div class="text-gray-500 mt-1 text-sm">Area Parkir</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 text-center border-t-4 border-yellow-500">
        <div class="text-4xl font-bold text-yellow-600">{{ $totalKendaraan }}</div>
        <div class="text-gray-500 mt-1 text-sm">Kendaraan</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 text-center border-t-4 border-purple-500">
        <div class="text-4xl font-bold text-purple-600">{{ $totalHariIni }}</div>
        <div class="text-gray-500 mt-1 text-sm">Transaksi Hari Ini</div>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-2">Pendapatan Hari Ini</h3>
    <p class="text-4xl font-bold text-green-600">
        Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
    </p>
</div>

@endsection