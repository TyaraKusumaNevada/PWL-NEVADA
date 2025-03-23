<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

//Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);

// JOBSHEET 5 LANGKAH 5 PRAKTIKUM 2
Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
    Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});



// JOBSHEET 4
Route::get('/user', [UserController::class, 'index']);

//Praktikum 2.6 lankah 5
Route::get('/user/tambah', [UserController::class, 'tambah']); 

//Praktikum 2.6 langkah 8
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']); 

//Praktikum 2.6 langkah 12
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']); 

//Praktikum 2.6 langkah 15
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']); 

//Praktikum 2.6 langkah 18
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']); 
