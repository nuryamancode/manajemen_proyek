<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Direktur;
use App\Models\HR;
use App\Models\Klien;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create(
            [
                'email' => "human@gmail.com",
                'password' => bcrypt('human1212'),
                'role' => 'Human Resource',
            ]

        );
        User::create(
            [
                'email' => "direktur@gmail.com",
                'password' => bcrypt('direktur'),
                'role' => 'Direktur',
            ]
        );
        HR::create(
            [
                'name' => 'Dadang HR',
                'user_id' => 1
            ]
        );
        Direktur::create(
            [
                'name' => 'Usman Direktur',
                'user_id' => 2
            ]
        );
        Klien::create([
            'nama_klien' => 'Klien Baru',
            'alamat' => 'Jawa Barat',
            'nomor_handphone' => '238923928392832',
            'email' => 'klien@gmail.com',
        ]);
    }
}
