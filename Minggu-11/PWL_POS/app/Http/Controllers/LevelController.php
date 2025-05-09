<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use Barryvdh\DomPDF\Facade\Pdf;

class LevelController extends Controller
{
    // ================ implementasi js 5 prak 3 & 4 =============
    public function index()
    {

        $breadcrumb = (object) ['title' => 'Data Level', 'list' => ['Home', 'Level']];
        $page = (object) ['title' => 'Daftar Level'];
        $activeMenu = 'level';

        return view('level.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // Menampilkan halaman form tambah level AJAX
    public function create_ajax()
    {
        return view('level.create_ajax');
    }
 
     // Menyimpan data level AJAX
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            LevelModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan.',
            ]);
        }

        return redirect('/');
    }
 
    
 
    public function list()
    {
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($level)
        ->addIndexColumn()
        ->addColumn('aksi', function ($level) {
            // $btn  = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            // $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
            //       . csrf_field()
            //       . method_field('DELETE')
            //       . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</button>'
            //       . '</form>';
            // return $btn;
            // Menambahkan kolom aksi dengan tombol Detail, Edit, dan Hapus
            $btn  = '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
        
    }   

    // impementasi show ajax

    public function show_ajax($id)
    {
        $level = LevelModel::find($id);
        return view('level.show_ajax', compact('level'));
    }


    // Menampilkan halaman edit level (AJAX)
    public function edit_ajax(string $id)
    {
        $level = LevelModel::find($id);

        return view('level.edit_ajax', ['level' => $level]);
    }
    // Update data level melalui AJAX
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $level = LevelModel::find($id);
            if ($level) {
                $level->update($request->all());

                return response()->json([
                    'status' => true,
                    'message' => 'Data level berhasil diupdate.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.',
                ]);
            }
        }

        return redirect('/');
    }
    


    // Confirm hapus data level AJAX
    public function confirm_ajax(string $id)
    {
        $level = LevelModel::find($id);

        return view('level.confirm_ajax', ['level' => $level]);
    }

    // Hapus data level melalui AJAX
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);

            if ($level) {
                $level->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data level berhasil dihapus.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.',
                ]);
            }
        }

        return redirect('/');
    }

    // public function list()
    // {
    //     $level = LevelModel::select('level_id', 'level_kode', 'level_nama');

    //     return DataTables::of($level)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function ($level) {
    //             $btn  = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    //             $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
    //                   . csrf_field()
    //                   . method_field('DELETE')
    //                   . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</button>'
    //                   . '</form>';
    //             return $btn;
    //         })
    //         ->rawColumns(['aksi'])
    //         ->make(true);
    // }

    public function create()
    {
        $breadcrumb = (object) ['title' => 'Tambah Level', 'list' => ['Home', 'Level', 'Tambah']];
        $page = (object) ['title' => 'Form Tambah Level'];
        $activeMenu = 'level';

        return view('level.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) ['title' => 'Detail Level', 'list' => ['Home', 'Level', 'Detail']];
        $page = (object) ['title' => 'Detail Data Level'];
        $activeMenu = 'level';

        return view('level.show', compact('breadcrumb', 'page', 'activeMenu', 'level'));

    }

    public function edit($id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) ['title' => 'Edit Level', 'list' => ['Home', 'Level', 'Edit']];
        $page = (object) ['title' => 'Edit Data Level'];
        $activeMenu = 'level';

        return view('level.edit', compact('breadcrumb', 'page', 'activeMenu', 'level'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100',
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            LevelModel::destroy($id);
            return redirect('/level')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/level')->with('error', 'Data gagal dihapus: ' . $e->getMessage());
        }
    }

    public function import(){
        return view('level.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $rules = [
                // Validasi file harus xlsx, maksimal 1MB
                'file_level' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Ambil file dari request
            $file = $request->file('file_level');

            // Membuat reader untuk file excel dengan format Xlsx
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true); // Hanya membaca data saja

            // Load file excel
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif

            // Ambil data excel sebagai array
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];

            // Pastikan data memiliki lebih dari 1 baris (header + data)
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // Baris pertama header, jadi lewati
                        $insert[] = [
                            'level_kode' => $value['A'],
                            'level_nama' => $value['B'],
                            'created_at'  => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // Insert data ke database, jika data sudah ada, maka diabaikan
                    LevelModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }

        return redirect('/');
    }

    public function export_excel()
    {
        //Ambil value barang yang akan diexport
        $level = LevelModel::select(
            'level_kode',
            'level_nama'
        )
        ->orderBy('level_id')
        ->get();

        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); //ambil sheet aktif

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Level');
        $sheet->setCellValue('C1', 'Nama Level');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true); // Set header bold

        $no = 1; //Nomor value dimulai dari 1
        $baris = 2; //Baris value dimulai dari 2
        foreach ($level as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->level_kode);
            $sheet->setCellValue('C' . $baris, $value->level_nama);
            $no++;
            $baris++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }

        $sheet->setTitle('Data Level'); //set judul sheet
        $writer = IOFactory ::createWriter($spreadsheet, 'Xlsx'); //set writer
        $filename = 'Data_Level_' . date('Y-m-d_H-i-s') . '.xlsx'; //set nama file

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
        $level = LevelModel::select(
            'level_kode',
            'level_nama',
        )
        ->orderBy('level_id')
        ->orderBy('level_kode')
        ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = PDF::loadView('level.export_pdf', ['level' => $level]);
        $pdf->setPaper('A4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render(); // render pdf

        return $pdf->stream('Data Level '.date('Y-m-d H-i-s').'.pdf');
    }
}

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

    //     $level = LevelModel::all();
    //     return view('level', ['data' => $level]);

    // }

    // // ====Jobsheet 4 Praktikum 2.6============
    // public function tambah()
    // {
    //     return view('level_tambah');
    // }

    // public function tambah_simpan(Request $request)
    // {
    //     LevelModel::create([
    //         'level_kode' => $request->level_kode,
    //         'level_nama' => $request->level_nama,
    //     ]);

    //     return redirect('/level');
    // }

    // public function ubah($id)
    // {
    //     $level = LevelModel::find($id);
    //     return view('level_ubah', ['data' => $level]);
    // }

    // public function ubah_simpan($id, Request $request)
    // {
    //     $level = LevelModel::find($id);

    //     $level->level_kode = $request->level_kode;
    //     $level->level_nama = $request->level_nama;

    //     $level->save();

    //     return redirect('/level');
    // }

    // public function hapus($id)
    // {
    //     $level = LevelModel::find($id);
    //     $level->delete();

    //     return redirect('/level');
    // }

