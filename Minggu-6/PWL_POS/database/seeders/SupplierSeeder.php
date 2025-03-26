<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_supplier')->insert([
            ['supplier_kode' => 'SUP001', 'supplier_nama' => 'Supplier Ahmad', 'supplier_alamat' => 'Jl. Bandung No.1', 'created_at' => now(), 'updated_at' => now()],
            ['supplier_kode' => 'SUP002', 'supplier_nama' => 'Supplier Syariah', 'supplier_alamat' => 'Jl. Jakarta No.2', 'created_at' => now(), 'updated_at' => now()],
            ['supplier_kode' => 'SUP003', 'supplier_nama' => 'Supplier Bismillah', 'supplier_alamat' => 'Jl. Dewandaru No.2', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

