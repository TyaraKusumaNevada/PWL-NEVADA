<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanDetailController extends Controller
{
    public function index(){
        // DB::insert('insert into t_penjualan_detail(penjualan_id, barang_id, jumlah_barang, harga_barang, created_at) values(?, ?, ?, ?, ?)', [11, 11, 7, 180000, now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update t_penjualan_detail set jumlah_barang = ? where detail_id = ?', [3, 12]);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from t_penjualan_detail where detail_id = ?', [12]);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';
        
        // $data = DB::select('select * from t_penjualan_detail');
        // return view('penjualan_detail', ['data' => $data]);

        // =====Jobsheet 3 Praktikum 5=========================================================================================
        // $data = [
        //     'penjualan_id' => '11',
        //     'barang_id' => '11',
        //     'jumlah_barang' => '3',
        //     'harga_barang' => '130000',
        //     'created_at' => now()
        // ];

        // DB::table('t_penjualan_detail')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('t_penjualan_detail')->where('detail_id', '12')->update(['jumlah_barang' => '3']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::table('t_penjualan_detail')->where('detail_id', '12')->delete();
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::table('t_penjualan_detail')->get();
        // return view('penjualan_detail', ['data' => $data]);


        // ============Jobsheet 3 Praktikum 6=======
        // $data = [
        //     'penjualan_id' => '11',
        //     'barang_id' => '11',
        //     'jumlah_barang' => '2',
        //     'harga_barang' => '120000',
        //     'created_at' => now()
        // ];

        // PenjualanDetailModel::insert($data);

        $data =[
            'jumlah_barang' => '10'
        ];

        PenjualanDetailModel::where('detail_id', '16')->update($data);

        $penjualanDetail = PenjualanDetailModel::all();
        return view('penjualan_detail', ['data' => $penjualanDetail]);

    }
}

