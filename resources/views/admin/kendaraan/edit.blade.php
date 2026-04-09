@extends('layouts.admin')
@section('title','Edit Kendaraan')
@section('content')

<div class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">Edit Kendaraan</h2>

    <div class="bg-white rounded-3xl shadow p-8 space-y-6">
        <form method="POST" action="{{ route('admin.kendaraan.update', $kendaraan->id_kendaraan) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Plat Nomor</label>
                <input type="text" name="plat_nomor"
                    value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}"
                    class="w-full border rounded-lg px-3 py-2 uppercase focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('plat_nomor')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">ID Premotor (QR/Barcode)</label>
                <div class="flex gap-2">
                    <input type="text" id="id_premotor" name="id_premotor"
                        value="{{ old('id_premotor', $kendaraan->id_premotor) }}"
                        placeholder="Contoh: PREMOTOR-ABCDEFGH"
                        class="flex-1 border rounded-lg px-3 py-2 uppercase focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <button type="button" id="generatePremotorBtn" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition">
                        Generate
                    </button>
                </div>
                @error('id_premotor')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kendaraan</label>
                <select name="jenis_kendaraan" class="w-full border rounded-lg px-3 py-2">
                    <option value="motor"   {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) === 'motor'   ? 'selected' : '' }}>Motor</option>
                    <option value="mobil"   {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) === 'mobil'   ? 'selected' : '' }}>Mobil</option>
                    <option value="lainnya" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                <input type="text" name="warna"
                    value="{{ old('warna', $kendaraan->warna) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pemilik</label>
                <input type="text" name="pemilik"
                    value="{{ old('pemilik', $kendaraan->pemilik) }}"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Update
                </button>
                <a href="{{ route('admin.kendaraan.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-800 transition hover:bg-gray-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const generatePremotorBtn = document.getElementById('generatePremotorBtn');
    const premotorInput = document.getElementById('id_premotor');
    if (generatePremotorBtn && premotorInput) {
        generatePremotorBtn.addEventListener('click', () => {
            const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            let code = '';
            for (let i = 0; i < 8; i++) code += letters.charAt(Math.floor(Math.random() * letters.length));
            premotorInput.value = 'PREMOTOR-' + code;
        });
    }
</script>
@endpush

@endsection