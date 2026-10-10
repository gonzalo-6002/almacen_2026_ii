<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Almacenes\AlmacenController;

// 1. LEER TODO (GET): http://localhost:8000/api/productos
Route::get('/productos', [AlmacenController::class, 'index']);

// 2. CREAR NUEVO (POST): http://localhost:8000/api/productos
Route::post('/productos', [AlmacenController::class, 'store']);

// 3. EDITAR (PUT): http://localhost:8000/api/productos/{id}
Route::put('/productos/{id}', [AlmacenController::class, 'update']);

// 4. ELIMINAR (DELETE): http://localhost:8000/api/productos/{id}
Route::delete('/productos/{id}', [AlmacenController::class, 'destroy']);
