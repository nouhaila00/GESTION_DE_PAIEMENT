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
Route::get('/enseignant/{code}',[EnseignantController::class,'indexByEtab'])->name('listEnseignat');
Route::get ('/enseignant/{ppr}',[EnseignantController::class,'show'])->name('showEnseignat');
Route::put('/enseignants/{ppr}', [EnseignantController::class,'update'])->name('UpdateEnseignant');
Route::delete('/enseignants/{ppr}',  [EnseignantController::class,'destroy'])->name('DeleteEnseignant');

