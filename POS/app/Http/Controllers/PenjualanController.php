<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller {

    public function index(){
        //======Jobsheet 3 Praktikum 4========
        // DB::insert('insert into t_penjualan(user_id, pembeli, penjualan_kode, tanggal_penjualan, created_at) values(?, ?, ?, ?, ?)', [3, 'Ayu Widodo', 'TR011', now(), now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update t_penjualan set pembeli = ? where penjualan_kode = ?', ['Selina Bunga', 'PNJ11']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from t_penjualan where penjualan_kode = ?', ['PNJ11']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        $data = DB::select('select * from t_penjualan');
        return view('penjualan', ['data' => $data]);
    }

    // public function penjualan() {
    //     return view('penjualan');
    // }
}
