<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticating']);
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'registerProses']);
Route::get('logout', [AuthController::class, 'logout']);

Route::get('dashboard', [DashboardController::class, 'index']);
Route::get('home', [HomeController::class, 'index']);
Route::get('profile', [UserController::class, 'profile']);

Route::get('room', [RoomController::class, 'index'])->name('room');
Route::get('room-add', [RoomController::class, 'create'])->name('create');
Route::post('room-add', [RoomController::class, 'store'])->name('room-store');
Route::get('room/edit/{id}', [RoomController::class, 'edit'])->name('room-edit');
Route::put('room/update/{id}', [RoomController::class, 'update'])->name('room-update');
Route::delete('room/delete/{id}', [RoomController::class, 'destroy'])->name('room-destroy');

Route::get('fasilitas', [FasilitasController::class, 'index'])->name('fasilitas');
Route::get('fasilitas-add', [FasilitasController::class, 'create'])->name('create-fasilitas');
Route::post('fasilitas-store', [FasilitasController::class, 'store'])->name('fasilitas-store');
Route::get('fasilitas/edit/{id}', [FasilitasController::class, 'edit'])->name('fasilitas-edit');
Route::put('fasilitas/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
Route::delete('fasilitas-delete/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas-destroy');

Route::get('item', [ItemController::class, 'index'])->name('item');
Route::get('item-add', [ItemController::class, 'add'])->name('item-add');
Route::post('item-add', [ItemController::class, 'store'])->name('item-store');
Route::get('item/edit/{id}', [itemController::class, 'edit'])->name('item-edit');
Route::put('item-edit/{id}', [ItemController::class, 'update'])->name('item-update');
Route::delete('item-delete/{id}', [ItemController::class, 'destroy'])->name('item-destroy');


Route::get('users', [UserController::class, 'index']);
Route::get('registered-user', [UserController::class, 'registeredUser']);
Route::get('user-detail', [UserController::class, 'show']);

Route::post('/user/approve/{id}', [UserController::class, 'approve'])->name('users.approve');
Route::delete('/user/reject/{id}', [UserController::class, 'reject'])->name('users.reject');
