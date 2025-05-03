<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class PenjualanDetailController extends Controller
{


  public function create($penjualan_id)
  {
    $breadcrumb = (object) [
      'title' => 'Tambah Detail Penjualan',
      'list' => ['Home', 'Penjualan', 'Detail', 'Tambah']
    ];

    $page = (object) [
      'title' => 'Tambah detail penjualan'
    ];

    $activeMenu = 'penjualan';

    $penjualan = PenjualanModel::findOrFail($penjualan_id);
    $barang = BarangModel::all();

    return view('penjualandetail.create', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'barang'));
  }

  public function store(Request $request, $penjualan_id)
  {
    $request->validate([
      'barang_id' => 'required|integer',
      'jumlah' => 'required|integer|min:1',
      'harga' => 'required|numeric|min:0',
    ]);

    $request['penjualan_id'] = $penjualan_id;
    PenjualanDetailModel::create($request->all());

    return redirect("/penjualan/$penjualan_id")->with('success', 'Detail penjualan berhasil ditambahkan');
  }

  public function edit($penjualan_id, $id)
  {
    $detail = PenjualanDetailModel::findOrFail($id);
    $barang = BarangModel::all();
    $penjualan = PenjualanModel::findOrFail($penjualan_id);

    $breadcrumb = (object) [
      'title' => 'Edit Detail Penjualan',
      'list' => ['Home', 'Penjualan', 'Detail', 'Edit']
    ];

    $page = (object) [
      'title' => 'Edit detail penjualan'
    ];

    $activeMenu = 'penjualan';

    return view('penjualandetail.edit', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'barang', 'detail'));
  }

  public function update(Request $request, $penjualan_id, $id)
  {
    $request->validate([
      'barang_id' => 'required|integer',
      'jumlah' => 'required|integer|min:1',
      'harga' => 'required|numeric|min:0',
    ]);

    $detail = PenjualanDetailModel::findOrFail($id);
    $detail->update($request->all());

    return redirect("/penjualan/$penjualan_id")->with('success', 'Detail penjualan berhasil diubah');
  }

  public function destroy($penjualan_id, $id)
  {
    $check = PenjualanDetailModel::find($id);

    if (!$check) {
      return redirect("/penjualan/$penjualan_id")->with('error', 'Data detail penjualan tidak ditemukan');
    }

    try {
      PenjualanDetailModel::destroy($id);
      return redirect("/penjualan/$penjualan_id")->with('success', 'Detail penjualan berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
      return redirect("/penjualan/$penjualan_id")->with('error', 'Gagal menghapus detail karena masih terhubung dengan data lain');
    }
}
}
    // public function index(){
    //     DB::insert('insert into t_penjualan_detail(penjualan_id, barang_id, jumlah, harga, created_at) values(?, ?, ?, ?, ?)', [11, 11, 7, 180000, now()]);
    //     return 'Insert data baru berhasil';

    //     $row = DB::update('update t_penjualan_detail set jumlah = ? where detail_id = ?', [3, 12]);
    //     return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

    //     $row = DB::delete('delete from t_penjualan_detail where detail_id = ?', [12]);
    //     return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';
        
    //     $data = DB::select('select * from t_penjualan_detail');
    //     return view('penjualan_detail', ['data' => $data]);

    //    // =====Jobsheet 3 Praktikum 5=========================================================================================
    //     $data = [
    //         'penjualan_id' => '11',
    //         'barang_id' => '11',
    //         'jumlah' => '3',
    //         'harga' => '130000',
    //         'created_at' => now()
    //     ];

    //     DB::table('t_penjualan_detail')->insert($data);
    //     return 'Insert data baru berhasil';

    //     $row = DB::table('t_penjualan_detail')->where('detail_id', '12')->update(['jumlah' => '3']);
    //     return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

    //     $row = DB::table('t_penjualan_detail')->where('detail_id', '12')->delete();
    //     return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

    //     $data = DB::table('t_penjualan_detail')->get();
    //     return view('penjualan_detail', ['data' => $data]);


    //     ============Jobsheet 3 Praktikum 6=======
    //     $data = [
    //         'penjualan_id' => '11',
    //         'barang_id' => '11',
    //         'jumlah' => '2',
    //         'harga' => '120000',
    //         'created_at' => now()
    //     ];

    //     PenjualanDetailModel::insert($data);

        // $data =[
        //     'jumlah' => '10'
        // ];

        // PenjualanDetailModel::where('detail_id', '16')->update($data);

        // ========Jobsheet 4 Praktikum 1=========================
        // $data = [
        //     'penjualan_id' => '10',
        //     'barang_id' => '9',
        //     'jumlah' => '1',
        //     'harga' => '400000',
        // ];
        // PenjualanDetailModel::create($data);

//         $penjualanDetail = PenjualanDetailModel::all();
//         return view('penjualanDetail', ['data' => $penjualanDetail]);

//     }

//     public function tambah()
//     {
//         $penjualans = PenjualanModel::all();
//         $barangs = BarangModel::all();
//         return view('penjualanDetail_tambah', ['penjualans' => $penjualans, 'barangs' => $barangs]);
//     }

//     public function tambah_simpan(Request $request)
//     {
//         PenjualanDetailModel::create([
//             'penjualan_id' => $request->penjualan_id,
//             'barang_id' => $request->barang_id,
//             'jumlah' => $request->jumlah,
//             'harga' => $request->harga,
//         ]);

//         return redirect('/penjualan-detail');
//     }

//     public function ubah($id)
//     {
//         $detail = PenjualanDetailModel::find($id);
//         $penjualans = PenjualanModel::all();
//         $barangs = BarangModel::all();
//         return view('penjualanDetail_ubah', ['data' => $detail, 'penjualans' => $penjualans, 'barangs' => $barangs]);
//     }

//     public function ubah_simpan($id, Request $request)
//     {
//         $detail = PenjualanDetailModel::find($id);

//         $detail->penjualan_id = $request->penjualan_id;
//         $detail->barang_id = $request->barang_id;
//         $detail->jumlah = $request->jumlah;
//         $detail->harga = $request->harga;

//         $detail->save();

//         return redirect('/penjualan-detail');
//     }

//     public function hapus($id)
//     {
//         $detail = PenjualanDetailModel::find($id);
//         $detail->delete();

//         return redirect('/penjualan-detail');
//     }
