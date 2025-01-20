<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    // Método para mostrar todos los posts
    public function index()
    {
        // Obtener todos los posts de la base de datos
        $posts = Post::all();

        // Retornar la vista con los posts
        return view('posts.index', compact('posts'));
    }
    // Guarda el post en la base de datos
    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Crear el post
        Post::create($validated);

        // Redirigir con un mensaje de éxito
        return redirect()->route('posts.create')->with('success', 'Post creado con éxito.');
    }

    // Muestra el formulario para crear un nuevo post
    public function create()
    {
        return view('posts.create');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($validated);

        return redirect()->route('posts.index')->with('success', 'Post actualizado con éxito');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post eliminado con éxito');
    }
}
