<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(){
        // ===================Jobsheet 3 Praktikum 4==========
        // DB::insert('insert into m_barang(kategori_id, barang_kode, barang_nama, harga_beli, harga_jual, created_at) values(?, ?, ?, ?, ?, ?)', [1, 'MSK-008', 'Kalimba', 180000, 100000, now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_barang set harga_jual = ? where barang_kode = ?', [110000, 'MSK-002']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from m_barang where barang_kode = ?', ['MSK-008']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::select('select * from m_barang');
        // return view('barang', ['data' => $data]);

        // // =============Jobsheet 3 Praktikum 5==================
        // $data = [
        //     'kategori_id' => 1,
        //     'barang_kode' => 'MSK-007',
        //     'barang_nama' => 'Seruling',
        //     'harga_beli' => 100000,
        //     'harga_jual' => 150000,
        //     'created_at' => now()
        // ];
        // DB::table('m_barang')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_barang')->where('barang_kode', 'MSK-007')->update(['harga_jual' => '130000',]);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row =  DB::table('m_barang')->where('barang_kode', 'MSK-007')->delete();
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::table('m_barang')->get();
        // return view('barang', ['data' => $data]);

        // // ==========Jobsheet 3 Praktikum 6================
        // $data = [
        //     'kategori_id' => '1',
        //     'barang_kode' => 'SPT-008',
        //     'barang_nama' => 'Converse',
        //     'harga_beli' => '600000',
        //     'harga_jual' => '300000',
        //     'created_at' => now()
        // ];

        // BarangModel::insert($data);

        // $data =[
        //     'harga_jual' => '4000000'
        // ];

        // BarangModel::where('barang_kode', 'SPT-008')->update($data);

        // $barang = BarangModel::all();
        // return view('barang', ['data' => $barang]);

        // ========Jobsheet 4 Praktikum 1========

        // $data = [
        //     'kategori_id' => '2',
        //     'barang_kode' => 'OTM-006',
        //     'barang_nama' => 'Jok Beat Karbu',
        //     'harga_jual' => '300000',
        //     'harga_beli' => '200000',
        // ];
        // BarangModel::create($data);

        $barang = BarangModel::all();
        return view('barang', ['data' => $barang]);


        

    }

    //===================Jobsheet 4 Praktikum 2.6=============
    public function tambah()
    {
        $kategori = KategoriModel::all();
        return view('barang_tambah', ['kategori' => $kategori]);
    }

    public function tambah_simpan(Request $request)
    {
        BarangModel::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli'  => $request->harga_beli,
            'harga_jual'  => $request->harga_jual,
        ]);

        return redirect('/barang');
    }

    public function ubah($id)
    {
        $barang = BarangModel::find($id);
        $kategoris = KategoriModel::all();
        return view('barang_ubah', ['data' => $barang, 'kategori' => $kategoris]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $barang = BarangModel::find($id);

        $barang->kategori_id = $request->kategori_id;
        $barang->barang_kode = $request->barang_kode;
        $barang->barang_nama = $request->barang_nama;
        $barang->harga_beli  = $request->harga_beli;
        $barang->harga_jual  = $request->harga_jual;

        $barang->save();

        return redirect('/barang');
    }

    public function hapus($id)
    {
        $barang = BarangModel::find($id);
        $barang->delete();

        return redirect('/barang');
    }
        
}
