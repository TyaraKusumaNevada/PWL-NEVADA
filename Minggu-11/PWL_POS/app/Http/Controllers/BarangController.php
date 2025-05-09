<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;


// ===================Jobsheet 5 Praktikum 3==========

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

        //  Tambahan show_ajax

    public function show_ajax($id)
    {
        $barang = BarangModel::with('kategori')->find($id);
        return view('barang.show_ajax', compact('barang'));
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


    public function import()
    {
        return view('barang.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_barang'); // ambil file dari request

            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif

            $data = $sheet->toArray(null, false, true, true); // ambil data excel

            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'kategori_id' => $value['A'],
                            'barang_kode' => $value['B'],
                            'barang_nama' => $value['C'],
                            'harga_beli' => $value['D'],
                            'harga_jual' => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    BarangModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
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
        //Ambil value barang yang akan diexport
        $barang = BarangModel::select(
            'kategori_id',
            'barang_kode',
            'barang_nama',
            'harga_jual',
            'harga_beli'
        )
        ->orderBy('kategori_id')
        ->with('kategori')
        ->get();

        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); //ambil sheet aktif

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga Jual');
        $sheet->setCellValue('E1', 'Harga Beli');
        $sheet->setCellValue('F1', 'Kategori');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); // Set header bold

        $no = 1; //Nomor value dimulai dari 1
        $baris = 2; //Baris value dimulai dari 2
        foreach ($barang as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->barang_kode);
            $sheet->setCellValue('C' . $baris, $value->barang_nama);
            $sheet->setCellValue('D' . $baris, $value->harga_jual);
            $sheet->setCellValue('E' . $baris, $value->harga_beli);
            $sheet->setCellValue('F' . $baris, $value->kategori->kategori_nama); //ambil nama kategori
            $no++;
            $baris++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }

        $sheet->setTitle('Data Barang'); //set judul sheet
        $writer = IOFactory ::createWriter($spreadsheet, 'Xlsx'); //set writer
        $filename = 'Data_Barang_' . date('Y-m-d_H-i-s') . '.xlsx'; //set nama file

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output'); //simpan file ke output
        exit; 
    }

    public function export_pdf(){
        $barang = BarangModel::select(
            'kategori_id',
            'barang_kode',
            'barang_nama',
            'harga_jual',
            'harga_beli'
        )
        ->orderBy('kategori_id')
        ->orderBy('barang_kode')
        ->with('kategori')
        ->get();

        
        $pdf = PDF::loadView('barang.export_pdf', ['barang' => $barang]);
        $pdf->setPaper('A4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render(); // render pdf

        return $pdf->stream('Data Barang '.date('Y-m-d H-i-s').'.pdf');
    }

    

}





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

//         $barang = BarangModel::all();
//         return view('barang', ['data' => $barang]);


        

//     }

//     //===================Jobsheet 4 Praktikum 2.6=============
//     public function tambah()
//     {
//         $kategori = KategoriModel::all();
//         return view('barang_tambah', ['kategori' => $kategori]);
//     }

//     public function tambah_simpan(Request $request)
//     {
//         BarangModel::create([
//             'kategori_id' => $request->kategori_id,
//             'barang_kode' => $request->barang_kode,
//             'barang_nama' => $request->barang_nama,
//             'harga_beli'  => $request->harga_beli,
//             'harga_jual'  => $request->harga_jual,
//         ]);

//         return redirect('/barang');
//     }

//     public function ubah($id)
//     {
//         $barang = BarangModel::find($id);
//         $kategoris = KategoriModel::all();
//         return view('barang_ubah', ['data' => $barang, 'kategori' => $kategoris]);
//     }

//     public function ubah_simpan($id, Request $request)
//     {
//         $barang = BarangModel::find($id);

//         $barang->kategori_id = $request->kategori_id;
//         $barang->barang_kode = $request->barang_kode;
//         $barang->barang_nama = $request->barang_nama;
//         $barang->harga_beli  = $request->harga_beli;
//         $barang->harga_jual  = $request->harga_jual;

//         $barang->save();

//         return redirect('/barang');
//     }

//     public function hapus($id)
//     {
//         $barang = BarangModel::find($id);
//         $barang->delete();

//         return redirect('/barang');
//     }
        
// }
