<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\PinjamRuangController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
// use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('login');
})->middleware('auth');



Route::group(['middleware' => 'guest'], function () {


    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticating']);
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerProses']);
});

Route::get('auth/redirect', [GoogleAuthController::class, 'redirect']);
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/getChartData/{roomId}', [DashboardController::class, 'getChartData']);
    Route::get('/getRentData/{year}/{month}', [DashboardController::class, 'getRentData']);
    // Route::get('/getChartData/{roomId}', [DashboardController::class, 'getChartData'])->name('getChartData');



    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile-edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
   


    
    //Menu Umat
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('detail-ruang/{id}', [HomeController::class, 'detail'])->name('detail-ruang');
    Route::get('pinjam-ruang', [PinjamRuangController::class, 'index'])->name('pinjam-ruang');
    Route::get('keranjang', [UserController::class, 'keranjang']);

    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');


    Route::get('room', [RoomController::class, 'index'])->name('room');
    Route::get('room-add', [RoomController::class, 'create'])->name('create');
    Route::post('room-add', [RoomController::class, 'store'])->name('room-store');
    Route::get('room/edit/{id}', [RoomController::class, 'edit'])->name('room-edit');
    Route::put('room/update/{id}', [RoomController::class, 'update'])->name('room-update');
    Route::delete('room/delete/{id}', [RoomController::class, 'destroy'])->name('room-destroy');
    Route::get('/room/{id}', [RoomController::class, 'show'])->name('room.show');

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

    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('registered-user', [UserController::class, 'registeredUser']);
    Route::get('user-detail/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/user/approve/{id}', [UserController::class, 'approve'])->name('users.approve');
    Route::delete('/user/reject/{id}', [UserController::class, 'reject'])->name('users.reject');
    Route::put('/user/promote/{id}', [UserController::class, 'promote'])->name('users.promote');
    Route::put('/user/demote/{id}', [UserController::class, 'demote'])->name('users.demote');

    Route::get('pinjam-add', [CalendarController::class, 'create'])->name('pinjam.create');
    Route::post('pinjam-store', [CalendarController::class, 'store'])->name('pinjam.store');
    Route::get('/events', [CalendarController::class, 'getEvents'])->name('events');

    //Route Peminjaman Admin
    Route::get('rent', [RentController::class, 'rent'])->name('rent');
    Route::post('/rents/approve/{id}', [RentController::class, 'approve'])->name('rents.approve');
    Route::post('/rents/reject/{id}', [RentController::class, 'reject'])->name('rents.reject');
    Route::delete('/rents/cancel/{id}', [RentController::class, 'cancel'])->name('rents.cancel');

    Route::get('/send-email', [MailController::class, 'email']);
    Route::post('/send-email', [MailController::class, 'sendEmail']);
    Route::post('/rents/{id}/approve-email', [RentController::class, 'approveEmail'])->name('rents.approveEmail');

    
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
