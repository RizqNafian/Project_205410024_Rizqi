<?php

use App\Http\Controllers\MstPangkatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SegiEmpatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MstJabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RiwayatPangkatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Main

Route::get('/', function () {
    return view('welcome');
});

//Home Controler

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

//Praktik

Route::get('/webKu', function () {
    return "Apa kabar...........";
});

//route/web.php
$logic = function()
{
    return 'Hello Apa kabhar Badiyanto..........!';
};
Route::get('webKu1', $logic);

Route::get('satu/page', function() {
    return 'Yang ke Satu!';
});
Route::get('dua/page', function() {
    return 'Yang ke Dua!';
});
Route::get('tiga/page', function() {
    return 'Anda Hebat.......!';
});

Route::get('/buku/{judul}', function($judul)
{
    return "Buku <b>{$judul}</b> adalah termasuk buku komputer.";
});

Route::get('/coba', function()
{
return '
    <!doctype html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Coba laravel!</title>
        </head>
        <body>
            <p>SELAMAT ANDA BELAJAR LARAVEL</p>
        </body>
    </html>';
});



//Segi Empat Controller

Route::get('segi-empat/inputSegiEmpat', [SegiEmpatController::class, 'inputSegiEmpat'])
 ->name('segi-empat.inputSegiEmpat');

Route::post('segi-empat/hasil', [SegiEmpatController::class, 'hasil'])
 ->name('segi-empat.hasil'); 

Route::get('segi-empat/inputBalok',[SegiEmpatController::class, 'inputBalok'])
 ->name('segi-empat.inputBalok');

Route::post('segi-empat/hasilBalok',[SegiEmpatController::class, 'hasilBalok'])
 ->name('segi-empat.hasilBalok'); 

//user
Route::get('users', [UserController::class, 'index'])
 ->name('users.index');
Route::get('users/{id}', [UserController::class, 'destroy'])
 ->name('users.destroy');
Route::get('users/{id}', [UserController::class, 'input'])
 ->name('users.destroy');

//Master Pangkat
Route::resource('mst-pangkat',MstPangkatController::class)->except('destroy');
Route::get('delpangkat/{id}', [MstJabatanController::class, 'destroy'])
 ->name('mst-pangkat.destroy');

//Master Jabatan
Route::resource('mst-jabatan',MstJabatanController::class)->except('destroy');
Route::get('deljabatan/{id}', [MstJabatanController::class, 'destroy'])
 ->name('mst-jabatan.destroy');

//Pegawai
Route::resource('pegawai',PegawaiController::class)->except('destroy');
Route::get('delpegawai/{id}', [PegawaiController::class, 'destroy'])
 ->name('pegawai.destroy');

//Riwayat Pangkat
Route::resource('riwayat-pangkat',RiwayatPangkatController::class)->except(['destroy','create']);
Route::get('proses/{id}', [RiwayatPangkatController::class, 'proses'])
->name('riwayat-pangkat.proses');
Route::get('riwayat-pangkat/create/{id}',[RiwayatPangkatController::class,'create']);
Route::get('delpangkat/{id}', [RiwayatPangkatController::class, 'destroy'])
 ->name('riwayat-pangkat.destroy');
Route::get('/riwayat-pangkat/cetak/{id}',[RiwayatPangkatController::class,'cetak'])
->name('riwayat-pangkat.cetak');
