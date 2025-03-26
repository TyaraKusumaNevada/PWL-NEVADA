<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
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

//route usercontroller
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
    //js 6 prak 1
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
    //js 6 prak 2
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user dengan ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);   // menyimpan perubahan data user dengan ajax
    //js 6 prak 3
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax  
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax  
    Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});

//route level
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']); // Menampilkan daftar level
    Route::post('/list', [LevelController::class, 'list']); // Menampilkan data level dalam JSON untuk DataTables
    Route::get('/create', [LevelController::class, 'create']); // Menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']); // Menyimpan data level baru
    Route::get('/{id}', [LevelController::class, 'show']); // Menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']); // Menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']); // Menyimpan perubahan data level
    Route::delete('/{id}', [LevelController::class, 'destroy']); // Menghapus data level
});

//route kategori
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);// menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class, 'list']);// menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);// menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']); // menyimpan data kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);// menyimpan perubahan data kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']);// menghapus data kategori
});

//route stok 
Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']);// menampilkan halaman awal stok
    Route::post('/list', [StokController::class, 'list']);  // menampilkan data stok dalam bentuk json untuk datatables
    Route::get('/create', [StokController::class, 'create']); // menampilkan halaman form tambah stok
    Route::post('/', [StokController::class, 'store']); // menyimpan data stok baru
    Route::get('/{id}', [StokController::class, 'show']); // menampilkan detail stok
    Route::get('/{id}/edit', [StokController::class, 'edit']); // menampilkan halaman form edit stok
    Route::put('/{id}', [StokController::class, 'update']); // menyimpan perubahan data stok
    Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data stok
});

//route barang 
Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal barang
    Route::post('/list', [BarangController::class, 'list']); // menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah barang
    Route::post('/', [BarangController::class, 'store']); // menyimpan data barang baru
    Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class, 'update']);  // menyimpan perubahan data barang
    Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
});

//route supp
Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']); // Menampilkan halaman awal supplier
    Route::post('/list', [SupplierController::class, 'list']); // Menampilkan data supplier dalam bentuk JSON untuk datatables
    Route::get('/create', [SupplierController::class, 'create']);  // Menampilkan halaman form tambah supplier
    Route::post('/', [SupplierController::class, 'store']); // Menyimpan data supplier baru
    Route::get('/{id}', [SupplierController::class, 'show']); // Menampilkan detail supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']); // Menampilkan halaman form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']);// Menyimpan perubahan data supplier
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // Menghapus data supplier
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
