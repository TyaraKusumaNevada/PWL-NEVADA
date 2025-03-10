<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Laptop', 'kategori_id' => 1, 'harga_beli' => 10000000, 'harga_jual' => 12000000],
            ['barang_id' => 2, 'barang_kode' => 'BRG002', 'barang_nama' => 'Baju Kaos', 'kategori_id' => 2, 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['barang_id' => 3, 'barang_kode' => 'BRG003', 'barang_nama' => 'Roti Gandum', 'kategori_id' => 3, 'harga_beli' => 20000, 'harga_jual' => 25000],
            ['barang_id' => 4, 'barang_kode' => 'BRG004', 'barang_nama' => 'Susu Bubuk', 'kategori_id' => 4, 'harga_beli' => 40000, 'harga_jual' => 50000],
            ['barang_id' => 5, 'barang_kode' => 'BRG005', 'barang_nama' => 'Meja Lipat', 'kategori_id' => 5, 'harga_beli' => 400000, 'harga_jual' => 500000],
            ['barang_id' => 6, 'barang_kode' => 'BRG006', 'barang_nama' => 'Smartphone', 'kategori_id' => 1, 'harga_beli' => 6000000, 'harga_jual' => 7000000],
            ['barang_id' => 7, 'barang_kode' => 'BRG007', 'barang_nama' => 'Celana Jeans', 'kategori_id' => 2, 'harga_beli' => 250000, 'harga_jual' => 300000],
            ['barang_id' => 8, 'barang_kode' => 'BRG008', 'barang_nama' => 'Snack Asin', 'kategori_id' => 3, 'harga_beli' => 8000, 'harga_jual' => 10000],
            ['barang_id' => 9, 'barang_kode' => 'BRG009', 'barang_nama' => 'Teh Botol', 'kategori_id' => 4, 'harga_beli' => 2000, 'harga_jual' => 3000],
            ['barang_id' => 10, 'barang_kode' => 'BRG010', 'barang_nama' => 'Gitar', 'kategori_id' => 5, 'harga_beli' => 600000, 'harga_jual' => 750000],
        ];
  
        DB::table('m_barang')->insert($data);
    }
}
