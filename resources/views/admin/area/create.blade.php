@extends('layouts.admin')
@section('title','Tambah Area')
@section('content')

<div class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">Tambah Area Parkir</h2>

    <div class="bg-white rounded-3xl shadow p-8 space-y-6">
        <form method="POST" action="{{ route('admin.area.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Area</label>
                <input type="text" name="nama_area" value="{{ old('nama_area') }}"
                    placeholder="Contoh: Area A"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('nama_area')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" min="1"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('kapasitas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('admin.area.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-800 transition hover:bg-gray-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection