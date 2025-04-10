<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(){
        //===================Jobsheet 3 Praktikum 4==========
        // DB::insert('insert into m_barang(kategori_id, barang_kode, barang_nama, harga_jual, harga_beli, created_at) values(?, ?, ?, ?, ?, ?)', [1, 'MSK-008', 'Kalimba', 180000, 100000, now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_barang set harga_jual = ? where barang_kode = ?', [110000, 'MSK-002']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from m_barang where barang_kode = ?', ['MSK-008']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::select('select * from m_barang');
        // return view('barang', ['data' => $data]);

        //=============Jobsheet 3 Praktikum 5==================
        // $data = [
        //     'kategori_id' => 1,
        //     'barang_kode' => 'MSK-007',
        //     'barang_nama' => 'Seruling',
        //     'harga_jual' => 150000,
        //     'harga_beli' => 100000,
        //     'created_at' => now()
        // ];
        // DB::table('m_barang')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_barang')->where('barang_kode', 'MSK-007')->update(['harga_jual' => '130000',]);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row =  DB::table('m_barang')->where('barang_kode', 'MSK-007')->delete();
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        $data = DB::table('m_barang')->get();
        return view('barang', ['data' => $data]);


    }
        
    
}
