<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function index(){
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
        $data = [
            'level_id' => 2,
            'username' => 'Manager 2',
            'nama' => ' Budi Manager 2',
            'password' => Hash::make('123456')
        ];
        UserModel::insert($data);
        
        $user = UserModel::all(); 
        return view('user', ['data' => $user]);


        // public function user($id, $name) {
        //         return view('user', compact('id', 'name'));
        // }
    }
}


