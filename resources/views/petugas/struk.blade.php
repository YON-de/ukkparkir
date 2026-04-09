<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Parkir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f3f4f6; font-family: Arial, sans-serif; }
        .struk { max-width: 420px; margin: 2rem auto; background: #fff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); }
        .center { text-align: center; }
        .small { font-size: 0.9rem; color: #6b7280; }
    </style>
</head>
<body>

<div class="struk">
    <div class="center mb-4">
        <h3 class="mb-1">APLIKASI PARKIR</h3>
        <p class="small mb-0">Struk Parkir</p>
    </div>

    <div class="mb-3">
        <p class="mb-1"><strong>Status:</strong> {{ ucfirst($transaksi->status) }}</p>
        <p class="mb-1"><strong>Plat:</strong> {{ $transaksi->kendaraan->plat_nomor }}</p>
        <p class="mb-1"><strong>ID Premotor:</strong> {{ $transaksi->kendaraan->id_premotor ?? '-' }}</p>
        <p class="mb-1"><strong>Area:</strong> {{ $transaksi->area->nama_area ?? '-' }}</p>
        <p class="mb-1"><strong>Masuk:</strong> {{ $transaksi->waktu_masuk->format('d/m/Y H:i') }}</p>
        @if($transaksi->status === 'keluar')
            <p class="mb-1"><strong>Keluar:</strong> {{ $transaksi->waktu_keluar->format('d/m/Y H:i') }}</p>
            <p class="mb-1"><strong>Durasi:</strong> {{ $transaksi->durasi_jam }} jam</p>
        @else
            <p class="mb-1"><strong>Keluar:</strong> -</p>
            <p class="mb-1"><strong>Durasi:</strong> -</p>
        @endif
    </div>

    <div class="border-top pt-3 mb-4">
        <p class="mb-1"><strong>Total:</strong></p>
        <p class="h5">Rp {{ number_format($transaksi->biaya_total, 0, ',', '.') }}</p>
    </div>

    <div class="d-flex gap-2 justify-content-center mb-3 flex-wrap struk-buttons no-print">
        <button class="btn btn-primary btn-sm" onclick="window.print()">Cetak Struk</button>
        <a href="{{ route('petugas.dashboard', ['exit_id' => $transaksi->kendaraan->id_premotor]) }}" class="btn btn-outline-secondary btn-sm">Proses Keluar</a>
        <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-primary btn-sm">Kembali ke Dashboard</a>
    </div>

    <div class="center small">Terima kasih telah menggunakan layanan parkir.</div>
</div>

</body>
</html>