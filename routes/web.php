<?php

use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Cambia esta ruta
Route::get('/', [TaskController::class, 'index'])->name('home');

// El resto de tus rutas permanecen igual
Route::resource('tasks', TaskController::class);
Route::put('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

Route::get('/registrar', [RegisterUserController::class, 'create'])->name('registrar.create');    
Route::post('/registrar', [RegisterUserController::class, 'store'])->name('registrar.store');
Route::get('/login', [SessionController::class, 'create'])->name('login.create');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::get('/logout', [SessionController::class, 'destroy'])->name('logout');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');