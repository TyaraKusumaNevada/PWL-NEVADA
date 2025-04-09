<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id'           => 3,
                'pembeli'           => 'Andi Pratama',
                'penjualan_kode'    => 'TR001',
                'tanggal_penjualan' => '2025-02-01 10:00:00',
            ],
            [
                'user_id'           => 3,
                'pembeli'           => 'Fitri Handoko',
                'penjualan_kode'    => 'TR002',
                'tanggal_penjualan' => '2025-02-02 10:00:00',
            ],
            [
                'user_id'           => 3,
                'pembeli'           => 'Yusuf Maulana',
                'penjualan_kode'    => 'TR003',
                'tanggal_penjualan' => '2025-02-03 10:00:00',
            ],
            [
                'user_id'           => 1,
                'pembeli'           => 'Melati Ayu',
                'penjualan_kode'    => 'TR004',
                'tanggal_penjualan' => '2025-02-04 10:00:00',
            ],
            [
                'user_id'           => 3,
                'pembeli'           => 'Bagus Fajar',
                'penjualan_kode'    => 'TR005',
                'tanggal_penjualan' => '2025-02-05 10:00:00',
            ],
            [
                'user_id'           => 1,
                'pembeli'           => 'Lita Maharani',
                'penjualan_kode'    => 'TR006',
                'tanggal_penjualan' => '2025-02-06 10:00:00',
            ],
            [
                'user_id'           => 3,
                'pembeli'           => 'Rizky Ramadhan',
                'penjualan_kode'    => 'TR007',
                'tanggal_penjualan' => '2025-02-07 10:00:00',
            ],
            [
                'user_id'           => 3,
                'pembeli'           => 'Sherly Putri',
                'penjualan_kode'    => 'TR008',
                'tanggal_penjualan' => '2025-02-08 10:00:00',
            ],
            [
                'user_id'           => 3,
                'pembeli'           => 'Galih Dwi',
                'penjualan_kode'    => 'TR009',
                'tanggal_penjualan' => '2025-02-09 10:00:00',
            ],
            [
                'user_id'           => 3,
                'pembeli'           => 'Budiono Siregar',
                'penjualan_kode'    => 'TR010',
                'tanggal_penjualan' => '2025-02-10 10:00:00',
            ],
        ];
        
        DB::table('t_penjualan')->insert($data);
        
    }
}
