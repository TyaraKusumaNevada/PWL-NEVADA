<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller {

    // jobsheet 5-baru praktikum 3 langkah 4
    // Menampilkan halaman awal user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        $level = LevelModel::all(); //ambil data level untuk filter level - modifikasi praktikum 4 langkah 1

        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);

        
    }
        //jobsheet 5-baru praktikum 3 langkah 7
        // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        //Filter data user berdasarkan level_id
        if ($request->level_id){
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/user/' . $user->user_id).'">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }


        // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list'  => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'level' => $level, 
            'activeMenu' => $activeMenu
        ]);
    }

    //Jobsheet 5-baru praktikum 3 langkah 11
    // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama'     => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'required|min:5', // password harus diisi dan minimal 5 karakter
            'level_id' => 'required|integer' // level_id harus diisi dan berupa angka
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => bcrypt($request->password), // password dienkripsi sebelum disimpan
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

        //jobsheeet 5-baru praktikum 3 langkah 14
        // Menampilkan detail user
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

        //jobsheeet 5-baru praktikum 3 langkah 18
        // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, 
            // dan bernilai unik di tabel user kecuali untuk user dengan id yang sedang diedit
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            // nama harus diisi, berupa string, dan maksimal 100 karakter
            'nama' => 'required|string|max:100',
            // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'password' => 'nullable|min:5',
            // level_id harus diisi dan berupa angka
            'level_id' => 'required|integer'
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    // Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {  // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id); // Hapus data level

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

}    

        // =======Jobsheet 3 Praktikum 4====================
        // DB::insert('insert into m_user(level_id, username, nama, password, created_at) values(?, ?, ?, ?, ?)', [3, 'staf1', 'staf pertama', Hash::make('123456'), now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_user set username = ? where username = ?', ['kasirSatu', 'kasir1']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::delete('delete from m_user where username = ?', ['kasirSatu']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // $data = DB::select('select * from m_user');
        // return view('user', ['data' => $data]);

        // ===============Jobsheet 3 Praktikum 5===========
        //     'level_id' => '4',
        //     'username' => 'kasirSatu',
        //     'nama' => 'Kasir1',
        //     'password' => Hash::make('123456'),
        //     'created_at' => now(),
        // ];

        // DB::table('m_user')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_user')->where('username', 'kasirSatu')->update(['nama' => 'KasirPertama']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // $row = DB::table('m_user')->where('username', 'kasirSatu')->delete();
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        // ====Jobsheet 3 Prak 6========
        // $data = [
        //     'username' => 'Kasir-1',
        //     'nama' => 'Kasir',
        //     'password' => Hash::make('12345'), // class untuk mengenkripsi/hash password
        //     'level_id' => 4
        // ];

        // UserModel::insert($data);

        // $data =[
        //     'nama' => 'Administrator'
        // ];

        // UserModel::where('username', 'admin')->update($data);

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        //========== Jobsheet 4 prak 1=========
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'Manager 2',
        //     'nama' => ' Budi Manager 2',
        //     'password' => Hash::make('123456')
        // ];
        // UserModel::insert($data);
        
        


        // public function user($id, $name) {
        //         return view('user', compact('id', 'name'));
        // }

         // $user = UserModel::where('level_id', 1)->first(); 
        // $user = UserModel::findOr(1, ['username', 'nama'], function() {
        //     abort(404);
        // }); 
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'admin3',
        //         'nama' => 'Rayhan Admin 3',
        //         'password' => Hash::make('admin3'),
        //         'level_id' => 1
        //     ],
        // );

        // $user->save();
        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);
        // return view('user', ['data' => $user]);
        //  $user->username = 'admin3';
         
        //  $user->isDirty(); //true
        //  $user->isDirty('username'); //true
        //  $user->isDirty('nama'); //false
        //  $user->isDirty(['nama', 'username']); //true
 
        //  $user->isClean(); //false
        //  $user->isClean('username'); //false
        //  $user->isClean('nama'); // true
        //  $user->isClean(['nama', 'username']); //false
 
        //  $user->save();

        //  $user->wasChanged(); // true
        //  $user->wasChanged('username'); // true
        //  $user->wasChanged(['username', 'level_id']); // true
        //  $user->wasChanged('nama'); // false
        //  dd($user->wasChanged(['nama', 'username']));
         
        //     $user = UserModel::all(); 
        //     return view('user', ['data' => $user]);
        
        // }

        // public function tambah(){
        //     $level = LevelModel::all();
        //     return view('user_tambah', ['level' => $level]);
        // }

        // public function tambah_simpan(Request $request) //Fungsi ini menerima request dari form yang dikirim oleh pengguna.
        // {
        //     UserModel::create([
        //         'username' => $request->username,
        //         'nama' => $request->nama,
        //         'password' => Hash::make($request->password),
        //         'level_id' => $request->level_id
        //     ]);

        //     return redirect('/user');
        // }

        // public function ubah($id){
        //     $levels = LevelModel::all();
        //     $user = UserModel::find($id);
        //     return view('user_ubah', ['data' => $user, 'level' => $levels]);
        // }

        // public function ubah_simpan($id, Request $request)
        // {
        //     $user = UserModel::find($id);

        //     $user->username = $request->username;
        //     $user->nama = $request->nama;
        //     $user->password = Hash::make($request->password);
        //     $user->level_id = $request->level_id;

        //     $user->save();

        //     return redirect('/user');
        // }

        // public function hapus($id)
        // {
        //     $user = UserModel::find($id);
        //     $user->delete();

        //     return redirect('/user');

    



