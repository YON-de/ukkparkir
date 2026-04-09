<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AreaParkir;

class AreaParkirSeeder extends Seeder
{
    public function run(): void
    {
        AreaParkir::insert([
            ['nama_area' => 'Area A', 'kapasitas' => 20, 'terisi' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['nama_area' => 'Area B', 'kapasitas' => 15, 'terisi' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['nama_area' => 'Area C', 'kapasitas' => 10, 'terisi' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}