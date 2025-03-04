<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

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

Route::get('/', function () { //definisi untuk halaman utama (/)
    return view('welcome');
}); // ketika mengakses (/), akan ditampilkan halaman welcome.blade.php yang ada di folder resources/views

Route::resource('stocks',StockController::class);
