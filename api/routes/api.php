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
    Route::post('/registerAdmin', [AuthController::class, 'registerAdmin'])->name('registerAdmin')->middleware('IsAdminUniv');
    Route::post('/registerEns', [AuthController::class, 'registerEnseignant'])->name('registerEnseignant')->middleware('IsAdminEtab');
});

Route::get('/show/{PPR}', [AdminController::class, 'show'])->name('Admin.show')->middleware('AdminUniv','AdminEtab','Directeur');
Route::get('/show/{email}', [UserController::class, 'show'])->name('User.show');
Route::put('/update/{PPR}', [AdminController::class, 'update'])->name('Admin.update');
Route::put('/update/{email}', [UserController::class, 'update'])->name('User.update');
Route::delete('/destroy/{PPR}', [AdminController::class, 'destroy'])->name('Admin.destroy');
Route::delete('/destroy/{email}', [UserController::class, 'destroy'])->name('User.destroy');