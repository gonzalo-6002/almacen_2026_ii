<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\Api\Almacenes\AlmacenController;

// 1. LEER TODO (GET): http://localhost:8000/api/productos
Route::get('/productos', [AlmacenController::class, 'index']);

// 2. CREAR NUEVO (POST): http://localhost:8000/api/productos
Route::post('/productos', [AlmacenController::class, 'store']);

// 3. EDITAR (PUT): http://localhost:8000/api/productos/{id}
Route::put('/productos/{id}', [AlmacenController::class, 'update']);

// 4. ELIMINAR (DELETE): http://localhost:8000/api/productos/{id}
Route::delete('/productos/{id}', [AlmacenController::class, 'destroy']);
=======
use App\Http\Controllers\Api\ProductoController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('productos',ProductoController::class);
>>>>>>> cd009214ada4c14d6b74b3fc9f1b7f235d6a0cf2
