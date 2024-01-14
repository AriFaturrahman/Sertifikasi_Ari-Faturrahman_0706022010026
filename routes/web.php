<?php

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

Route::get('/', function () {
    return view('koleksi');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/koleksi', function () {
    return view('koleksi');
});

Route::get('/input_peminjam', function () {
    return view('input_peminjam');
});

Route::get('/history_peminjam', function () {
    return view('history_peminjam');
});

Route::get('/update_anggota', function () {
    return view('update_anggota');
});

Route::get('/insert_buku', function () {
    return view('insert_buku');
});

Route::get('/pengembalian', function () {
    return view('pengembalian');
});

//BUAT LOGIN
Route::get('/login', 'App\Http\Controllers\peminjam_bukuController@loginIndex');
Route::post('/login', 'App\Http\Controllers\peminjam_bukuController@send_login');

//BUAT PAGE Koleksi
Route::get('/koleksi', 'App\Http\Controllers\peminjam_bukuController@send_semuaBuku');
Route::get('/', 'App\Http\Controllers\peminjam_bukuController@send_semuaBuku');

// ini untuk insert peminjam
Route::POST('/input_peminjam', 'App\Http\Controllers\peminjam_bukuController@send_insertpeminjam');

// ini untuk menampilkan data peminjam
Route::get('/history_peminjam', 'App\Http\Controllers\peminjam_bukuController@send_semuapeminjam');

//ini untuk update data anggota
Route::POST('/update_anggota', 'App\Http\Controllers\peminjam_bukuController@send_updateanggota');

// ini untuk insert buku baru
Route::POST('/insert_buku', 'App\Http\Controllers\peminjam_bukuController@send_insertbuku');

//ini untuk kembalikan buku
Route::POST('/pengembalian', 'App\Http\Controllers\peminjam_bukuController@send_kembalikanbuku');
