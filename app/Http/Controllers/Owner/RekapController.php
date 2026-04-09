<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $filter   = $request->filter ?? 'bulan';
        $tglAwal  = $request->tgl_awal;
        $tglAkhir = $request->tgl_akhir;

        $query = Transaksi::with(['kendaraan', 'area', 'tarif'])->where('status', 'keluar');

        if ($filter === 'hari') {
            $query->whereDate('waktu_keluar', today());
        } elseif ($filter === 'minggu') {
            $query->whereBetween('waktu_keluar', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter === 'bulan') {
            $query->whereMonth('waktu_keluar', now()->month)
                  ->whereYear('waktu_keluar', now()->year);
        } elseif ($filter === 'custom' && $tglAwal && $tglAkhir) {
            $query->whereBetween('waktu_keluar', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59']);
        }

        $transaksi = $query->orderByDesc('waktu_keluar')->get();
        $totalPendapatan = $transaksi->sum('biaya_total');
        $totalTransaksi  = $transaksi->count();
        $perJenis        = $transaksi->groupBy(fn($t) => $t->kendaraan->jenis_kendaraan)
                                      ->map(fn($g) => ['count' => $g->count(), 'total' => $g->sum('biaya_total')]);

        return view('owner.rekap', compact(
            'transaksi', 'totalPendapatan', 'totalTransaksi',
            'perJenis', 'filter', 'tglAwal', 'tglAkhir'
        ));
    }
}