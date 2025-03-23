<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\DB;
use DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) ['title' => 'Data Kategori', 'list' => ['Home', 'Kategori']];
        $page = (object) ['title' => 'Daftar Kategori'];
        $activeMenu = 'kategori';



        return view('kategori.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn  = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
                      . csrf_field()
                      . method_field('DELETE')
                      . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</button>'
                      . '</form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) ['title' => 'Tambah Kategori', 'list' => ['Home', 'Kategori', 'Tambah']];
        $page = (object) ['title' => 'Form Tambah Kategori'];
        $activeMenu = 'kategori';

        return view('kategori.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100',
        ]);

        KategoriModel::create($request->only(['kategori_kode', 'kategori_nama']));

        return redirect('/kategori')->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $kategori = KategoriModel::findOrFail($id);

        $breadcrumb = (object) ['title' => 'Detail Kategori', 'list' => ['Home', 'Kategori', 'Detail']];
        $page = (object) ['title' => 'Detail Data Kategori'];
        $activeMenu = 'kategori';

        return view('kategori.show', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function edit($id)
    {
        $kategori = KategoriModel::findOrFail($id);

        $breadcrumb = (object) ['title' => 'Edit Kategori', 'list' => ['Home', 'Kategori', 'Edit']];
        $page = (object) ['title' => 'Edit Data Kategori'];
        $activeMenu = 'kategori';

        return view('kategori.edit', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100',
        ]);

        KategoriModel::findOrFail($id)->update($request->only(['kategori_kode', 'kategori_nama']));

        return redirect('/kategori')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/kategori')->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
    
    
    
    // public function index()
    // {
    //     // $data = [
    //     //     'kategori_kode' => 'SNK',
    //     //     'kategori_nama' => 'Snack/Makanan Ringan',
    //     //     'created_at' => now()
    //     // ];

    //     // DB::table('m_kategori')->insert($data);
    //     // return 'Insert data baru berhasil';


    //     // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
    //     // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

    //     // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
    //     // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

    //     $data = DB::table('m_kategori')->get();
    //     return view('kategori', ['data' => $data]);

    // }
}
