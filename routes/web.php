<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web de tu aplicación. Estas
| rutas son cargadas por el RouteServiceProvider y contienen el middleware
| "web". ¡Ahora crea algo grandioso!
|
*/

// Ruta principal que redirige al listado de posts
Route::get('/', function () {
    return redirect()->route('posts.index');
});

// Rutas del controlador PostController
Route::get('/posts', [PostController::class, 'index'])->name('posts.index'); // Listar posts
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create'); // Formulario para crear un post
Route::post('/posts', [PostController::class, 'store'])->name('posts.store'); // Guardar un nuevo post
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit'); // Formulario para editar un post
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update'); // Actualizar un post existente
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy'); // Eliminar un post
