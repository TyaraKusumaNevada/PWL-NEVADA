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
    public function index(){

        $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345')
        ];
        
        UserModel::create($data);
        
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }
    
}
