<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;


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

// Route::get('/user/{id}/name/{name}', [UserController::class, 'user']); // Halaman User
// Route::get('/penjualan', [PenjualanController::class, 'penjualan']);

// Route::get('/', [HomeController::class,'home'])->name('home'); // Halaman Home

// // Halaman Products
// Route::prefix('category')->group(function() {
//     Route::get('/food-beverage', [ProductsController::class, 'foodBeverage']);
//     Route::get('/beauty-health', [ProductsController::class, 'beautyHealth']);
//     Route::get('/home-care', [ProductsController::class, 'homeCare']);
//     Route::get('/baby-kid', [ProductsController::class, 'babyKid']);
// });

// Route::get('/products', function () {
//     return view('products');
// });


//===========Jobsheet 5==============================
Route::get('/', [WelcomeController::class, 'index']);

//route usercontroller
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

// route penjualan

Route::group(['prefix' => 'penjualan'], function () {
    Route::get('/', [PenjualanController::class, 'index']); // Halaman awal penjualan
    Route::post('/list', [PenjualanController::class, 'list']); // DataTables JSON
    Route::get('/create', [PenjualanController::class, 'create']); // Form tambah
    Route::post('/', [PenjualanController::class, 'store']); // Simpan baru
    Route::get('/{id}', [PenjualanController::class, 'show']); // Detail
    Route::get('/{id}/edit', [PenjualanController::class, 'edit']); // Form edit
    Route::put('/{id}', [PenjualanController::class, 'update']); // Update data
    Route::delete('/{id}', [PenjualanController::class, 'destroy']); // Hapus data
});
