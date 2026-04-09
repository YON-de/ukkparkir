@extends('layouts.petugas')

@section('title', 'Transaksi Petugas')
@section('content')

<div class="bg-white rounded-3xl shadow p-5">
    <h3 class="mb-4 text-2xl font-semibold text-slate-900">Transaksi Parkir</h3>
    <p class="text-sm text-slate-500 mb-4">Gunakan halaman dashboard untuk fitur penuh seperti pemindaian QR, chatbot, dan estimasi biaya.</p>

    <div class="row gy-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title mb-3">Kendaraan Masuk</h4>
                    <form method="POST" action="{{ route('petugas.masuk') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">ID Premotor / QR Code</label>
                            <input type="text" name="id_premotor" class="form-control" placeholder="ID Premotor / QR Code">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Plat Nomor</label>
                            <input type="text" name="plat_nomor" class="form-control" placeholder="Plat Nomor">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Catat Masuk</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title mb-3">Kendaraan Keluar</h4>
                    <form method="POST" action="{{ route('petugas.keluar') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">ID Premotor / QR Code</label>
                            <input type="text" name="id_premotor" class="form-control" placeholder="ID Premotor / QR Code">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Plat Nomor</label>
                            <input type="text" name="plat_nomor" class="form-control" placeholder="Plat Nomor">
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Proses Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-primary">Kembali ke Dashboard</a>
    </div>
</div>

@endsection