<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeluhanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'keluhan' => 'Layar mati total',
                'biaya_keluhan' => 150000,
            ],
            [
                'keluhan' => 'Keyboard tidak berfungsi',
                'biaya_keluhan' => 75000,
            ],
            [
                'keluhan' => 'Baterai cepat habis',
                'biaya_keluhan' => 120000,
            ],
            [
                'keluhan' => 'Overheating / panas berlebih',
                'biaya_keluhan' => 95000,
            ],
            [
                'keluhan' => 'Tidak bisa booting',
                'biaya_keluhan' => 200000,
            ],
            [
                'keluhan' => 'Port charger rusak',
                'biaya_keluhan' => 85000,
            ],
            [
                'keluhan' => 'Layar bergaris / flickering',
                'biaya_keluhan' => 175000,
            ],
            [
                'keluhan' => 'Suara speaker berisik / tidak keluar',
                'biaya_keluhan' => 65000,
            ],
            [
                'keluhan' => 'Touchpad tidak responsif',
                'biaya_keluhan' => 90000,
            ],
            [
                'keluhan' => 'WiFi tidak terdeteksi',
                'biaya_keluhan' => 110000,
            ],
            [
                'keluhan' => 'Kerusakan software / virus',
                'biaya_keluhan' => 50000,
            ],
            [
                'keluhan' => 'Fan berisik / tidak berputar',
                'biaya_keluhan' => 130000,
            ],
        ];

        DB::table('keluhan')->insert($data);

        echo "✅ Berhasil menambahkan " . count($data) . " data dummy keluhan.\n";
    }
}
