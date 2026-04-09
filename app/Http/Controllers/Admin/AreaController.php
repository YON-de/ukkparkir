<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = AreaParkir::all();
        return view('admin.area.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.area.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
        ]);

        AreaParkir::create([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'terisi'    => 0,
        ]);

        LogAktivitas::catat("Menambahkan area parkir: {$request->nama_area}");

        return redirect()->route('admin.area.index')
                         ->with('success', 'Area parkir berhasil ditambahkan.');
    }

    public function edit(AreaParkir $area)
    {
        return view('admin.area.edit', compact('area'));
    }

    public function update(Request $request, AreaParkir $area)
    {
        $request->validate([
            'nama_area' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:' . $area->terisi,
        ], [
            'kapasitas.min' => "Kapasitas tidak boleh kurang dari jumlah yang terisi ({$area->terisi}).",
        ]);

        $area->update($request->only('nama_area', 'kapasitas'));
        LogAktivitas::catat("Mengupdate area parkir: {$area->nama_area}");

        return redirect()->route('admin.area.index')
                         ->with('success', 'Area parkir berhasil diupdate.');
    }

    public function destroy(AreaParkir $area)
    {
        if ($area->terisi > 0) {
            return redirect()->route('admin.area.index')
                             ->with('error', 'Area tidak bisa dihapus karena masih ada kendaraan.');
        }

        if ($area->transaksis()->exists()) {
            return redirect()->route('admin.area.index')
                             ->with('error', 'Area tidak bisa dihapus karena ada riwayat transaksi.');
        }

        LogAktivitas::catat("Menghapus area parkir: {$area->nama_area}");
        $area->delete();

        return redirect()->route('admin.area.index')
                         ->with('success', 'Area parkir berhasil dihapus.');
    }
}