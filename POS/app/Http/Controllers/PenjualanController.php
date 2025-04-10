<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller {

    public function index(){
        // ======Jobsheet 3 Praktikum 4========
        // DB::insert('insert into t_penjualan(user_id, pembeli, penjualan_kode, penjualan_tanggal, created_at) values(?, ?, ?, ?, ?)', [3, 'Ayu Widodo', 'TR011', now(), now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update t_penjualan set pembeli = ? where penjualan_kode = ?', ['Ayu Widodo', 'TR011']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from t_penjualan where penjualan_kode = ?', ['TR011']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::select('select * from t_penjualan');
        // return view('penjualan', ['data' => $data]);

        // // =================Jobsheet 3 Praktikum 5==========
        // $data = [
        //     'user_id' => '1',
        //     'pembeli' => 'Ayu Widodo',
        //     'penjualan_kode' => 'TR011',
        //     'penjualan_tanggal' => now(),
        //     'created_at' => now()
        // ];

        // DB::table('t_penjualan')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('t_penjualan')->where('penjualan_kode', 'TR11')->update(['pembeli' => 'Ayu Widodo']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::table('t_penjualan')->where('penjualan_kode', 'TR011')->delete();
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        
        // // ============Jobsheet 3 Praktikum 6=======
        // $data = [
        //     'user_id' => '3',
        //     'pembeli' => 'Ayu Widodo',
        //     'penjualan_kode' => 'TR011',
        //     'penjualan_tanggal' => now(),
        //     'created_at' => now()
        // ];

        // PenjualanModel::insert($data);

        // $data =[
        //     'pembeli' => 'Ayu Wiro',
        // ];

        // PenjualanModel::where('penjualan_kode', 'TR011')->update($data);

        // $penjualan = PenjualanModel::all();
        // return view('penjualan', ['data' => $penjualan]);

        
        // ========Jobsheet 4 Praktikum 1=========================

        $data = [
            'user_id' => '2',
            'pembeli' => 'Setia Budi',
            'penjualan_kode' => 'TR012',
            'penjualan_tanggal' => now(),
        ];
        PenjualanModel::create($data);

        $penjualan = PenjualanModel::all();
        return view('penjualan', ['data' => $penjualan]);
    }

    // public function penjualan() {
    //     return view('penjualan');
    // }
}
