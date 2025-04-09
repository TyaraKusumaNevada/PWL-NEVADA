<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id'          => 1,
                'user_id'            => 1,
                'supplier_id'        => 1,
                'stok_tanggal_masuk' => '2024-01-02 08:15:00',
                'stok_jumlah'        => 18,
            ],
            [
                'barang_id'          => 2,
                'user_id'            => 1,
                'supplier_id'        => 1,
                'stok_tanggal_masuk' => '2024-01-02 10:30:00',
                'stok_jumlah'        => 12,
            ],
            [
                'barang_id'          => 3,
                'user_id'            => 1,
                'supplier_id'        => 1,
                'stok_tanggal_masuk' => '2024-01-03 14:00:00',
                'stok_jumlah'        => 28,
            ],
            [
                'barang_id'          => 4,
                'user_id'            => 1,
                'supplier_id'        => 2,
                'stok_tanggal_masuk' => '2024-01-04 11:20:00',
                'stok_jumlah'        => 22,
            ],
            [
                'barang_id'          => 5,
                'user_id'            => 1,
                'supplier_id'        => 2,
                'stok_tanggal_masuk' => '2024-01-05 16:45:00',
                'stok_jumlah'        => 37,
            ],
            [
                'barang_id'          => 6,
                'user_id'            => 1,
                'supplier_id'        => 2,
                'stok_tanggal_masuk' => '2024-01-06 13:10:00',
                'stok_jumlah'        => 32,
            ],
            [
                'barang_id'          => 7,
                'user_id'            => 1,
                'supplier_id'        => 3,
                'stok_tanggal_masuk' => '2024-01-07 09:25:00',
                'stok_jumlah'        => 14,
            ],
            [
                'barang_id'          => 8,
                'user_id'            => 1,
                'supplier_id'        => 3,
                'stok_tanggal_masuk' => '2025-01-08 17:00:00',
                'stok_jumlah'        => 48,
            ],
            [
                'barang_id'          => 9,
                'user_id'            => 1,
                'supplier_id'        => 3,
                'stok_tanggal_masuk' => '2024-01-09 07:45:00',
                'stok_jumlah'        => 42,
            ],
            [
                'barang_id'          => 10,
                'user_id'            => 1,
                'supplier_id'        => 1,
                'stok_tanggal_masuk' => '2024-01-10 12:35:00',
                'stok_jumlah'        => 58,
            ],
        ];
        
        DB::table('t_stok')->insert($data);
        
    }
}
