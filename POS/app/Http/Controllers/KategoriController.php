<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory; 

class KategoriController extends Controller
{
    // Tampilkan form input kategori AJAX
    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    // Simpan data kategori baru AJAX
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|unique:m_kategori,kategori_kode',
                'kategori_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            KategoriModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan.',
            ]);
        }

        return redirect('/');
    }

   
     // Form edit data kategori AJAX
     public function edit_ajax(string $id)
     {
         $kategori = KategoriModel::find($id);
 
         return view('kategori.edit_ajax', [
             'kategori' => $kategori
         ]);
     }
 
     // Update data kategori AJAX
     public function update_ajax(Request $request, $id)
     {
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'kategori_kode' => 'required|string|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
                 'kategori_nama' => 'required|string|max:100',
             ];
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false,
                     'message' => 'Validasi gagal.',
                     'msgField' => $validator->errors(),
                 ]);
             }
 
             $kategori = KategoriModel::find($id);
 
             if ($kategori) {
                 $kategori->update($request->all());
 
                 return response()->json([
                     'status' => true,
                     'message' => 'Data kategori berhasil diupdate.',
                 ]);
             }
 
             return response()->json([
                 'status' => false,
                 'message' => 'Data tidak ditemukan.',
             ]);
         }
 
         return redirect('/');
     }


    // Tampilkan konfirmasi hapus AJAX
    public function confirm_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);

        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    // Hapus data kategori AJAX
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::find($id);

            if ($kategori) {
                $kategori->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data kategori berhasil dihapus.',
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        return redirect('/');
    }

    public function list()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        return DataTables::of($kategori)
        ->addIndexColumn()
        ->addColumn('aksi', function ($kategori) {
            // $btn  = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            // $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
            //       . csrf_field()
            //       . method_field('DELETE')
            //       . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</button>'
            //       . '</form>';
            // return $btn;
            $btn  = '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    // implementasi show ajax
    public function show_ajax($id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.show_ajax', compact('kategori'));
    }

    public function index()
    {
        $breadcrumb = (object) ['title' => 'Data Kategori', 'list' => ['Home', 'Kategori']];
        $page = (object) ['title' => 'Daftar Kategori'];
        $activeMenu = 'kategori';



        return view('kategori.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // public function list()
    // {
    //     $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

    //     return DataTables::of($kategori)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function ($kategori) {
    //             $btn  = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    //             $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
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

    public function import(){
        return view('kategori.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {

            $rules = [
                // Validasi file harus xlsx, maksimal 1MB
                'file_kategori' => ['required', 'mimes:xlsx', 'max:1024']
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
            $file = $request->file('file_kategori');

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
                    if ($baris > 1) { // Baris pertama adalah header, jadi lewati
                        $insert[] = [
                            'kategori_kode' => $value['A'],
                            'kategori_nama' => $value['B'],
                            'created_at'  => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // Insert data ke database, jika data sudah ada, maka diabaikan
                    KategoriModel::insertOrIgnore($insert);
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
        //Ambil value kategori yang akan diexport
        $kategori = KategoriModel::select(
            'kategori_kode',
            'kategori_nama',
        )
        ->orderBy('kategori_id')
        ->get();

        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); //ambil sheet aktif

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Kategori');
        $sheet->setCellValue('C1', 'Nama Kategori');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true); // Set header bold

        $no = 1; //Nomor value dimulai dari 1
        $baris = 2; //Baris value dimulai dari 2
        foreach ($kategori as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->kategori_kode);
            $sheet->setCellValue('C' . $baris, $value->kategori_nama);
            $no++;
            $baris++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set auto size untuk kolom
        }

        $sheet->setTitle('Data kategori'); //set judul sheet
        $writer = IOFactory ::createWriter($spreadsheet, 'Xlsx'); //set writer
        $filename = 'Data_kategori_' . date('Y-m-d_H-i-s') . '.xlsx'; //set nama file

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

        // $data =[
        //     'kategori_nama' => 'Alas kaki'
        // ];

        // KategoriModel::where('kategori_kode', 'SND')->update($data);

        // $kategori = KategoriModel::all();
        // return view('kategori', ['data' => $kategori]);

        // ========Jobsheet 4 Praktikum 1=========================

        // $data = [
        //     'kategori_kode' => 'MNM',
        //     'kategori_nama' => 'Minuman',
        // ];
        // KategoriModel::create($data);

    //     $kategori = KategoriModel::all();        
    //     return view('kategori', ['data' => $kategori]);
    // }

    // //=====================Jobsheet 4 Praktikum 2.6======
    // public function tambah()
    // {
    //     return view('kategori_tambah');
    // }

    // public function tambah_simpan(Request $request)
    // {
    //     KategoriModel::create([
    //         'kategori_kode' => $request->kategori_kode,
    //         'kategori_nama' => $request->kategori_nama,
    //     ]);

    //     return redirect('/kategori');
    // }

    // public function ubah($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     return view('kategori_ubah', ['data' => $kategori]);
    // }

    // public function ubah_simpan($id, Request $request)
    // {
    //     $kategori = KategoriModel::find($id);

    //     $kategori->kategori_kode = $request->kategori_kode;
    //     $kategori->kategori_nama = $request->kategori_nama;

    //     $kategori->save();

    //     return redirect('/kategori');
    // }

    // public function hapus($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     $kategori->delete();

    //     return redirect('/kategori');
  
}