<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTransaksi = Transaksi::where('status', 'keluar')->count();

        $totalPendapatan = Transaksi::where('status', 'keluar')->sum('biaya_total');

        $kendaraanAktif = Transaksi::where('status', 'masuk')->count();

        return view('owner.dashboard', compact(
            'totalTransaksi',
            'totalPendapatan',
            'kendaraanAktif'
        ));
    }
}