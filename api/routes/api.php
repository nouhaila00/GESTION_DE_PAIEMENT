<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IntervController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request)
{
    return $request->user();
});

Route::post('/login', [AuthController::class, "login"])->name('login');


Route::group(['middleware' => ['auth:sanctum']], function()
{
    Route::post('/logout', [AuthController::class, "logout"])->name('logout');
    Route::post('/registerAdmin', [AuthController::class, 'registerAdmin'])->name('registerAdmin')->middleware('IsAdminUniv');
    Route::post('/registerEns', [AuthController::class, 'registerEnseignant'])->name('registerEnseignant')->middleware('IsAdminEtab');
});
Route::post('/intervention',[IntervControlleron::class,'create'])->name('CreateInter');
Route::delete('/intervention/{intervention}',[IntervControlleron::class,'destroy'])->name('DestroyInter');
