<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index']);
    Route::post('login', [LoginController::class, 'loginProcess'])->name('login');
    Route::post('registration', [LoginController::class, 'registrationProcess'])->name('registration');
});
Route::middleware(['auth'])->group(function () {
    Route::middleware(['user'])->group(function () {
        Route::get('/', [HomeController::class, 'index']);
    });

    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('user/datatable', [UserController::class, 'indexDatatable'])->name('user.datatable');
        Route::get('user/{id}/{any}/approve', [UserController::class, 'approveUser'])->name('user.approve');
        Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('user/{id}/update', [UserController::class, 'update'])->name('user.update');
        Route::get('user/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

