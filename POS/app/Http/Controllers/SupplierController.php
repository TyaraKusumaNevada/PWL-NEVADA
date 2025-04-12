<?php

namespace App\Http\Controllers;


use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index(){

        // =======Jobsheet 3 Praktikum 4====================
        
        // DB::insert('insert into m_supplier(supplier_kode, supplier_nama, supplier_alamat, created_at) values(?, ?, ?, ?)', ['SUP04', 'PT Makmur Jaya', 'JL budi utomo', now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_supplier set supplier_nama = ? where supplier_kode = ?', ['PT Makmur Sejati', 'SUP02']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from m_supplier where supplier_kode = ?', ['SUP03']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::select('select * from m_supplier');
        // return view('supplier', ['data' => $data]);

        // =========Jobsheet 3 Praktikum 6===========================================================================================
        // $data = [
        //     'supplier_kode' => 'SUP005',
        //     'supplier_nama' => 'PT Budi',
        //     'supplier_alamat' => 'JL Agus Dibroho',
        //     'created_at' => now()
        // ];

        // SupplierModel::insert($data);

        // $data =[
        //     'supplier_nama' => 'PT Klampok Tekstil',
        // ];

        // SupplierModel::where('supplier_kode', 'SUP04')->update($data);

        // $supplier = SupplierModel::all();
        // return view('supplier', ['data' => $supplier]);


        // ========Jobsheet 4 Praktikum 1=========================
        // $data = [
        //     'supplier_kode' => 'SUP04',
        //     'supplier_nama' => 'PT Sumber Abadi',
        //     'supplier_alamat' => 'JL Bandung No. 5',
        // ];
        // SupplierModel::create($data);

        $supplier = SupplierModel::all();
        return view('supplier', ['data' => $supplier]);
    }

    // ====Jobsheet 4 Praktikum 2.6=========

    public function tambah()
    {
        return view('supplier_tambah');
    }
    

    public function tambah_simpan(Request $request)
    {
        SupplierModel::create([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/supplier');
    }

    public function ubah($id)
    {
        $supplier = SupplierModel::find($id);
        return view('supplier_ubah', ['data' => $supplier]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $supplier = SupplierModel::find($id);

        $supplier->supplier_kode   = $request->supplier_kode;
        $supplier->supplier_nama   = $request->supplier_nama;
        $supplier->supplier_alamat = $request->supplier_alamat;

        $supplier->save();

        return redirect('/supplier');
    }

    public function hapus($id)
    {
        $supplier = SupplierModel::find($id);
        $supplier->delete();

        return redirect('/supplier');
    }
}
