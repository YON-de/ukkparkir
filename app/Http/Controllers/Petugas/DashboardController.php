<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        // Area + sisa
        $areas = AreaParkir::all()->map(function ($area) {
            $area->sisa = $area->kapasitas - $area->terisi;
            return $area;
        });

        // Tarif
        $tarifs = Tarif::all();

        $transaksiAktif = Transaksi::with(['kendaraan', 'area'])
            ->where('status', 'masuk')
            ->latest('waktu_masuk')
            ->get();

        return view('petugas.dashboard', compact(
            'areas',
            'tarifs',
            'transaksiAktif'
        ));
    }

    public function ai()
    {
        $areas = AreaParkir::all()->map(function ($area) {
            $area->sisa = $area->kapasitas - $area->terisi;
            return $area;
        });

        $tarifs = Tarif::all();

        return view('petugas.ai', compact('areas', 'tarifs'));
    }
}