<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarif;

class TarifSeeder extends Seeder
{
    public function run(): void
    {
        Tarif::insert([
            ['jenis_kendaraan' => 'motor',   'tarif_per_jam' => 2000, 'created_at' => now(), 'updated_at' => now()],
            ['jenis_kendaraan' => 'mobil',   'tarif_per_jam' => 5000, 'created_at' => now(), 'updated_at' => now()],
            ['jenis_kendaraan' => 'lainnya', 'tarif_per_jam' => 3000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}