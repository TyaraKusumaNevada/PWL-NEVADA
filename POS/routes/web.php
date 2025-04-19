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

// Implementasi Auth
Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

// implementasi register
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postRegister']);
Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu
    // masukkan semua route yang perlu autentikasi di sini
    Route::get('/', [WelcomeController::class, 'index']);

    //route usercontroller
    Route::middleware(['authorize:ADM'])->group(function(){ // artinya semua route di dalam group ini harus punya role ADM (Administrator)
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
            // implementasi show_ajax
            Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
            Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
            Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
            Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
            Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
        });
    });

    //route level
    Route::middleware(['authorize:ADM'])->group(function(){
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [LevelController::class, 'index']); // Menampilkan daftar level
            Route::post('/list', [LevelController::class, 'list']); // Menampilkan data level dalam JSON untuk DataTables
            Route::get('/create', [LevelController::class, 'create']); // Menampilkan halaman form tambah level
            Route::post('/', [LevelController::class, 'store']); // Menyimpan data level baru
            //js 6 tugas 
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
            Route::post('/ajax', [LevelController::class, 'store_ajax']);
            //js 6 tugas
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
            //js 6 tugas
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
            // implementasi show ajax
            Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);

            Route::get('/{id}', [LevelController::class, 'show']); // Menampilkan detail level
            Route::get('/{id}/edit', [LevelController::class, 'edit']); // Menampilkan halaman form edit level
            Route::put('/{id}', [LevelController::class, 'update']); // Menyimpan perubahan data level
            Route::delete('/{id}', [LevelController::class, 'destroy']); // Menghapus data level
        });
    });

    //route kategori
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index']);// menampilkan halaman awal kategori
            Route::post('/list', [KategoriController::class, 'list']);// menampilkan data kategori dalam bentuk json untuk datatables
            Route::get('/create', [KategoriController::class, 'create']);// menampilkan halaman form tambah kategori
            Route::post('/', [KategoriController::class, 'store']); // menyimpan data kategori baru
            //js 6 tugas
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
            Route::post('/ajax', [KategoriController::class, 'store_ajax']);
            //js 6 tugas
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
            //js 6 tugas
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
            // implementasi show ajax
            Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);

            Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail kategori
            Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit kategori
            Route::put('/{id}', [KategoriController::class, 'update']);// menyimpan perubahan data kategori
            Route::delete('/{id}', [KategoriController::class, 'destroy']);// menghapus data kategori
        });
    });

    //route stok 
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::group(['prefix' => 'stok'], function () {
            Route::get('/', [StokController::class, 'index']);// menampilkan halaman awal stok
            Route::post('/list', [StokController::class, 'list']);  // menampilkan data stok dalam bentuk json untuk datatables
            Route::get('/create', [StokController::class, 'create']); // menampilkan halaman form tambah stok
            Route::post('/', [StokController::class, 'store']); // menyimpan data stok baru
            //js 6
            Route::get('/create_ajax', [StokController::class, 'create_ajax']);
            Route::post('/ajax', [StokController::class, 'store_ajax']);
            //js 6 
            Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
            //js 6 
            Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
            // implementasi show ajax
            Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);

            Route::get('/{id}', [StokController::class, 'show']); // menampilkan detail stok
            Route::get('/{id}/edit', [StokController::class, 'edit']); // menampilkan halaman form edit stok
            Route::put('/{id}', [StokController::class, 'update']); // menyimpan perubahan data stok
            Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data stok
        });
    });

    //route barang 
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){ 
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal barang
            Route::post('/list', [BarangController::class, 'list']); // menampilkan data barang dalam bentuk json untuk datatables
            Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah barang
            Route::post('/', [BarangController::class, 'store']); // menyimpan data barang baru
            //js 6 tugas
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
            Route::post('/ajax', [BarangController::class, 'store_ajax']);
            //js 6 tugas
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
            //js 6 tugas
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
            // implementasi show ajax
            Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);

            Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail barang
            Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit barang
            Route::put('/{id}', [BarangController::class, 'update']);  // menyimpan perubahan data barang
            Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
        });
    });

    //route supp
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', [SupplierController::class, 'index']); // Menampilkan halaman awal supplier
            Route::post('/list', [SupplierController::class, 'list']); // Menampilkan data supplier dalam bentuk JSON untuk datatables
            Route::get('/create', [SupplierController::class, 'create']);  // Menampilkan halaman form tambah supplier
            Route::post('/', [SupplierController::class, 'store']); // Menyimpan data supplier baru
            // js 6 tugas
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
            Route::post('/ajax', [SupplierController::class, 'store_ajax']);
            // js 6 tugas
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
            // js 6 tugas
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
            // implementasi show ajax
            Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);

            Route::get('/{id}', [SupplierController::class, 'show']); // Menampilkan detail supplier
            Route::get('/{id}/edit', [SupplierController::class, 'edit']); // Menampilkan halaman form edit supplier
            Route::put('/{id}', [SupplierController::class, 'update']);// Menyimpan perubahan data supplier
            Route::delete('/{id}', [SupplierController::class, 'destroy']); // Menghapus data supplier
        });  
    });

    // route penjualan
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::group(['prefix' => 'penjualan'], function () {
            Route::get('/', [PenjualanController::class, 'index']); // Halaman awal penjualan
            Route::post('/list', [PenjualanController::class, 'list']); // DataTables JSON
            Route::get('/create', [PenjualanController::class, 'create']); // Form tambah
            Route::post('/', [PenjualanController::class, 'store']); // Simpan baru
            // js 6 tugas
            Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);
            Route::post('/ajax', [PenjualanController::class, 'store_ajax']);
            // js 6 tugas
            Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
            // js 6 tugas
            Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
            // Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
            // implementasi show ajax
            Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);

            Route::get('/{id}', [PenjualanController::class, 'show']); // Detail
            Route::get('/{id}/edit', [PenjualanController::class, 'edit']); // Form edit
            Route::put('/{id}', [PenjualanController::class, 'update']); // Update data
            Route::delete('/{id}', [PenjualanController::class, 'destroy']); // Hapus data
        });
    });

});
    

