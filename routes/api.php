<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/biodata/allnik', [\App\Http\Controllers\Api\BiodataController::class, 'getAllNIK'])
    ->middleware('auth:sanctum');

Route::post('/biodata', [\App\Http\Controllers\Api\BiodataController::class, 'getBiodataByNIK'])
    ->middleware('auth:sanctum');

Route::post('/pegawai', [\App\Http\Controllers\Api\BiodataController::class, 'getPegawaiByNIK'])
    ->middleware('auth:sanctum');
