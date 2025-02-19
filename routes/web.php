<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
    return redirect()->route('products.index');
});

// Rutas del controlador PostController
Route::get('/dashboard', [ProductController::class, 'index'])->name('products.index');
// Listar posts
Route::get('/products/listProducts', [ProductController::class, 'listProducts'])->name('products.listProducts');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); // Formulario para crear un post
Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // Guardar un nuevo post
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit'); // Formulario para editar un post
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update'); // Actualizar un post existente
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy'); // Eliminar un post
