<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\TrabajadorController;

// Rutas para realizar consultas CRUD sobre la tabla incidencias // Control de peticiones en Http/Controllers/

Route::get('/public/post/get',[PostController::class, 'getAll']);

Route::get('/public/post/get/{id}',[PostController::class, 'getById']);

Route::post('/public/post/create',[PostController::class, 'createIncidencia']);

Route::put('/public/post/update/{id}', [PostController::class, 'updateIncidencia']);

Route::delete('/public/post/delete/{id}', [PostController::class, 'deleteIncidencia']);

// Rutas para realizar consultas CRUD sobre la tabla trabajadores NO implementadas en este proyecto

// Route::get('/public/post/trabajador/get',[TrabajadorController::class, 'getAll']);

// Route::get('/public/post/trabajador/get/{id}',[TrabajadorController::class, 'getById']);

// Route::post('/public/post/trabajador/create',[TrabajadorController::class, 'createTrabajador']);
// // Por las reglas de la base de datos al actualizar datos de un trabajador los datos que consten en otras tablas tambien se actualizan
// Route::put('/public/post/trabajador/update/{id}', [TrabajadorController::class, 'updateTrabajador']);
// // Por las reglas de la base de datos, los trabajadores son dependientes de sus incidencias por lo que no se pueden eliminar
// Route::delete('/public/post/trabajador/delete/{id}', [TrabajadorController::class, 'deleteTrabajador']);