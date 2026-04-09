<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table      = 'tb_transaksi';
    protected $primaryKey = 'id_parkir';
    protected $fillable   = [
        'id_kendaraan', 'waktu_masuk', 'waktu_keluar',
        'id_tarif', 'durasi_jam', 'biaya_total',
        'status', 'id_user', 'id_area'
    ];

    protected $casts = [
        'waktu_masuk'  => 'datetime',
        'waktu_keluar' => 'datetime',
    ];

    public function kendaraan()
{
    return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
}
    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'id_tarif', 'id_tarif');
    }

    public function area()
{
    return $this->belongsTo(AreaParkir::class, 'id_area');
}

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}