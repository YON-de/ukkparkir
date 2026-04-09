<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table      = 'tb_kendaraan';
    protected $primaryKey = 'id_kendaraan';
    protected $fillable   = ['plat_nomor', 'id_premotor', 'jenis_kendaraan', 'warna', 'pemilik', 'id_user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_kendaraan', 'id_kendaraan');
    }
}