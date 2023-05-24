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
    Route::group(['middleware' => ['IsAdminEtab']], function () {
        Route::post('/registerEns', [AuthController::class, 'registerEnseignant'])->name('registerEnseignant');
        Route::post('/intervention',[IntervControlleron::class,'store'])->name('CreateInter')->middleware('IsAdminEtab');
        Route::delete('/intervention/{intervention}', [IntervController::class, 'destroy'])->name('DestroyInter');
        Route::put('/intervention/{intervention}',[IntervControlleron::class,'update'])->name('UpdateInter');
    });
    
    Route::post('/intervention/{id}',[IntervControlleron::class,'index'])->name('IndexInter')->middleware('IsAdminUniv','IsDirecteur','IsAdminEtab');
});

