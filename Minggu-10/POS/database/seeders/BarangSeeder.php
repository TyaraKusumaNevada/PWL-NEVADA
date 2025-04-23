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
            [
                'kategori_id'   => 1, // MSK - Alat Musik
                'barang_kode'   => 'MSK-001',
                'barang_nama'   => 'Gitar Akustik Yamaha',
                'harga_beli'    => 1200000,
                'harga_jual'    => 1500000,
            ],
            [
                'kategori_id'   => 1, // MSK
                'barang_kode'   => 'MSK-002',
                'barang_nama'   => 'Keyboard yamaha CT-X700',
                'harga_beli'    => 2000000,
                'harga_jual'    => 2300000,
            ],
            [
                'kategori_id'   => 2, // TEX - Tekstil
                'barang_kode'   => 'TEX-001',
                'barang_nama'   => 'Kemeja Flanel',
                'harga_beli'    => 250000,
                'harga_jual'    => 299000,
            ],
            [
                'kategori_id'   => 2, // TEX
                'barang_kode'   => 'TEX-002',
                'barang_nama'   => 'Celana Jeans',
                'harga_beli'    => 400000,
                'harga_jual'    => 450000,
            ],
            [
                'kategori_id'   => 3, // OTM - Otomotif
                'barang_kode'   => 'OTM-001',
                'barang_nama'   => 'Oli Mesin Shell',
                'harga_beli'    => 95000,
                'harga_jual'    => 120000,
            ],
            [
                'kategori_id'   => 3, // OTM
                'barang_kode'   => 'OTM-002',
                'barang_nama'   => 'Aki GS Astra 12V',
                'harga_beli'    => 680000,
                'harga_jual'    => 750000,
            ],
            [
                'kategori_id'   => 4, // ATK - Alat Tulis
                'barang_kode'   => 'ATK-001',
                'barang_nama'   => 'Pulpen Pilot G2',
                'harga_beli'    => 10000,
                'harga_jual'    => 15000,
            ],
            [
                'kategori_id'   => 4, // ATK
                'barang_kode'   => 'ATK-002',
                'barang_nama'   => 'Buku Tulis Sidu A5',
                'harga_beli'    => 5000,
                'harga_jual'    => 7000,
            ],
            [
                'kategori_id'   => 5, // SPT - Sepatu
                'barang_kode'   => 'SPT-001',
                'barang_nama'   => 'Vans',
                'harga_beli'    => 480000,
                'harga_jual'    => 550000,
            ],
            [
                'kategori_id'   => 5, // SPT
                'barang_kode'   => 'SPT-002',
                'barang_nama'   => 'Converse Chuck',
                'harga_beli'    => 400000,
                'harga_jual'    => 450000,
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}
