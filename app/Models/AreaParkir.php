<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class AreaParkir extends Model
{
    protected $table      = 'tb_area_parkir';
    protected $primaryKey = 'id_area';
    protected $fillable   = ['nama_area', 'kapasitas', 'terisi'];
 
    public function getSisaAttribute(): int
    {
        return $this->kapasitas - $this->terisi;
    }
 
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_area', 'id_area');
    }
}