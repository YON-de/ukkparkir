<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser         = User::where('status_aktif', 1)->count();
        $totalArea         = AreaParkir::count();
        $totalKendaraan    = Kendaraan::count();
        $totalHariIni      = Transaksi::whereDate('waktu_masuk', today())->count();
        $pendapatanHariIni = Transaksi::whereDate('waktu_keluar', today())
                                ->where('status', 'keluar')
                                ->sum('biaya_total');

        return view('admin.dashboard', compact(
            'totalUser', 'totalArea', 'totalKendaraan',
            'totalHariIni', 'pendapatanHariIni'
        ));
    }
}