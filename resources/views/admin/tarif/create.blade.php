@extends('layouts.admin')
@section('title','Tambah Tarif')
@section('content')

<div class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">Tambah Tarif</h2>

    <div class="bg-white rounded-3xl shadow p-8 space-y-6">
        <form method="POST" action="{{ route('admin.tarif.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kendaraan</label>
                <select name="jenis_kendaraan" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih --</option>
                    <option value="motor"   {{ old('jenis_kendaraan') === 'motor'   ? 'selected' : '' }}>Motor</option>
                    <option value="mobil"   {{ old('jenis_kendaraan') === 'mobil'   ? 'selected' : '' }}>Mobil</option>
                    <option value="lainnya" {{ old('jenis_kendaraan') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('jenis_kendaraan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tarif per Jam (Rp)</label>
                <input type="number" name="tarif_per_jam" value="{{ old('tarif_per_jam') }}" min="1"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('tarif_per_jam')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('admin.tarif.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-800 transition hover:bg-gray-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection