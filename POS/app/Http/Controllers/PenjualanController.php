<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use App\Models\BarangModel;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\StokModel;
use DataTables;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{

    public function create_ajax()
    {
        $user   = UserModel::select('user_id', 'username')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();

        return view('penjualan.create_ajax', compact('user', 'barang'));
    }

    // Simpan data penjualan beserta detail
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input header + array detail
            $rules = [
                'user_id'               => 'required|integer|exists:m_user,user_id',
                'pembeli'               => 'required|string|min:3',
                'penjualan_tanggal'     => 'required|date',
                'barang_id.*'           => 'required|integer|exists:m_barang,barang_id',
                'harga.*'               => 'required|numeric|min:1',
                'jumlah.*'              => 'required|integer|min:1',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            // Transaksi DB: simpan header + detail
            DB::transaction(function() use ($request, &$penjualan) {
                // Generate kode (misal timestamp + random)
                $kode = 'PJ' . now()->format('YmdHis');

                $penjualan = PenjualanModel::create([
                    'user_id'            => $request->user_id,
                    'pembeli'            => $request->pembeli,
                    'penjualan_kode'     => $kode,
                    'penjualan_tanggal'  => $request->penjualan_tanggal,
                ]);

                // Simpan detail
                foreach ($request->barang_id as $i => $barangId) {
                    PenjualanDetailModel::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id'    => $barangId,
                        'harga'        => $request->harga[$i],
                        'jumlah'       => $request->jumlah[$i],
                    ]);
                }
            });

            return response()->json([
                'status'  => true,
                'message' => 'Penjualan berhasil disimpan.',
            ]);
        }

        return redirect()->back();
    }

    // Tampilkan form edit (modal AJAX)
    public function edit_ajax(string $id)
    {
        $penjualan = PenjualanModel::with('penjualanDetail')->findOrFail($id);
        $user      = UserModel::select('user_id', 'username')->get();
        $barang    = BarangModel::select('barang_id', 'barang_nama')->get();

        return view('penjualan.edit_ajax', compact('penjualan', 'user', 'barang'));
    }

    // Update header + detail
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id'               => 'required|integer|exists:m_user,user_id',
                'pembeli'               => 'required|string|min:3',
                'penjualan_tanggal'     => 'required|date',
                'barang_id.*'           => 'required|integer|exists:m_barang,barang_id',
                'harga.*'               => 'required|numeric|min:1',
                'jumlah.*'              => 'required|integer|min:1',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $penjualan = PenjualanModel::find($id);
            if (! $penjualan) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data penjualan tidak ditemukan.',
                ]);
            }

            DB::transaction(function() use ($request, $penjualan) {
                // Update header
                $penjualan->update([
                    'user_id'           => $request->user_id,
                    'pembeli'           => $request->pembeli,
                    'penjualan_tanggal' => $request->penjualan_tanggal,
                ]);

                // Hapus detail lama
                PenjualanDetailModel::where('penjualan_id', $penjualan->penjualan_id)->delete();

                // Simpan detail baru
                foreach ($request->barang_id as $i => $barangId) {
                    PenjualanDetailModel::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id'    => $barangId,
                        'harga'        => $request->harga[$i],
                        'jumlah'       => $request->jumlah[$i],
                    ]);
                }
            });

            return response()->json([
                'status'  => true,
                'message' => 'Penjualan berhasil diupdate.',
            ]);
        }

        return redirect()->back();
    }

    // Tampilkan modal konfirmasi hapus
    public function confirm_ajax(string $id)
    {
        $penjualan = PenjualanModel::with('penjualanDetail')->findOrFail($id);
        return view('penjualan.confirm_ajax', compact('penjualan'));
    }

    // Hapus header + detail
    public function delete_ajax(string $id)
    {
        if (request()->ajax() || request()->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if (! $penjualan) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan.',
                ]);
            }

            DB::transaction(function() use ($penjualan) {
                // Hapus detail dulu
                PenjualanDetailModel::where('penjualan_id', $penjualan->penjualan_id)->delete();
                // Hapus header
                $penjualan->delete();
            });

            return response()->json([
                'status'  => true,
                'message' => 'Penjualan berhasil dihapus.',
            ]);
        }

        return redirect()->back();
    }

    // Menampilkan halaman daftar transaksi penjualan
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list'  => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar Transaksi Penjualan'
        ];

        $activeMenu = 'penjualan';

        
        $user    = UserModel::select('user_id','username')->get();
        $barang = BarangModel::all();

        
        return view('penjualan.index', compact(
            'breadcrumb', 'page', 'activeMenu', 'user', 'barang'
        ));
    }

    // Mengambil data penjualan dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        // Mengambil data dengan relasi user (misalnya untuk menampilkan nama pengguna)
        $penjualan = PenjualanModel::with('user');

        // Jika ingin menambahkan filter (misalnya berdasarkan user_id), bisa disesuaikan
        if ($request->user_id) {
            $penjualan->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn  = '<a href="' . url('penjualan/' . $row->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('penjualan/' . $row->penjualan_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('penjualan/' . $row->penjualan_id) . '">';
                $btn .= csrf_field() . method_field('DELETE');
                $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman form tambah transaksi penjualan
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Penjualan',
            'list'  => ['Home', 'Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Transaksi Penjualan'
        ];

        $activeMenu = 'penjualan';

        // Ambil data user dan barang untuk dipilih melalui dropdown
        $users   = UserModel::all();       // Pastikan UserModel memiliki field user_id dan username
        $barang  = BarangModel::all();      // Pastikan BarangModel memiliki field barang_id, nama_barang, dan harga_jual

        return view('penjualan.create', compact('breadcrumb', 'page', 'activeMenu', 'users', 'barang'));
    }

    // Method store (tetap sama, misalnya seperti contoh sebelumnya)
    public function store(Request $request)
    {
        // Validasi header penjualan dan data detail penjualan
        $request->validate([
            'user_id'            => 'required|integer',
            'pembeli'            => 'required|string',
            'penjualan_kode'     => 'required|string|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal'  => 'required|date',
            // Validasi array untuk setiap detail penjualan
            'barang_id.*'        => 'required|integer',
            'jumlah.*'           => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Simpan data header penjualan
            $penjualan = PenjualanModel::create([
                'user_id'           => $request->user_id,
                'pembeli'           => $request->pembeli,
                'penjualan_kode'    => $request->penjualan_kode,
                'penjualan_tanggal' => $request->penjualan_tanggal,
            ]);

            // Simpan data detail penjualan dan update stok per item
            if ($request->has('barang_id')) {
                foreach ($request->barang_id as $key => $barang_id) {
                    // Karena harga akan dihitung otomatis di sisi client, kita ambil nilai yang dikirim di input harga
                    // atau bisa juga dilakukan perhitungan ulang berdasarkan data harga_jual dari database.
                    // Di sini diasumsikan nilai harga sudah terhitung dan terkirim
                    $harga  = $request->harga[$key];
                    $jumlah = $request->jumlah[$key];

                    // Simpan detail penjualan
                    PenjualanDetailModel::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id'    => $barang_id,
                        'harga'        => $harga,
                        'jumlah'       => $jumlah,
                    ]);

                    // Update stok barang
                    $stok = StokModel::where('barang_id', $barang_id)->first();

                    if ($stok) {
                        $stok->stok_jumlah = $stok->stok_jumlah - $jumlah;
                        $stok->save();
                    } else {
                        // Bila stok belum ada, buat record baru dengan nilai negatif
                        StokModel::create([
                            'barang_id'    => $barang_id,
                            'user_id'      => $request->user_id,
                            'stok_tanggal' => $request->penjualan_tanggal,
                            'stok_jumlah'  => -$jumlah,
                            'supplier_id'  => null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('penjualan.index')
                ->with('success', 'Transaksi penjualan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan transaksi penjualan: ' . $e->getMessage());
        }
    }

    // Menampilkan halaman detail transaksi penjualan lengkap dengan data detailnya
    public function show($id)
    {
        // Ambil data penjualan beserta relasi detail dan data barang di setiap detail
        $penjualan = PenjualanModel::with(['user', 'penjualanDetail.barang'])->find($id);

        if (!$penjualan) {
            return redirect()->route('penjualan.index')
                ->with('error', 'Data penjualan tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list'  => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Transaksi Penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.show', [
            'penjualan'   => $penjualan,
            'breadcrumb'  => $breadcrumb,
            'page'        => $page,
            'activeMenu'  => $activeMenu,
        ]);
    }

    



    // Menampilkan form edit penjualan
    public function edit($id)
    {
        $penjualan = PenjualanModel::find($id);
        if (!$penjualan) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Penjualan',
            'list'  => ['Home', 'Penjualan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit data penjualan'
        ];

        $users = UserModel::all();
        $activeMenu = 'penjualan';

        return view('penjualan.edit', compact('breadcrumb', 'page', 'penjualan', 'users', 'activeMenu'));
    }

    // Menyimpan perubahan penjualan
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'            => 'required|integer',
            'pembeli'            => 'required|string|max:100',
            'penjualan_kode'     => 'required|string|max:20|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
            'penjualan_tanggal'  => 'required|date',
        ]);

        $penjualan = PenjualanModel::find($id);
        if (!$penjualan) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        $penjualan->update($request->all());

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil diubah');
    }

    // Menghapus penjualan
    public function destroy($id)
    {
        $check = PenjualanModel::find($id);
        if (!$check) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        try {
            PenjualanModel::destroy($id);
            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terkait dengan data lain');
        }
    }
}




    // public function index(){
        // ======Jobsheet 3 Praktikum 4========
        // DB::insert('insert into t_penjualan(user_id, pembeli, penjualan_kode, penjualan_tanggal, created_at) values(?, ?, ?, ?, ?)', [3, 'Ayu Widodo', 'TR011', now(), now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update t_penjualan set pembeli = ? where penjualan_kode = ?', ['Ayu Widodo', 'TR011']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from t_penjualan where penjualan_kode = ?', ['TR011']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::select('select * from t_penjualan');
        // return view('penjualan', ['data' => $data]);

        // // =================Jobsheet 3 Praktikum 5==========
        // $data = [
        //     'user_id' => '1',
        //     'pembeli' => 'Ayu Widodo',
        //     'penjualan_kode' => 'TR011',
        //     'penjualan_tanggal' => now(),
        //     'created_at' => now()
        // ];

        // DB::table('t_penjualan')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('t_penjualan')->where('penjualan_kode', 'TR11')->update(['pembeli' => 'Ayu Widodo']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::table('t_penjualan')->where('penjualan_kode', 'TR011')->delete();
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        
        // // ============Jobsheet 3 Praktikum 6=======
        // $data = [
        //     'user_id' => '3',
        //     'pembeli' => 'Ayu Widodo',
        //     'penjualan_kode' => 'TR011',
        //     'penjualan_tanggal' => now(),
        //     'created_at' => now()
        // ];

        // PenjualanModel::insert($data);

        // $data =[
        //     'pembeli' => 'Ayu Wiro',
        // ];

        // PenjualanModel::where('penjualan_kode', 'TR011')->update($data);

        // $penjualan = PenjualanModel::all();
        // return view('penjualan', ['data' => $penjualan]);

        
        // ========Jobsheet 4 Praktikum 1=========================

        // $data = [
        //     'user_id' => '2',
        //     'pembeli' => 'Setia Budi',
        //     'penjualan_kode' => 'TR012',
        //     'penjualan_tanggal' => now(),
        // ];
        // PenjualanModel::create($data);

    //     $penjualan = PenjualanModel::all();
    //     return view('penjualan', ['data' => $penjualan]);
    // }


    // //==================Jobsheet 4 Praktikum 2.6=========
    // public function tambah()
    // {
    //     $users = UserModel::all();
    //     return view('penjualan_tambah', ['users' => $users]);
    // }

    // public function tambah_simpan(Request $request)
    // {
    //     PenjualanModel::create([
    //         'user_id' => $request->user_id,
    //         'pembeli' => $request->pembeli,
    //         'penjualan_kode' => $request->penjualan_kode,
    //         'penjualan_tanggal' => $request->penjualan_tanggal,
    //     ]);

    //     return redirect('/penjualan');
    // }

    // public function ubah($id)
    // {
    //     $penjualan = PenjualanModel::find($id);
    //     $users = UserModel::all();
    //     return view('penjualan_ubah', ['data' => $penjualan, 'users' => $users]);
    // }

    // public function ubah_simpan($id, Request $request)
    // {
    //     $penjualan = PenjualanModel::find($id);

    //     $penjualan->user_id = $request->user_id;
    //     $penjualan->pembeli = $request->pembeli;
    //     $penjualan->penjualan_kode = $request->penjualan_kode;
    //     $penjualan->penjualan_tanggal = $request->penjualan_tanggal;

    //     $penjualan->save();

    //     return redirect('/penjualan');
    // }

    // public function hapus($id)
    // {
    //     $penjualan = PenjualanModel::find($id);
    //     $penjualan->delete();

    //     return redirect('/penjualan');
    // }

    // // public function penjualan() {
    // //     return view('penjualan');
    // // }

