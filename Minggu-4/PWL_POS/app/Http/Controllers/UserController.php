<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // public function index()
    // {
    //     // coba akses model UserModel
    //     $user = UserModel::all(); // ambil semua data dari tabel m_user
    //     return view('user', ['data' => $user]);
    // }

    // public function index()
    // {
    //     // Tambah data user dengan Eloquent Model
    //     $data = [
    //         'username' => 'customer-1',
    //         'nama' => 'Pelanggan',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 3
    //     ];

    //     UserModel::insert($data); // Tambahkan data ke tabel m_user

    //     // Ambil semua data dari tabel m_user
    //     $user = UserModel::all();
    //     return view('user', ['data' => $user]);
    // }


    // public function index()
    // {
    //     // tambah data user dengan Eloquent Model
    //     $data = [
    //         'nama' => 'Pelanggan Pertama',
    //     ];
    //     UserModel::where('username', 'customer-1')->update($data); // update data user

    //     // coba akses model UserModel
    //     $user = UserModel::all(); // ambil semua data dari tabel m_user
    //     return view('user', ['data' => $user]);
    // }

    //--------------PRAKTIKUM 1 LANGKAH 1-------------

    // public function index(){

    //     $data = [
    //         'level_id' => 2,
    //         'username' => 'manager_dua',
    //         'nama' => 'Manager 2',
    //         'password' => Hash::make('12345')
    //     ];
        
    //     UserModel::create($data);

    //     $user = UserModel::all();
    //     return view('user', ['data' => $user]);
    // }

 
    //---------------PRAKTIKUM 1 LANGKAH 2-------------
    // public function index(){

    //     $data = [
    //         'level_id' => 2,
    //         'username' => 'manager_tiga',
    //         'nama' => 'Manager 3',
    //         'password' => Hash::make('12345')
    //     ];
        
    //     UserModel::create($data);
        
    //     $user = UserModel::all();
    //     return view('user', ['data' => $user]);
    // }
    

    public function index() {
    //--------------PRAKTIKUM 2.1 LANGKAH 1------------

    // $user = UserModel::find(1);
    // return view('user', ['data' => $user]);

    //-------------PRAKTIKUM 2.1 LANGKAH 4-------------

    // $user = UserModel::where('level_id', 1)->first();
    // return view('user', ['data' => $user]);
    
    //------------PRAKTIKUM 2.1 LANGKAH 6--------------

    // $user = UserModel::firstWhere('level_id', 1);
    // return view('user', ['data' => $user]);

    //------------PRAKTIKUM 2.1 LANGKAH 8--------------
    // $user = UserModel::findOr(1, ['username', 'nama'], function () {
    //     abort(404);
    // });
    // return view('user', ['data' => $user]);
    
    //------------PRAKTIKUM 2.1 LANGKAH 10-------------- 
    // $user = UserModel::findOr(20, ['username', 'nama'], function () {
    //     abort(404);
    // });

    // return view('user', ['data' => $user]);
    

    //------------PRAKTIKUM 2.2 LANGKAH 1-------------- 
    // $user = UserModel::findOrFail(1);
    // return view('user', ['data' => $user]);

    //------------PRAKTIKUM 2.2 LANGKAH 3--------------
    // $user = UserModel::where('username', 'manager9')->firstOrFail();
    // return view('user', ['data' => $user]);

    //------------PRAKTIKUM 2.3 LANGKAH 1 --------------

    // $user = UserModel::where('level_id', 2)->count();
    // dd($user);
    // return view('user', ['data' => $user]);
    
    //------------PRAKTIKUM 2.3 LANGKAH 3 --------------
    $user = UserModel::where('level_id', 2)->count();
    return view('user', ['data' => $user]);
    }
}
