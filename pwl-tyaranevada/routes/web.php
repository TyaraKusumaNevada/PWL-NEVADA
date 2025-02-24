<?php
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/hello', [WelcomeController::class,'hello']);

// Route::get('/user/{name?}', function ($name='John') { 
//     return 'Nama saya '.$name; 
// }); 


//  Route::get('/user/{name}', function ($name) { 
//    return 'Nama saya '.$name; 
//  }); 


// Route::get('/articles/{id}', function ($id) { 
//     return 'Halaman Artikel dengan ID ' . $id; 
// });


// Route::get('/posts/{post}/comments/{comment}', function 
// ($postId, $commentId) { 
// return 'Pos ke-'.$postId." Komentar ke-: ".$commentId; 
// }); 


// Route::get('/', function () {
//     return 'Selamat Datang';
// });


// Route::get('/about', function () {
//     return 'NIM: 2341720019 & Nama: Tyara Kusuma Nevada';
// });


// Route::get('/world', function () { 
//  return 'World'; 
// }); 


// Route::get('/hello', function () {    
//     return 'Hello World'; }); 


// Route::get('/', function () {
//     return view('welcome');
// });


