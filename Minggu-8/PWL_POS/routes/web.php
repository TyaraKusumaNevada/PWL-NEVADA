<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController; 
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



Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');
// implementasi register
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postRegister']);

Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu
    // masukkan semua route yang perlu autentikasi di sini
    Route::get('/', [WelcomeController::class, 'index']);

    Route::middleware(['authorize:ADM'])->group(function(){ // artinya semua route di dalam group ini harus punya role ADM (Administrator)
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [LevelController::class, 'index']);
            Route::post('/list', [LevelController::class, 'list']);
            Route::get('/create', [LevelController::class, 'create']);
            Route::post("/", [LevelController::class, 'store']);
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
            Route::post('/ajax', [LevelController::class, 'store_ajax']);
            Route::get('/{id}', [LevelController::class, 'show']);
            Route::get('/{id}/edit', [LevelController::class, 'edit']);
            Route::put("/{id}", [LevelController::class, 'update']);
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
            Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
            Route::delete('/{id}', [LevelController::class, 'destroy']);
            Route::get('/import', [LevelController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [LevelController::class, 'export_excel']); // ajax import excel
            Route::get('/export_pdf', [LevelController::class, 'export_pdf']); //import pdf
        });
    });


    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){ // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager) dan STF (Staff)
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index']);
            Route::post('/list', [BarangController::class, 'list']);
            Route::get('/create', [BarangController::class, 'create']);
            Route::post("/", [BarangController::class, 'store']);
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
            Route::post('/ajax', [BarangController::class, 'store_ajax']);
            Route::get('/{id}', [BarangController::class, 'show']);
            Route::get('/{id}/edit', [BarangController::class, 'edit']);
            Route::put("/{id}", [BarangController::class, 'update']);
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
            Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
            Route::delete('/{id}', [BarangController::class, 'destroy']);
            Route::get('/import', [BarangController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [BarangController::class, 'export_excel']); // ajax import excel
            Route::get('/export_pdf', [BarangController::class, 'export_pdf']); // ajax import pdf

        });
    });
    
    Route::middleware(['authorize:ADM'])->group(function(){ // artinya semua route di dalam group ini harus punya role ADM (Administrator)
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);             // menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list']);        // menampilkan data user dalam bentuk json untuk datatables
            Route::get('/create', [UserController::class, 'create']);    // menampilkan halaman form tambah user
            Route::post("/", [UserController::class, 'store']);          // menyimpan data user baru
            Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user ajax
            Route::post('/ajax', [UserController::class, 'store_ajax']); // menyimpan data user baru ajax
            Route::get('/{id}', [UserController::class, 'show']);        // menampilkan detail user
            Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
            Route::put("/{id}", [UserController::class, 'update']);       // menyimpan perubahan data user
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user Ajax
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
            Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']); // untuk menampilkan detail
            Route::delete('/{id}', [UserController::class, 'destroy']);  // menghapus data user
            Route::get('/import', [UserController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [UserController::class, 'export_excel']); // ajax import excel
            Route::get('/export_pdf', [UserController::class, 'export_pdf']);
        });
    });
    
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', [SupplierController::class, 'index']);
            Route::post('/list', [SupplierController::class, 'list']);
            Route::get('/create', [SupplierController::class, 'create']);
            Route::post("/", [SupplierController::class, 'store']);
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
            Route::post('/ajax', [SupplierController::class, 'store_ajax']);
            Route::get('/{id}', [SupplierController::class, 'show']);
            Route::get('/{id}/edit', [SupplierController::class, 'edit']);
            Route::put("/{id}", [SupplierController::class, 'update']);
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
            Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
            Route::delete('/{id}', [SupplierController::class, 'destroy']);
            Route::get('/import', [SupplierController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [SupplierController::class, 'export_excel']);
            Route::get('/export_pdf', [SupplierController::class, 'export_pdf']);
        });
    });

    Route::middleware(['authorize:ADM,MNG'])->group(function(){ // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index']);
            Route::post('/list', [KategoriController::class, 'list']);
            Route::get('/create', [KategoriController::class, 'create']);
            Route::post("/", [KategoriController::class, 'store']);
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
            Route::post('/ajax', [KategoriController::class, 'store_ajax']);
            Route::get('/{id}', [KategoriController::class, 'show']);
            Route::get('/{id}/edit', [KategoriController::class, 'edit']);
            Route::put("/{id}", [KategoriController::class, 'update']);
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
            Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
            Route::delete('/{id}', [KategoriController::class, 'destroy']);
            Route::get('/import', [KategoriController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [KategoriController::class, 'export_excel']);
            Route::get('/export_pdf', [KategoriController::class, 'export_pdf']);
        });
    });

    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){ // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager) dan STF (Staff)
        Route::group(['prefix' => 'stok'], function () {
            Route::get('/', [StokController::class, 'index']);
            Route::post('/list', [StokController::class, 'list']);
            Route::get('/create', [StokController::class, 'create']);
            Route::post("/", [StokController::class, 'store']);
            Route::get('/create_ajax', [StokController::class, 'create_ajax']);
            Route::post('/ajax', [StokController::class, 'store_ajax']);
            Route::get('/{id}', [StokController::class, 'show']);
            Route::get('/{id}/edit', [StokController::class, 'edit']);
            Route::put("/{id}", [StokController::class, 'update']);
            Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
            Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
            Route::delete('/{id}', [StokController::class, 'destroy']);
        });
    });

    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){ // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager) dan STF (Staff)
        Route::group(['prefix' => 'penjualan'], function () {
            Route::get('/', [PenjualanController::class, 'index']);
            Route::post('/list', [PenjualanController::class, 'list']);
            Route::get('/create', [PenjualanController::class, 'create']);
            Route::post("/", [PenjualanController::class, 'store']);
            Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);
            Route::post('/ajax', [PenjualanController::class, 'store_ajax']);
            Route::get('/{id}', [PenjualanController::class, 'show']);
            Route::get('/{id}/edit', [PenjualanController::class, 'edit']);
            Route::put("/{id}", [PenjualanController::class, 'update']);
            Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
            Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
            Route::delete('/{id}', [PenjualanController::class, 'destroy']);
        });
    });

    

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile_ajax', [ProfileController::class, 'editProfileAjax']);
    Route::post('profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');


    

    // Route::group(['prefix' => 'user'], function () {
    //     Route::get('/', [UserController::class, 'index']);             // menampilkan halaman awal user
    //     Route::post('/list', [UserController::class, 'list']);        // menampilkan data user dalam bentuk json untuk datatables
    //     Route::get('/create', [UserController::class, 'create']);    // menampilkan halaman form tambah user
    //     Route::post("/", [UserController::class, 'store']);          // menyimpan data user baru
    //     Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user ajax
    //     Route::post('/ajax', [UserController::class, 'store_ajax']); // menyimpan data user baru ajax
    //     Route::get('/{id}', [UserController::class, 'show']);        // menampilkan detail user
    //     Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
    //     Route::put("/{id}", [UserController::class, 'update']);       // menyimpan perubahan data user
    //     Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax
    //     Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user Ajax
    //     Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
    //     Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
    //     Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']); // untuk menampilkan detail
    //     Route::delete('/{id}', [UserController::class, 'destroy']);  // menghapus data user
    // });

    // Route::group(['prefix' => 'level'], function () {
    //     Route::get('/', [LevelController::class, 'index']);
    //     Route::post('/list', [LevelController::class, 'list']);
    //     Route::get('/create', [LevelController::class, 'create']);
    //     Route::post("/", [LevelController::class, 'store']);
    //     Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    //     Route::post('/ajax', [LevelController::class, 'store_ajax']);
    //     Route::get('/{id}', [LevelController::class, 'show']);
    //     Route::get('/{id}/edit', [LevelController::class, 'edit']);
    //     Route::put("/{id}", [LevelController::class, 'update']);
    //     Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    //     Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
    //     Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    //     Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    //     Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
    //     Route::delete('/{id}', [LevelController::class, 'destroy']);
    // });

    // Route::group(['prefix' => 'supplier'], function () {
    //     Route::get('/', [SupplierController::class, 'index']);
    //     Route::post('/list', [SupplierController::class, 'list']);
    //     Route::get('/create', [SupplierController::class, 'create']);
    //     Route::post("/", [SupplierController::class, 'store']);
    //     Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
    //     Route::post('/ajax', [SupplierController::class, 'store_ajax']);
    //     Route::get('/{id}', [SupplierController::class, 'show']);
    //     Route::get('/{id}/edit', [SupplierController::class, 'edit']);
    //     Route::put("/{id}", [SupplierController::class, 'update']);
    //     Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
    //     Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
    //     Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
    //     Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
    //     Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
    //     Route::delete('/{id}', [SupplierController::class, 'destroy']);
    // });

    // Route::group(['prefix' => 'kategori'], function () {
    //     Route::get('/', [KategoriController::class, 'index']);
    //     Route::post('/list', [KategoriController::class, 'list']);
    //     Route::get('/create', [KategoriController::class, 'create']);
    //     Route::post("/", [KategoriController::class, 'store']);
    //     Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    //     Route::post('/ajax', [KategoriController::class, 'store_ajax']);
    //     Route::get('/{id}', [KategoriController::class, 'show']);
    //     Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    //     Route::put("/{id}", [KategoriController::class, 'update']);
    //     Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
    //     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
    //     Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
    //     Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    //     Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
    //     Route::delete('/{id}', [KategoriController::class, 'destroy']);
    // });

    // Route::group(['prefix' => 'barang'], function () {
    //     Route::get('/', [BarangController::class, 'index']);
    //     Route::post('/list', [BarangController::class, 'list']);
    //     Route::get('/create', [BarangController::class, 'create']);
    //     Route::post("/", [BarangController::class, 'store']);
    //     Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
    //     Route::post('/ajax', [BarangController::class, 'store_ajax']);
    //     Route::get('/{id}', [BarangController::class, 'show']);
    //     Route::get('/{id}/edit', [BarangController::class, 'edit']);
    //     Route::put("/{id}", [BarangController::class, 'update']);
    //     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
    //     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
    //     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
    //     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
    //     Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
    //     Route::delete('/{id}', [BarangController::class, 'destroy']);
    // });
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




//Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
