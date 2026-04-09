<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::all();
        return view('admin.tarif.index', compact('tarifs'));
    }

    public function create()
    {
        return view('admin.tarif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya|unique:tb_tarif,jenis_kendaraan',
            'tarif_per_jam'   => 'required|integer|min:1',
        ]);

        Tarif::create($request->only('jenis_kendaraan', 'tarif_per_jam'));
        LogAktivitas::catat("Menambahkan tarif: {$request->jenis_kendaraan} = Rp {$request->tarif_per_jam}/jam");

        return redirect()->route('admin.tarif.index')
                         ->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit(Tarif $tarif)
    {
        return view('admin.tarif.edit', compact('tarif'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $request->validate([
            'tarif_per_jam' => 'required|integer|min:1',
        ]);

        $tarif->update(['tarif_per_jam' => $request->tarif_per_jam]);
        LogAktivitas::catat("Mengupdate tarif {$tarif->jenis_kendaraan} menjadi Rp {$request->tarif_per_jam}/jam");

        return redirect()->route('admin.tarif.index')
                         ->with('success', 'Tarif berhasil diupdate.');
    }

    public function destroy(Tarif $tarif)
    {
        if ($tarif->transaksis()->exists()) {
            return redirect()->route('admin.tarif.index')
                             ->with('error', 'Tarif tidak bisa dihapus karena masih digunakan di transaksi.');
        }

        LogAktivitas::catat("Menghapus tarif: {$tarif->jenis_kendaraan}");
        $tarif->delete();

        return redirect()->route('admin.tarif.index')
                         ->with('success', 'Tarif berhasil dihapus.');
    }
}