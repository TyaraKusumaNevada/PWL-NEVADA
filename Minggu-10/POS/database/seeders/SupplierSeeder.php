<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_id' => 1,
                'supplier_kode' => 'SUP01',
                'supplier_nama' => 'PT Budiono Makmur',
                'supplier_alamat' => 'Jl. Bandung No. 12, Malang'
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'SUP02',
                'supplier_nama' => 'PT Kokoh Adil',
                'supplier_alamat' => 'Jl. Setiabudi No. 32, Bogor'
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 'SUP03',
                'supplier_nama' => 'UD Griya Tekstil',
                'supplier_alamat' => 'Jl. Budi Utomo No. 5, Surabaya'
            ],
        ];

        DB::table('m_supplier')->insert($data);
    }
}
