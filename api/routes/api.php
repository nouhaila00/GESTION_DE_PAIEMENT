<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) 
{
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::group(['middleware' => ['auth:sanctum']], function()
{
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/registerPresident', [AuthController::class, 'registerPresident'])->name('registerPresident')->middleware('IsAdminUniv');
    Route::post('/registerAdmin', [AuthController::class, 'registerAdmin'])->name('registerAdmin')->middleware('IsAdminUniv');
    Route::post('/registerEns', [AuthController::class, 'registerEnseignant'])->name('registerEnseignant')->middleware('IsAdminEtab');
});


Route::get('/showAdmin/{PPR}', [AdminController::class, 'show'])->name('Admin.show');
Route::get('/showUser/{email}', [UserController::class, 'show'])->name('User.show');
Route::put('/updateAdmin/{PPR}', [AdminController::class, 'update'])->name('Admin.update');
Route::put('/updateUser/{email}', [UserController::class, 'update'])->name('User.update');
Route::delete('/destroyAdmin/{PPR}', [AdminController::class, 'destroy'])->name('Admin.destroy');
Route::delete('/destroyUser/{email}', [UserController::class, 'destroy'])->name('User.destroy');