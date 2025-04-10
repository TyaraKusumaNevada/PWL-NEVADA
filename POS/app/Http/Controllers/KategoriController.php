<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(){
        //===========Jobsheet 3 Praktikum 4=============
        // DB::insert('insert into m_kategori(kategori_kode, kategori_nama, created_at) values(?, ?, ?)', ['BPB', 'Barang Pecah Belah', now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_kategori set kategori_nama = ? where kategori_kode = ?', ['Pecah Belah', 'BPB']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from m_kategori where kategori_kode = ?', ['BPB']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::select('select * from m_kategori');
        // return view('kategori', ['data' => $data]);

        //============Jobsheet 3 Praktikum 5==============
        // $data = [
        //     'kategori_kode' => 'SND',
        //     'kategori_nama' => 'Sandal',
        //     'created_at' => now()
        // ];

        // DB::table('m_kategori')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SND')->update(['kategori_nama' => 'Sendal']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SND')->delete();
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::table('m_kategori')->get();
        // return view('kategori', ['data' => $data]);


        // ============Jobsheet 3 Praktikum 6====================
        // $data = [
        //     'kategori_kode' => 'SND',
        //     'kategori_nama' => 'Sandal',
        //     'created_at' => now()
        // ];

        // KategoriModel::insert($data);

        $data =[
            'kategori_nama' => 'Alas kaki'
        ];

        KategoriModel::where('kategori_kode', 'SND')->update($data);

        $kategori = KategoriModel::all();
        return view('kategori', ['data' => $kategori]);
    }
}