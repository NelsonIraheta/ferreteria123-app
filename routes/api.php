<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\ProductoController;
use App\Http\Controllers\API\EmpleadoController;

use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/* 
Con esta forma las apis producto y empleado son publicas y cualquiera puede acceder.
Route::apiResource('producto', ProductoController::class);
Route::apiResource('empleado', EmpleadoController::class); 
*/

// 1. Rutas Públicas (Cualquiera puede acceder)
Route::post('/login', [AuthController::class, 'login']);

// 2. Rutas Protegidas (Exigen encabezado 'Authorization: Bearer <token>')
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/perfil', [AuthController::class, 'perfil']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Operaciones del inventario protegidas
    Route::apiResource('productos', ProductoController::class)->names('api.productos');
    Route::apiResource('empleado', EmpleadoController::class);
});

?>