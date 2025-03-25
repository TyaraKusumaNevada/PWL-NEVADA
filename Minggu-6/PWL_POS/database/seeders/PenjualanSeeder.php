<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 1, 'pembeli' => 'Neva', 'penjualan_kode' => Str::random(10), 'penjualan_tanggal' => Carbon::parse('2024-04-01 09:30:00')],
            ['penjualan_id' => 2, 'user_id' => 1, 'pembeli' => 'Ghetsa', 'penjualan_kode' => Str::random(10), 'penjualan_tanggal' => Carbon::parse('2024-04-02 11:15:00')],
            ['penjualan_id' => 3, 'user_id' => 1, 'pembeli' => 'Oltha', 'penjualan_kode' => Str::random(10), 'penjualan_tanggal' => Carbon::parse('2024-04-03 13:45:00')],
            ['penjualan_id' => 4, 'user_id' => 1, 'pembeli' => 'Reika', 'penjualan_kode' => Str::random(10), 'penjualan_tanggal' => Carbon::parse('2024-04-04 08:20:00')],
            ['penjualan_id' => 5, 'user_id' => 1, 'pembeli' => 'Bella', 'penjualan_kode' => Str::random(10), 'penjualan_tanggal' => Carbon::parse('2024-04-05 14:10:00')],
            ['penjualan_id' => 6, 'user_id' => 1, 'pembeli' => 'Vanesa', 'penjualan_kode' => Str::random(10), 'penjualan_tanggal' => Carbon::parse('2024-04-06 17:30:00')],
            ['penjualan_id' => 7, 'user_id' => 1, 'pembeli' => 'Annisa', 'penjualan_kode' => Str::random(10), 'penjualan_tanggal' => Carbon::parse('2024-04-07 10:00:00')],
            ['penjualan_id' => 8, 'user_id' => 1, 'pembeli' => 'Praja', 'penjualan_kode' => Str::random(10), 'penjualan_tanggal' => Carbon::parse('2024-04-08 12:45:00')],
            ['penjualan_id' => 9, 'user_id' => 1, 'pembeli' => 'Hamam', 'penjualan_kode' => Str::random(10), 'penjualan_tanggal' => Carbon::parse('2024-04-09 15:20:00')],
            ['penjualan_id' => 10, 'user_id' => 1, 'pembeli' => 'Fajar', 'penjualan_kode' => Str::random(10), 'penjualan_tanggal' => Carbon::parse('2024-04-10 09:55:00')],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
