<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{

    // Tampilkan form input barang AJAX
    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.create_ajax', ['kategori' => $kategori]);
    }

    // Simpan data barang baru AJAX
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'  => 'required|integer|exists:m_kategori,kategori_id',
                'barang_kode'  => 'required|string|unique:m_barang,barang_kode',
                'barang_nama'  => 'required|string|max:100',
                'harga_beli'   => 'required|numeric|min:0',
                'harga_jual'   => 'required|numeric|min:0',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            BarangModel::create($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Data barang berhasil disimpan.',
            ]);
        }

        return redirect('/');
    }

    // TAmpilkan Form edit data barang AJAX
    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.edit_ajax', [
            'barang'   => $barang,
            'kategori' => $kategori,
        ]);
    }

    // Update data barang
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'  => 'required|integer|exists:m_kategori,kategori_id',
                'barang_kode'  => 'required|string|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama'  => 'required|string|max:100',
                'harga_beli'   => 'required|numeric|min:0',
                'harga_jual'   => 'required|numeric|min:0',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->update($request->all());

                return response()->json([
                    'status'  => true,
                    'message' => 'Data barang berhasil diupdate.',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        return redirect('/');
    }

    // Konfirmasi hapus
    public function confirm_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    // Hapus data barang
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();

                return response()->json([
                    'status'  => true,
                    'message' => 'Data barang berhasil dihapus.',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        return redirect('/');
    }

    public function index()
    {
        $breadcrumb = (object) ['title' => 'Data Barang', 'list' => ['Home', 'Barang']];
        $page = (object) ['title' => 'Daftar Barang'];
        $activeMenu = 'barang';

        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    //Ambil data barang 
    public function list()
    {
        $barang = BarangModel::with('kategori')->select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual');
    
        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('kategori_nama', function ($barang) {
                return $barang->kategori->kategori_nama ?? '-';
            })
            ->addColumn('aksi', function ($barang) {
                // $btn  = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">'
                //       . csrf_field()
                //       . method_field('DELETE')
                //       . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</button>'
                //       . '</form>';
                // return $btn;
                $btn  = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                    return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    

    //tampilkan form tambah barang 
    public function create()
    {
        $breadcrumb = (object) ['title' => 'Tambah Barang', 'list' => ['Home', 'Barang', 'Tambah']];
        $page = (object) ['title' => 'Form Tambah Barang'];
        $activeMenu = 'barang';
        $kategori = KategoriModel::all();

        return view('barang.create', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    //save data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'  => 'required|exists:m_kategori,kategori_id',
            'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama'  => 'required|string|max:100',
            'harga_beli'   => 'required|integer|min:0',
            'harga_jual'   => 'required|integer|min:0',
        ]);

        BarangModel::create($request->only(['kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual']));

        return redirect('/barang')->with('success', 'Data berhasil disimpan');
    }

    //tampilkan detail barang
    public function show($id)
    {
        $barang = BarangModel::with('kategori')->findOrFail($id);

        $breadcrumb = (object) ['title' => 'Detail Barang', 'list' => ['Home', 'Barang', 'Detail']];
        $page = (object) ['title' => 'Detail Data Barang'];
        $activeMenu = 'barang';

        return view('barang.show', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
    }

    public function edit($id)
    {
        $barang = BarangModel::findOrFail($id);
        $breadcrumb = (object) ['title' => 'Edit Barang', 'list' => ['Home', 'Barang', 'Edit']];
        $page = (object) ['title' => 'Edit Data Barang'];
        $activeMenu = 'barang';
        $kategori = KategoriModel::all();

        return view('barang.edit', compact('breadcrumb', 'page', 'activeMenu', 'barang', 'kategori'));
    }

    //save edit
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id'  => 'required|exists:m_kategori,kategori_id',
            'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama'  => 'required|string|max:100',
            'harga_beli'   => 'required|integer|min:0',
            'harga_jual'   => 'required|integer|min:0',
        ]);

        BarangModel::findOrFail($id)->update($request->only(['kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual']));

        return redirect('/barang')->with('success', 'Data berhasil diubah');
    }

    //delete
    public function destroy($id)
    {
        try {
            BarangModel::destroy($id);
            return redirect('/barang')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/barang')->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
