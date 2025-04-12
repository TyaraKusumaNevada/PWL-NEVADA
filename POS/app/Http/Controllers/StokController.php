<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\UserModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index(){
        //============Jobsheet 3 Praktikum 4============
        // DB::insert('insert into t_stok(barang_id, user_id, supplier_id, stok_tanggal, stok_jumlah, created_at) values(?, ?, ?, ?, ?, ?)', [10, 1, 1, now(), 100, now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update t_stok set stok_jumlah = ? where stok_id = ?', [15, 10]);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from t_stok where stok_id = ?', [10]);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::select('select * from t_stok');
        // return view('stok', ['data' => $data]);


        //===========Jobsheet 3 Praktikum 5===========
        // $data = [
        //     'barang_id' => '10',
        //     'user_id' => '1',
        //     'supplier_id' => '1',
        //     'stok_tanggal' => now(),
        //     'stok_jumlah' => '100',
        //     'created_at' => now()
        // ];

        // DB::table('t_stok')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('t_stok')->where('stok_id', '10')->update(['stok_jumlah' => '130']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::table('t_stok')->where('stok_id', '10')->delete();
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::table('t_stok')->get();
        // return view('stok', ['data' => $data]);

        // =====Jobsheet 3 Praktikum 6====
        // $data = [
        //     'barang_id' => '11',
        //     'user_id' => '1',
        //     'supplier_id' => '1',
        //     'stok_tanggal' => now(),
        //     'stok_jumlah' => '100',
        //     'created_at' => now()
        // ];

        // StokModel::insert($data);

        // $data =[
        //     'stok_jumlah' => '160'
        // ];

        // StokModel::where('stok_id', '3')->update($data);

        // $stok = StokModel::all();
        // return view('stok', ['data' => $stok]);


        // ========Jobsheet 4 Praktikum 1=========================

        // $data = [
        //     'barang_id' => '10',
        //     'user_id' => '1',
        //     'supplier_id' => '3',
        //     'stok_tanggal' => now(),
        //     'stok_jumlah' => '60'
        // ];

        // StokModel::create($data);

        $stok = StokModel::all();
        return view('stok', ['data' => $stok]);
    }

    // ===Jobsheet 4 Praktikum 2.6==========
    public function tambah()
    {
        $barang = BarangModel::all();
        $user    = UserModel::all();
        $supplier = SupplierModel::all();

        return view('stok_tambah', ['barang' => $barang, 'user' => $user, 'supplier' => $supplier]);
    }

    public function tambah_simpan(Request $request)
    {
        StokModel::create([
            'barang_id'    => $request->barang_id,
            'user_id'      => $request->user_id,
            'supplier_id'  => $request->supplier_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah'  => $request->stok_jumlah,
        ]);

        return redirect('/stok');
    }

    public function ubah($id)
    {
        $stok = StokModel::find($id);
        $barangs = BarangModel::all();
        $users  = UserModel::all();
        $suppliers = SupplierModel::all();
        return view('stok_ubah', ['data' => $stok, 'barang' => $barangs, 'user' => $users, 'supplier' => $suppliers]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $stok = StokModel::find($id);

        $stok->barang_id    = $request->barang_id;
        $stok->user_id      = $request->user_id;
        $stok->stok_tanggal = $request->stok_tanggal;
        $stok->stok_jumlah  = $request->stok_jumlah;

        $stok->save();

        return redirect('/stok');
    }

    public function hapus($id)
    {
        $stok = StokModel::find($id);
        $stok->delete();

        return redirect('/stok');
    }
}
