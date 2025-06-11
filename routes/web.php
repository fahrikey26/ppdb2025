<?php

use App\Http\Controllers\DashboardCon;
use App\Http\Controllers\LoginCon;
use App\Http\Controllers\PendaftarCon;
use App\Http\Controllers\RegisterCon;
use App\Http\Controllers\UserCon;
use Illuminate\Support\Facades\Route;

//home
Route::get('/', [LoginCon::class, 'home'])->name('home');

//login
Route::get('login', [LoginCon::class, 'login'])->name('login');
Route::post('actionlogin', [LoginCon::class, 'actionlogin'])->name('actionlogin');
Route::get('dashboard', [DashboardCon::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('actionlogout', [LoginCon::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

//register
Route::get('register', [RegisterCon::class, 'register'])->name('register');
Route::post('register/action', [RegisterCon::class, 'actionregister'])->name('actionregister');

//user
Route::get('user/tampil', [UserCon::class, 'index'])->name('indexUser')->middleware('auth');
Route::get('user/input', [UserCon::class, 'input'])->name('inputUser')->middleware('auth');
Route::post('user/storeinput', [UserCon::class, 'storeinput'])->name('storeInputUser')->middleware('auth');
Route::get('user/update/{id}', [UserCon::class, 'update'])->name('updateUser')->middleware('auth');
Route::post('user/storeupdate', [UserCon::class, 'storeupdate'])->name('storeUpdateUser')->middleware('auth');
Route::get('user/delete/{id}', [UserCon::class, 'delete'])->name('deleteUser')->middleware('auth');

//pendaftar
Route::get('pendaftar/tampil', [PendaftarCon::class, 'index'])->name('indexPendaftar')->middleware('auth');
Route::get('pendaftar/nominasi', [PendaftarCon::class, 'nominasi'])->name('nominasiPendaftar')->middleware('auth');
Route::get('pendaftar/nominasi2', [PendaftarCon::class, 'jurusan'])->name('nominasi2Pendaftar')->middleware('auth');
Route::get('pendaftar/diterima', [PendaftarCon::class, 'diterima'])->name('diterimaPendaftar')->middleware('auth');
Route::get('pendaftar/status', [PendaftarCon::class, 'statusPenerimaan'])->name('statusPendaftar')->middleware('auth');
Route::get('pendaftar/update/{id}', [PendaftarCon::class, 'update'])->name('updatePendaftar')->middleware('auth');
Route::post('pendaftar/storeupdate', [PendaftarCon::class, 'storeupdate'])->name('storeUpdatePendaftar')->middleware('auth');
Route::get('pendaftar/delete/{id}', [PendaftarCon::class, 'delete'])->name('deletePendaftar')->middleware('auth');