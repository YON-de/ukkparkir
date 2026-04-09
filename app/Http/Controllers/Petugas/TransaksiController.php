<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    // HALAMAN TRANSAKSI
    public function index()
    {
        return view('petugas.transaksi');
    }

    // SIMPAN KENDARAAN MASUK
    public function masuk(Request $request)
    {
        $request->validate([
            'plat_nomor'      => 'required_without:id_premotor|string',
            'id_premotor'     => 'required_without:plat_nomor|string',
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'warna'           => 'required|string',
            'pemilik'         => 'required|string',
            'id_area'         => 'required|exists:tb_area_parkir,id_area',
        ]);

        $kendaraan = null;

        if ($request->filled('id_premotor')) {
            $kendaraan = Kendaraan::where('id_premotor', $request->id_premotor)->first();
        }

        if (!$kendaraan && $request->filled('plat_nomor')) {
            $kendaraan = Kendaraan::where('plat_nomor', $request->plat_nomor)->first();
        }

        $kendaraan = $kendaraan ?: new Kendaraan();

        $kendaraan->plat_nomor      = $request->plat_nomor ?: $kendaraan->plat_nomor;
        $kendaraan->id_premotor     = $kendaraan->id_premotor ?: ($request->id_premotor ?: 'PREMOTOR-' . strtoupper(Str::random(8)));
        $kendaraan->jenis_kendaraan = $request->jenis_kendaraan;
        $kendaraan->warna           = $request->warna;
        $kendaraan->pemilik         = $request->pemilik;
        $kendaraan->save();

        $tarif = Tarif::where('jenis_kendaraan', $kendaraan->jenis_kendaraan)->first();
        $area  = AreaParkir::findOrFail($request->id_area);

        if ($area->sisa <= 0) {
            return back()->with('error', "Area parkir {$area->nama_area} sudah penuh.");
        }

        $transaksi = Transaksi::create([
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'waktu_masuk'  => now(),
            'id_tarif'     => $tarif->id_tarif,
            'status'       => 'masuk',
            'id_user'      => auth()->user()->id_user,
            'id_area'      => $area->id_area,
        ]);

        $area->increment('terisi');

        return redirect()->route('petugas.struk.masuk', $transaksi->id_parkir);
    }

    // PROSES KELUAR
    public function keluar(Request $request)
    {
        $request->validate([
            'plat_nomor'  => 'required_without:id_premotor|string',
            'id_premotor' => 'required_without:plat_nomor|string',
        ]);

        $query = Transaksi::where('status', 'masuk');

        if ($request->filled('id_premotor')) {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('id_premotor', $request->id_premotor);
            });
        } else {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('plat_nomor', $request->plat_nomor);
            });
        }

        $transaksi = $query->latest('waktu_masuk')->first();

        if (!$transaksi) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $waktu_keluar = now();

        $durasi = ceil(
            Carbon::parse($transaksi->waktu_masuk)->diffInMinutes($waktu_keluar) / 60
        );

        $tarif = $transaksi->tarif->tarif_per_jam;
        $total = $durasi * $tarif;

        $transaksi->update([
            'waktu_keluar' => $waktu_keluar,
            'durasi_jam' => $durasi,
            'biaya_total' => $total,
            'status' => 'keluar'
        ]);

        if ($transaksi->area && $transaksi->area->terisi > 0) {
            $transaksi->area->decrement('terisi');
        }

        return redirect('/petugas/struk/' . $transaksi->id_parkir);
    }

    // STRUK
    public function struk($id)
    {
        $transaksi = Transaksi::with(['kendaraan', 'area'])->findOrFail($id);

        return view('petugas.struk', compact('transaksi'));
    }

    public function strukMasuk($id)
    {
        $transaksi = Transaksi::with(['kendaraan', 'area'])->findOrFail($id);

        return view('petugas.struk', compact('transaksi'));
    }
}