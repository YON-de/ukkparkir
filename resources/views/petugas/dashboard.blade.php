@extends('layouts.petugas')
@section('title','Dashboard Petugas')
@section('content')

<div class="page-header mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-900">Dashboard Petugas</h2>
        <p class="subtitle">Kelola parkir masuk/keluar, cetak struk, dan lihat ringkasan area parkir.</p>
    </div>
    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('petugas.transaksi') }}" class="btn btn-outline-secondary">Lihat Transaksi</a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-5 text-center border-t-4 border-blue-500">
        <div class="text-4xl font-bold text-blue-600">{{ $transaksiAktif->count() }}</div>
        <div class="text-gray-500 mt-1 text-sm">Kendaraan Parkir</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 text-center border-t-4 border-green-500">
        <div class="text-4xl font-bold text-green-600">{{ $areas->sum('sisa') }}</div>
        <div class="text-gray-500 mt-1 text-sm">Slot Tersedia</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 text-center border-t-4 border-purple-500">
        <div class="text-4xl font-bold text-purple-600">Tarif</div>
        <div class="text-gray-500 mt-1 text-sm">Per Jam</div>
        <div class="mt-4 space-y-3 text-left">
            @foreach($tarifs as $t)
            <div class="rounded-2xl bg-slate-50 p-3 flex items-center justify-between gap-3">
                <span class="capitalize text-slate-700">{{ $t->jenis_kendaraan }}</span>
                <span class="font-semibold text-slate-900">Rp {{ number_format($t->tarif_per_jam,0,',','.') }}/jam</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-3xl shadow-sm p-6">
        <h3 class="text-xl font-semibold text-slate-900 mb-5">Input Parkir Masuk</h3>
        <form method="POST" action="{{ route('petugas.masuk') }}">
            @csrf
            <div class="grid gap-4">
                <label class="space-y-2">
                    <span class="text-sm font-medium text-slate-700">ID Premotor / QR Code</span>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="text" name="id_premotor" id="id_premotor" placeholder="Scan atau isi ID Premotor"
                            class="flex-1 border rounded-2xl px-4 py-3 uppercase focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        <button type="button" id="generatePremotor" class="btn btn-warning btn-sm">Generate</button>
                        <button type="button" id="scanQrBtn" class="btn btn-info btn-sm">Kamera</button>
                    </div>
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-medium text-slate-700">Plat Nomor</span>
                    <input type="text" name="plat_nomor" placeholder="B1234ABC"
                        class="w-full border rounded-2xl px-4 py-3 uppercase focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-medium text-slate-700">Jenis Kendaraan</span>
                    <select name="jenis_kendaraan" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-400" required>
                        <option value="">-- Pilih --</option>
                        <option value="motor">Motor</option>
                        <option value="mobil">Mobil</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-medium text-slate-700">Warna</span>
                    <input type="text" name="warna" placeholder="Hitam"
                        class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-400" required>
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-medium text-slate-700">Pemilik</span>
                    <input type="text" name="pemilik" placeholder="Nama pemilik"
                        class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-400" required>
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-medium text-slate-700">Area Parkir</span>
                    <select name="id_area" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-400" required>
                        <option value="">-- Pilih Area --</option>
                        @foreach($areas as $area)
                        <option value="{{ $area->id_area }}" {{ $area->sisa <= 0 ? 'disabled' : '' }}>
                            {{ $area->nama_area }} ({{ $area->sisa > 0 ? 'Sisa: ' . $area->sisa : 'PENUH' }})
                        </option>
                        @endforeach
                    </select>
                </label>
            </div>
            <button type="submit" class="btn btn-success mt-5 w-full">Catat Masuk</button>
        </form>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-sm p-6">
            <h3 class="text-xl font-semibold text-slate-900 mb-5">Kendaraan Keluar</h3>
            <form method="POST" action="{{ route('petugas.keluar') }}">
                @csrf
                <div class="grid gap-4">
                    <label class="space-y-2">
                        <span class="text-sm font-medium text-slate-700">ID Premotor / QR Code</span>
                        <input type="text" name="id_premotor" id="id_premotor_keluar" value="{{ request('exit_id') ?? old('id_premotor') }}" placeholder="Scan atau isi ID Premotor"
                            class="w-full border rounded-2xl px-4 py-3 uppercase focus:outline-none focus:ring-2 focus:ring-red-400">
                        @if(request('exit_id'))
                            <p class="text-xs text-emerald-600">ID Premotor keluaran terakhir telah dimasukkan otomatis.</p>
                        @endif
                    </label>
                    <label class="space-y-2">
                        <span class="text-sm font-medium text-slate-700">Plat Nomor</span>
                        <input type="text" name="plat_nomor" placeholder="B1234ABC"
                            class="w-full border rounded-2xl px-4 py-3 uppercase focus:outline-none focus:ring-2 focus:ring-red-400">
                    </label>
                </div>
                <button type="submit" class="btn btn-danger mt-5 w-full">Proses Keluar</button>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Tarif Berlaku</p>
                    <p class="text-sm text-slate-500 mt-1">Lihat tarif per jenis kendaraan.</p>
                </div>
                <span class="badge">Info</span>
            </div>
            <div class="space-y-3">
                @foreach($tarifs as $t)
                <div class="rounded-3xl bg-slate-50 p-4 flex items-center justify-between gap-4">
                    <div>
                        <p class="font-semibold capitalize text-slate-900">{{ $t->jenis_kendaraan }}</p>
                        <p class="text-xs text-slate-500">Tarif per jam</p>
                    </div>
                    <p class="font-semibold text-slate-900">Rp {{ number_format($t->tarif_per_jam,0,',','.') }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div id="scannerModal" class="fixed inset-0 bg-black bg-opacity-50 d-none items-center justify-center p-4 z-50" style="display:none;">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-4">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="text-lg font-bold">Pindai QR/Barcode</h4>
                <p class="text-sm text-gray-500">Arahkan kamera ke QR atau barcode ID Premotor.</p>
            </div>
            <button id="closeScanner" type="button" class="text-gray-700 hover:text-gray-900">✕</button>
        </div>
        <video id="scannerVideo" class="w-full h-96 bg-black rounded-lg"></video>
        <p id="scannerStatus" class="text-sm text-gray-500 mt-3">Menunggu kamera...</p>
    </div>

</div>

{{-- TABEL KENDARAAN AKTIF --}}
<div class="bg-white rounded-3xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex items-center justify-between gap-3">
        <div>
            <h3 class="font-bold text-slate-900">Kendaraan Sedang Parkir ({{ $transaksiAktif->count() }})</h3>
            <p class="text-sm text-slate-500">Klik tombol keluar untuk memproses kendaraan tanpa mengetik ulang ID Premotor.</p>
        </div>
    </div>
    <div class="overflow-auto">
        <table class="w-full text-sm text-slate-700">
            <thead class="bg-slate-100 text-slate-800">
                <tr>
                    <th class="px-4 py-3 text-left">Plat</th>
                    <th class="px-4 py-3 text-left">Jenis</th>
                    <th class="px-4 py-3 text-left">Area</th>
                    <th class="px-4 py-3 text-left">Masuk</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiAktif as $t)
                <tr class="border-b last:border-b-0 hover:bg-slate-50">
                    <td class="px-4 py-3 font-semibold">{{ $t->kendaraan->plat_nomor }}</td>
                    <td class="px-4 py-3 capitalize">{{ $t->kendaraan->jenis_kendaraan }}</td>
                    <td class="px-4 py-3">{{ $t->area->nama_area }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $t->waktu_masuk->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('petugas.keluar') }}">
                            @csrf
                            <input type="hidden" name="id_premotor" value="{{ $t->kendaraan->id_premotor }}">
                            <button type="submit" class="btn btn-danger btn-sm">Keluar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-slate-400">Tidak ada kendaraan parkir saat ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    const generatePremotor = document.getElementById('generatePremotor');
    const scanQrBtn = document.getElementById('scanQrBtn');
    const closeScanner = document.getElementById('closeScanner');
    const scannerModal = document.getElementById('scannerModal');
    const scannerVideo = document.getElementById('scannerVideo');
    const scannerStatus = document.getElementById('scannerStatus');
    const idPremotorInput = document.getElementById('id_premotor');

    let scannerStream;
    let scanInterval;

    const stopCamera = () => {
        if (scanInterval) {
            clearInterval(scanInterval);
            scanInterval = null;
        }
        if (scannerStream) {
            scannerStream.getTracks().forEach(track => track.stop());
            scannerStream = null;
        }
        if (scannerVideo) scannerVideo.srcObject = null;
        scannerModal.classList.add('hidden');
        scannerModal.classList.add('d-none');
        scannerModal.style.display = 'none';
    };

    const startScanner = async () => {
        if (!('BarcodeDetector' in window)) {
            scannerStatus.textContent = 'Browser tidak mendukung pemindaian QR otomatis. Silakan input manual ID Premotor.';
            return;
        }

        try {
            scannerStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
            scannerVideo.srcObject = scannerStream;
            await scannerVideo.play();
            scannerModal.classList.remove('hidden');
            scannerModal.classList.remove('d-none');
            scannerModal.style.display = 'flex';
            scannerStatus.textContent = 'Membaca QR/Barcode... Arahkan kamera ke kode.';

            const detector = new BarcodeDetector({ formats: ['qr_code', 'code_128', 'code_39'] });
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            scanInterval = setInterval(async () => {
                if (scannerVideo.readyState !== HTMLMediaElement.HAVE_ENOUGH_DATA) return;
                canvas.width = scannerVideo.videoWidth;
                canvas.height = scannerVideo.videoHeight;
                context.drawImage(scannerVideo, 0, 0, canvas.width, canvas.height);
                try {
                    const barcodes = await detector.detect(canvas);
                    if (barcodes.length > 0) {
                        const kode = barcodes[0].rawValue;
                        idPremotorInput.value = kode;
                        scannerStatus.textContent = `Kode terdeteksi: ${kode}`;
                        stopCamera();
                    }
                } catch (error) {
                    scannerStatus.textContent = 'Gagal membaca kode. Harap coba ulang.';
                }
            }, 700);
        } catch (error) {
            scannerStatus.textContent = 'Tidak dapat mengakses kamera: ' + error.message;
        }
    };

    const randomPremotorId = () => {
        const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const numbers = '0123456789';
        let code = '';
        for (let i = 0; i < 8; i++) {
            code += i % 2 === 0 
                ? letters.charAt(Math.floor(Math.random() * letters.length))
                : numbers.charAt(Math.floor(Math.random() * numbers.length));
        }
        return `PREMOTOR-${code}`;
    };

    generatePremotor.addEventListener('click', (e) => {
        e.preventDefault();
        const generated = randomPremotorId();
        idPremotorInput.value = generated;
        idPremotorInput.focus();
    });

    scanQrBtn.addEventListener('click', (e) => {
        e.preventDefault();
        startScanner();
    });

    if (closeScanner) {
        closeScanner.addEventListener('click', stopCamera);
    }
</script>

@endsection
