<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        //==================Jobsheet 3 Praktikum 4===================
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]); //menambahkan data baru ke tabel m_level dengan parameter query
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']); // Melakukan update ke data yang memiliki level kode CUS dengan nilai baru yaitu Customer
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']); // Menghapus data yang memiliki level kode CUS
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::select('select * from m_level'); // Mengambilsemua data dari tabel m_level
        // return view('level', ['data' => $data]);

        
        //=============Jobsheet 3 Praktikum 5===============
        // $data = [
        //     'level_kode' => 'CUS',
        //     'level_nama' => 'Customer',
        //     'created_at' => now()
        // ];

        // DB::table('m_level')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_level')->where('level_kode', 'CUS')->update(['level_nama' => 'Pelangan']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::table('m_level')->where('level_kode', 'CUS')->delete();
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::table('m_level')->get();
        // return view('level', ['data' => $data]);


        // ===========Jobsheet 3 Praktikum 6===========================================================================================
        // $data = [
        //     'level_kode' => 'CUS',
        //     'level_nama' => 'Customer',
        //     'created_at' => now()
        // ];

        // LevelModel::insert($data);

        // $data =[
        //     'level_nama' => 'Pelanggan'
        // ];

        // LevelModel::where('level_kode', 'CUS')->update($data);

        // $level = LevelModel::all();
        // return view('level', ['data' => $level]);

        // $data = [
        //     'level_kode' => 'HRD',
        //     'level_nama' => 'Human Resource Development'
        // ];
        // LevelModel::create($data);

        $level = LevelModel::all();
        return view('level', ['data' => $level]);

    }

    // ====Jobsheet 4 Praktikum 2.6============
    public function tambah()
    {
        return view('level_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level');
    }

    public function ubah($id)
    {
        $level = LevelModel::find($id);
        return view('level_ubah', ['data' => $level]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $level = LevelModel::find($id);

        $level->level_kode = $request->level_kode;
        $level->level_nama = $request->level_nama;

        $level->save();

        return redirect('/level');
    }

    public function hapus($id)
    {
        $level = LevelModel::find($id);
        $level->delete();

        return redirect('/level');
    }

}