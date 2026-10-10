<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductosController;
<<<<<<< HEAD

Route::get('/', [UsuarioController::class, 'index'])->name('usuarios.index'); 

// 1. Ruta para ver el formulario y la tabla (La pantalla actual)
Route::get('/productos/create', [ProductosController::class, 'create'])->name('productos.create');

// 2. Ruta explícita para procesar el botón de guardar y evitar el error 404
Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');
=======

Route::get('/', [UsuarioController::class, 'index'])->name('usuarios.index'); 

Route::resource('/productos', ProductosController::class);

>>>>>>> cd009214ada4c14d6b74b3fc9f1b7f235d6a0cf2
