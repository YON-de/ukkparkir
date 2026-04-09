<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['nama_lengkap' => 'Administrator', 'username' => 'admin',    'role' => 'admin'],
            ['nama_lengkap' => 'Petugas Satu',  'username' => 'petugas1', 'role' => 'petugas'],
            ['nama_lengkap' => 'Petugas Dua',   'username' => 'petugas2', 'role' => 'petugas'],
            ['nama_lengkap' => 'Owner Parkir',  'username' => 'owner',    'role' => 'owner'],
        ];

        foreach ($users as $u) {
            User::create([
                'nama_lengkap' => $u['nama_lengkap'],
                'username'     => $u['username'],
                'password'     => bcrypt('password123'),
                'role'         => $u['role'],
                'status_aktif' => 1,
            ]);
        }
    }
}