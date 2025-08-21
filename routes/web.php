<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/kirimemail', [App\Http\Controllers\TestController::class, 'kirimemail']);

Route::get('/register', [App\Http\Controllers\MyController::class, 'register'])
    ->name('register');
Route::post('/register', [App\Http\Controllers\MyController::class, 'registerStore'])
    ->name('register.post');

Route::get('/gotopost/{id}', [App\Http\Controllers\MyController::class, 'goToPost'])->name('post.goTo')->middleware('auth');
Route::get('/openfile/{fileName}', [App\Http\Controllers\MyController::class, 'openFile'])->name('file.open')->middleware('auth');
