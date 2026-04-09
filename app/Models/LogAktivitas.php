<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table      = 'tb_log_aktivitas';
    protected $primaryKey = 'id_log';
    public $timestamps    = false;
    protected $fillable   = ['id_user', 'aktivitas', 'waktu_aktivitas'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public static function catat(string $aktivitas): void
    {
        static::create([
            'id_user'         => auth()->id(),
            'aktivitas'       => $aktivitas,
            'waktu_aktivitas' => now(),
        ]);
    }
}