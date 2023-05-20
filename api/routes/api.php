<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnseignantController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, "login"])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function()
{
    Route::post('/logout', [AuthController::class, "logout"])->name('logout');



});
Route::get('/enseignant/{idet}',[EnseignantController::class,'indexByEtab'])->name('listEnseignat');
Route::get ('/enseignant/{id}',[EnseignantController::class,'show'])->name('showEnseignat');
Route::put('/enseignants/{id}', [EnseignantController::class,'update'])->name('UpdateEnseignant');
Route::delete('/enseignants/{id}',  [EnseignantController::class,'destroy'])->name('DeleteEnseignant');

