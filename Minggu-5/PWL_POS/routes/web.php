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

//Praktikum 2 Jobsheet 5 langkah 12

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');


// Praktikum 3 Jobsheet 5 langkah 1
Route::get('/kategori/create', [KategoriController::class, 'create']);
Route::post('/kategori', [KategoriController::class, 'store']);

//Jobsheet 5 Tugas 
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{id}/update', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{id}', [KategoriController::class, 'delete'])->name('kategori.delete');
Route::resource('kategori', KategoriController::class);
