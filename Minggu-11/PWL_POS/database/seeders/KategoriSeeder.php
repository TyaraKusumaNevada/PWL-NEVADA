<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_kode' => 'MSK',
                'kategori_nama' => 'Alat Musik',
            ],
            [
                'kategori_kode' => 'TEX',
                'kategori_nama' => 'Tekstil',

            ],
            [
                'kategori_kode' => 'OTM',
                'kategori_nama' => 'Otomotif',
            ],
            [
                'kategori_kode' => 'ATK',
                'kategori_nama' => 'Alat Tulis',
            ],
            [
                'kategori_kode' => 'SPT',
                'kategori_nama' => 'Sepatu',
            ],
        ];

        DB::table('m_kategori')->insert($data);
    }
}
