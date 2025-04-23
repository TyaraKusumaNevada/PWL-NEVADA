<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\UserModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;


class StokController extends Controller
{

    //    ============== Implementasi js 6==========================
    
    public function create_ajax()
    {
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'username')->get();
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get(); // Ambil data supplier

        return view('stok.create_ajax', [
            'barang' => $barang,
            'user' => $user,
            'supplier' => $supplier
        ]);
    }

    // Simpan data stok baru
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $rules = [
                'barang_id'    => ['required', 'integer', 'exists:m_barang,barang_id'],
                'user_id'      => ['required', 'integer', 'exists:m_user,user_id'],
                'supplier_id'  => ['required', 'integer', 'exists:m_supplier,supplier_id'], // validasi supplier
                'stok_tanggal' => ['required', 'date'],
                'stok_jumlah'  => ['required', 'integer', 'min:1'],
            ];


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            StokModel::create($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Data stok berhasil disimpan.',
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get(); // Ambil daftar supplier

        return view('stok.edit_ajax', [
            'stok' => $stok,
            'barang' => $barang,
            'user' => $user,
            'supplier' => $supplier,
        ]);
    }

    // Update data stok
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id'    => ['required', 'integer', 'exists:m_barang,barang_id'],
                'user_id'      => ['required', 'integer', 'exists:m_user,user_id'],
                'supplier_id'  => ['required', 'integer', 'exists:m_supplier,supplier_id'], // validasi supplier
                'stok_tanggal' => ['required', 'date'],
                'stok_jumlah'  => ['required', 'integer', 'min:1'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $stok = StokModel::find($id);
            if ($stok) {
                $stok->update($request->all());

                return response()->json([
                    'status'  => true,
                    'message' => 'Data stok berhasil diupdate.',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        return redirect('/');
    }

    // prak 3 
    public function confirm_ajax(string $id)
  {
    $stok = stokModel::find($id);

    return view('stok.confirm_ajax', compact('stok'));
  }

  // Hapus data stok via AJAX
  public function delete_ajax(Request $request, string $id)
  {
    if ($request->ajax() || $request->wantsJson()) {
      $stok = stokModel::find($id);
      if ($stok) {
        $stok->delete();

        return response()->json([
          'status' => true,
          'message' => 'Data stok berhasil dihapus'
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data stok tidak ditemukan'
        ]);
      }
    }

    return redirect('/');
  }


    
    //    ============== Implementasi js 5 prak 3 & 4==========================
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar data stok barang'
        ];

        $activeMenu = 'stok';

        $barang = BarangModel::all(); // untuk filter barang

        return view('stok.index', compact('breadcrumb', 'page', 'activeMenu', 'barang'));


    }

    public function list(Request $request)
    {
    $stok = StokModel::with(['barang', 'user', 'supplier']);
    if ($request->barang_id) {
      $stok->where('barang_id', $request->barang_id);
    }

    return DataTables::of($stok)
      ->addIndexColumn()
      ->addColumn('aksi', function ($stok) {
        $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
        $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
        $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

        return $btn;
      })
      ->rawColumns(['aksi'])
      ->make(true);
    }

    public function show_ajax($id)
    {
        $stok = StokModel::with(['barang', 'user', 'supplier'])->find($id);
        return view('stok.show_ajax', compact('stok'));
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah data stok baru'
        ];

        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all(); // Tambahkan supplier
        $activeMenu = 'stok';





        return view('stok.create', compact('breadcrumb', 'page', 'barang', 'user', 'supplier', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        StokModel::create($request->all());



        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }



    public function show($id)
    {
        $stok = StokModel::with(['barang', 'user', 'supplier'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail data stok'
        ];

        $activeMenu = 'stok';

        return view('stok.show', compact('breadcrumb', 'page', 'stok', 'activeMenu'));
    }




    public function edit($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all(); // Tambahkan supplier

        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit data stok'
        ];

        $activeMenu = 'stok';


        return view('stok.edit', compact('breadcrumb', 'page', 'stok', 'barang', 'user', 'supplier', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        StokModel::find($id)->update($request->all());




        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    public function destroy($id)
    {
        $check = StokModel::find($id);

        if (!$check) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            StokModel::destroy($id);
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/stok')->with('error', 'Gagal menghapus data stok karena data masih terhubung dengan tabel lain');
        }
    }

    public function import()
{
    return view('stok.import');
}

public function import_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $file = $request->file('file_stok');

        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();

        $data = $sheet->toArray(null, false, true, true);

        $insert = [];
        if (count($data) > 1) {
            foreach ($data as $baris => $value) {
                if ($baris > 1) {
                    $insert[] = [
                        'barang_id'     => $value['A'],
                        'user_id'       => $value['B'],
                        'supplier_id'   => $value['C'],
                        'stok_tanggal'  => $value['D'],
                        'stok_jumlah'   => $value['E'],
                        'created_at'    => now(),
                    ];
                }
            }

            if (count($insert) > 0) {
                StokModel::insert($insert);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil diimport'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
        }
    }

    return redirect('/');
}



public function export_excel()
{
    $stok = StokModel::with(['barang', 'user', 'supplier'])->get();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Tanggal');
    $sheet->setCellValue('C1', 'Nama Barang');
    $sheet->setCellValue('D1', 'Jumlah');
    $sheet->setCellValue('E1', 'User');
    $sheet->setCellValue('F1', 'Supplier');

    $sheet->getStyle('A1:F1')->getFont()->setBold(true);

    $no = 1;
    $baris = 2;
    foreach ($stok as $item) {
        $sheet->setCellValue('A' . $baris, $no++);
        $sheet->setCellValue('B' . $baris, $item->stok_tanggal);
        $sheet->setCellValue('C' . $baris, $item->barang->barang_nama ?? '-');
        $sheet->setCellValue('D' . $baris, $item->stok_jumlah);
        $sheet->setCellValue('E' . $baris, $item->user->nama ?? '-');
        $sheet->setCellValue('F' . $baris, $item->supplier->supplier_nama ?? '-');
        $baris++;
    }

    foreach (range('A', 'F') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $sheet->setTitle('Data Stok');
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data_Stok_' . date('Y-m-d_H-i-s') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}

public function export_pdf()
{
    $stok = StokModel::with(['barang', 'user', 'supplier'])->get();
    $pdf = Pdf::loadView('stok.export_pdf', compact('stok'));
    $pdf->setPaper('A4', 'landscape');
    $pdf->setOption("isRemoteEnabled", true);
    return $pdf->stream('Data_Stok_' . date('Y-m-d_H-i-s') . '.pdf');
}
    // public function index(){
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

    //     $stok = StokModel::all();
    //     return view('stok', ['data' => $stok]);
    // }

    // // ===Jobsheet 4 Praktikum 2.6==========
    // public function tambah()
    // {
    //     $barang = BarangModel::all();
    //     $user    = UserModel::all();
    //     $supplier = SupplierModel::all();

    //     return view('stok_tambah', ['barang' => $barang, 'user' => $user, 'supplier' => $supplier]);
    // }

    // public function tambah_simpan(Request $request)
    // {
    //     StokModel::create([
    //         'barang_id'    => $request->barang_id,
    //         'user_id'      => $request->user_id,
    //         'supplier_id'  => $request->supplier_id,
    //         'stok_tanggal' => $request->stok_tanggal,
    //         'stok_jumlah'  => $request->stok_jumlah,
    //     ]);

    //     return redirect('/stok');
    // }

    // public function ubah($id)
    // {
    //     $stok = StokModel::find($id);
    //     $barangs = BarangModel::all();
    //     $users  = UserModel::all();
    //     $suppliers = SupplierModel::all();
    //     return view('stok_ubah', ['data' => $stok, 'barang' => $barangs, 'user' => $users, 'supplier' => $suppliers]);
    // }

    // public function ubah_simpan($id, Request $request)
    // {
    //     $stok = StokModel::find($id);

    //     $stok->barang_id    = $request->barang_id;
    //     $stok->user_id      = $request->user_id;
    //     $stok->stok_tanggal = $request->stok_tanggal;
    //     $stok->stok_jumlah  = $request->stok_jumlah;

    //     $stok->save();

    //     return redirect('/stok');
    // }

    // public function hapus($id)
    // {
    //     $stok = StokModel::find($id);
    //     $stok->delete();

    //     return redirect('/stok');
    // }

}