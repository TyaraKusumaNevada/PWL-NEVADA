<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id'  => 1,
                'barang_id'     => 8,
                'jumlah' => 3,
                'harga'  => 50000,
            ],
            [
                'penjualan_id'  => 2,
                'barang_id'     => 10,
                'jumlah' => 1,
                'harga'  => 150000,
            ],
            [
                'penjualan_id'  => 3,
                'barang_id'     => 5,
                'jumlah' => 3,
                'harga'  => 20000,
            ],
            [
                'penjualan_id'  => 1,
                'barang_id'     => 1,
                'jumlah' => 2,
                'harga'  => 5000000,
            ],
            [
                'penjualan_id'  => 2,
                'barang_id'     => 2,
                'jumlah' => 1,
                'harga'  => 17000000,
            ],
            [
                'penjualan_id'  => 4,
                'barang_id'     => 6,
                'jumlah' => 2,
                'harga'  => 15000,
            ],
            [
                'penjualan_id'  => 5,
                'barang_id'     => 2,
                'jumlah' => 1,
                'harga'  => 100000,
            ],
            [
                'penjualan_id'  => 6,
                'barang_id'     => 7,
                'jumlah' => 4,
                'harga'  => 100000,
            ],
            [
                'penjualan_id'  => 7,
                'barang_id'     => 7,
                'jumlah' => 3,
                'harga'  => 100000,
            ],
            [
                'penjualan_id'  => 7,
                'barang_id'     => 8,
                'jumlah' => 1,
                'harga'  => 50000,
            ],
            [
                'penjualan_id'  => 8,
                'barang_id'     => 9,
                'jumlah' => 2,
                'harga'  => 350000,
            ],
            [
                'penjualan_id'  => 9,
                'barang_id'     => 8,
                'jumlah' => 2,
                'harga'  => 50000,
            ],
            [
                'penjualan_id'  => 9,
                'barang_id'     => 4,
                'jumlah' => 1,
                'harga'  => 300000,
            ],
            [
                'penjualan_id'  => 9,
                'barang_id'     => 10,
                'jumlah' => 3,
                'harga'  => 150000,
            ],
            [
                'penjualan_id'  => 10,
                'barang_id'     => 9,
                'jumlah' => 1,
                'harga'  => 350000,
            ],
            [
                'penjualan_id'  => 10,
                'barang_id'     => 1,
                'jumlah' => 1,
                'harga'  => 5000000,
            ],
        ];
        
        DB::table('t_penjualan_detail')->insert($data);
    }
}
