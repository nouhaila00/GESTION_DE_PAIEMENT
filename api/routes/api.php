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

Route::get('/showAdmin/{PPR}', [AdminController::class, 'show'])->name('Admin.show')->middleware('IsAdminUniv','IsAdminEtab','IsDirecteur');
Route::get('/showUser/{email}', [UserController::class, 'show'])->name('User.show')->middleware('IsAdminUniv','IsPresident');
Route::put('/updateAdmin/{PPR}', [AdminController::class, 'UpdateByUniv'])->name('Admin.update')->middleware('IsAdminUniv');
Route::put('/update/{PPR}', [AdminController::class, 'update'])->name('Admin.update')->middleware('IsDirecteur','IsAdminEtab');
Route::put('/updateUser/{email}', [UserController::class, 'update'])->name('User.update')->middleware('IsAdminUniv','IsPresident');
Route::delete('/destroyAdmin/{PPR}', [AdminController::class, 'destroy'])->name('Admin.destroy')->middleware('IsAdminUniv');
Route::delete('/destroyUser/{email}', [UserController::class, 'destroy'])->name('User.destroy')->middleware('IsAdminUniv');
