<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::orderBy('plat_nomor')->get();
        return view('admin.kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        return view('admin.kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor'      => 'required|string|unique:tb_kendaraan,plat_nomor',
            'id_premotor'     => 'nullable|string|unique:tb_kendaraan,id_premotor',
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'warna'           => 'required|string',
            'pemilik'         => 'required|string',
        ]);

        $data = $request->only('plat_nomor', 'jenis_kendaraan', 'warna', 'pemilik');
        $data['id_premotor'] = $request->input('id_premotor') ?: 'PREMOTOR-' . strtoupper(Str::random(8));

        Kendaraan::create($data);
        LogAktivitas::catat("Menambahkan kendaraan: {$request->plat_nomor}");

        return redirect()->route('admin.kendaraan.index')
                         ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'plat_nomor'      => 'required|string|unique:tb_kendaraan,plat_nomor,' . $kendaraan->id_kendaraan . ',id_kendaraan',
            'id_premotor'     => 'nullable|string|unique:tb_kendaraan,id_premotor,' . $kendaraan->id_kendaraan . ',id_kendaraan',
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'warna'           => 'required|string',
            'pemilik'         => 'required|string',
        ]);

        $kendaraan->update($request->only('plat_nomor', 'id_premotor', 'jenis_kendaraan', 'warna', 'pemilik'));
        LogAktivitas::catat("Mengupdate kendaraan: {$kendaraan->plat_nomor}");

        return redirect()->route('admin.kendaraan.index')
                         ->with('success', 'Kendaraan berhasil diupdate.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        if ($kendaraan->transaksis()->exists()) {
            return redirect()->route('admin.kendaraan.index')
                             ->with('error', 'Kendaraan tidak bisa dihapus karena punya riwayat transaksi.');
        }

        LogAktivitas::catat("Menghapus kendaraan: {$kendaraan->plat_nomor}");
        $kendaraan->delete();

        return redirect()->route('admin.kendaraan.index')
                         ->with('success', 'Kendaraan berhasil dihapus.');
    }
}