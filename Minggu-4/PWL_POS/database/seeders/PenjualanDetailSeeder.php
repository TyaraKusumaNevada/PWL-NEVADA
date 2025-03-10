<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['detail_id' => 1, 'penjualan_id' => 1, 'barang_id' => 1, 'jumlah' => 2, 'harga' => 120000],
            ['detail_id' => 2, 'penjualan_id' => 2, 'barang_id' => 2, 'jumlah' => 3, 'harga' => 210000],
            ['detail_id' => 3, 'penjualan_id' => 3, 'barang_id' => 3, 'jumlah' => 5, 'harga' => 13000],
            ['detail_id' => 4, 'penjualan_id' => 4, 'barang_id' => 4, 'jumlah' => 4, 'harga' => 85000],
            ['detail_id' => 5, 'penjualan_id' => 5, 'barang_id' => 5, 'jumlah' => 7, 'harga' => 550000],
            ['detail_id' => 6, 'penjualan_id' => 6, 'barang_id' => 6, 'jumlah' => 3, 'harga' => 290000],
            ['detail_id' => 7, 'penjualan_id' => 7, 'barang_id' => 7, 'jumlah' => 2, 'harga' => 410000],
            ['detail_id' => 8, 'penjualan_id' => 8, 'barang_id' => 8, 'jumlah' => 3, 'harga' => 870000],
            ['detail_id' => 9, 'penjualan_id' => 9, 'barang_id' => 9, 'jumlah' => 1, 'harga' => 105000],
            ['detail_id' => 10, 'penjualan_id' => 10, 'barang_id' => 10, 'jumlah' => 5, 'harga' => 950000],
            ['detail_id' => 11, 'penjualan_id' => 1, 'barang_id' => 2, 'jumlah' => 1, 'harga' => 80000],
            ['detail_id' => 12, 'penjualan_id' => 2, 'barang_id' => 3, 'jumlah' => 2, 'harga' => 54000],
            ['detail_id' => 13, 'penjualan_id' => 3, 'barang_id' => 4, 'jumlah' => 1, 'harga' => 87000],
            ['detail_id' => 14, 'penjualan_id' => 4, 'barang_id' => 5, 'jumlah' => 3, 'harga' => 155000],
            ['detail_id' => 15, 'penjualan_id' => 5, 'barang_id' => 6, 'jumlah' => 2, 'harga' => 63000],
            ['detail_id' => 16, 'penjualan_id' => 6, 'barang_id' => 7, 'jumlah' => 1, 'harga' => 42000],
            ['detail_id' => 17, 'penjualan_id' => 7, 'barang_id' => 8, 'jumlah' => 2, 'harga' => 83000],
            ['detail_id' => 18, 'penjualan_id' => 8, 'barang_id' => 9, 'jumlah' => 3, 'harga' => 93000],
            ['detail_id' => 19, 'penjualan_id' => 9, 'barang_id' => 10, 'jumlah' => 2, 'harga' => 52000],
            ['detail_id' => 20, 'penjualan_id' => 10, 'barang_id' => 1, 'jumlah' => 1, 'harga' => 53000],
            ['detail_id' => 21, 'penjualan_id' => 1, 'barang_id' => 3, 'jumlah' => 5, 'harga' => 3000],
            ['detail_id' => 22, 'penjualan_id' => 2, 'barang_id' => 4, 'jumlah' => 4, 'harga' => 85000],
            ['detail_id' => 23, 'penjualan_id' => 3, 'barang_id' => 5, 'jumlah' => 2, 'harga' => 110000],
            ['detail_id' => 24, 'penjualan_id' => 4, 'barang_id' => 6, 'jumlah' => 3, 'harga' => 65000],
            ['detail_id' => 25, 'penjualan_id' => 5, 'barang_id' => 7, 'jumlah' => 1, 'harga' => 45000],
            ['detail_id' => 26, 'penjualan_id' => 6, 'barang_id' => 8, 'jumlah' => 2, 'harga' => 85000],
            ['detail_id' => 27, 'penjualan_id' => 7, 'barang_id' => 9, 'jumlah' => 3, 'harga' => 92000],
            ['detail_id' => 28, 'penjualan_id' => 8, 'barang_id' => 10, 'jumlah' => 2, 'harga' => 98000],
            ['detail_id' => 29, 'penjualan_id' => 9, 'barang_id' => 1, 'jumlah' => 4, 'harga' => 210000],
            ['detail_id' => 30, 'penjualan_id' => 10, 'barang_id' => 2, 'jumlah' => 5, 'harga' => 79000],
        ];

        DB::table('t_penjualan_detail')->insert($data);
    }
}

