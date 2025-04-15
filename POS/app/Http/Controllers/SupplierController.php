<?php

namespace App\Http\Controllers;


use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Supplier',
            'list' => ['Home', 'Supplier']
        ];

        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar'
        ];

        $activeMenu = 'supplier';

        return view('supplier.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list()
    {
        $supplier = SupplierModel::all();

        return DataTables::of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($s) {
                return '<a href="' . url('/supplier/' . $s->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> '
                    . '<a href="' . url('/supplier/' . $s->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> '
                    . '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $s->supplier_id) . '">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus data ini?\');">Hapus</button>'
                    . '</form>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah data supplier baru'
        ];

        $activeMenu = 'supplier';

        return view('supplier.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_nama' => 'required|string|max:255',
            'supplier_alamat' => 'nullable|string',
            'supplier_telepon' => 'nullable|string|max:15',
        ]);

        SupplierModel::create($request->all());

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    public function show($id)
    {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail data supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.show', compact('breadcrumb', 'page', 'supplier', 'activeMenu'));
    }

    public function edit($id)
    {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list' => ['Home', 'Supplier', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit data supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.edit', compact('breadcrumb', 'page', 'supplier', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_nama' => 'required|string|max:255',
            'supplier_alamat' => 'nullable|string',
            'supplier_telepon' => 'nullable|string|max:15',
        ]);

        SupplierModel::find($id)->update($request->all());

        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }

    public function destroy($id)
    {
        $check = SupplierModel::find($id);

        if (!$check) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            SupplierModel::destroy($id);
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Gagal menghapus data supplier karena masih terhubung dengan data lain');
        }
    }
    
    // public function index(){

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

    //         $supplier = SupplierModel::all();
    //         return view('supplier', ['data' => $supplier]);
    //     }

    //     // ====Jobsheet 4 Praktikum 2.6=========

    //     public function tambah()
    //     {
    //         return view('supplier_tambah');
    //     }
        

    //     public function tambah_simpan(Request $request)
    //     {
    //         SupplierModel::create([
    //             'supplier_kode' => $request->supplier_kode,
    //             'supplier_nama' => $request->supplier_nama,
    //             'supplier_alamat' => $request->supplier_alamat,
    //         ]);

    //         return redirect('/supplier');
    //     }

    //     public function ubah($id)
    //     {
    //         $supplier = SupplierModel::find($id);
    //         return view('supplier_ubah', ['data' => $supplier]);
    //     }

    //     public function ubah_simpan($id, Request $request)
    //     {
    //         $supplier = SupplierModel::find($id);

    //         $supplier->supplier_kode   = $request->supplier_kode;
    //         $supplier->supplier_nama   = $request->supplier_nama;
    //         $supplier->supplier_alamat = $request->supplier_alamat;

    //         $supplier->save();

    //         return redirect('/supplier');
    //     }

    //     public function hapus($id)
    //     {
    //         $supplier = SupplierModel::find($id);
    //         $supplier->delete();

    //         return redirect('/supplier');
    //     }
}
