<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="max-w-4xl mx-auto p-6 mt-5 bg-white shadow-xl rounded-2xl">
        <h1 class="mb-6 text-3xl font-bold text-center text-gray-600">Lista de Posts</h1>

        <!-- Botón para crear un nuevo post -->
        <div class="mb-4 text-right">
            <a href="{{ route('posts.create') }}"
                class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Crear
                Nuevo Post</a>
        </div>

        <!-- Verificar si hay posts -->
        @if ($posts->isEmpty())
            <p class="text-center text-lg text-gray-600">No hay posts disponibles.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md border-collapse">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 border-b text-left text-gray-700">ID</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Título</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Contenido</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Fecha de Creación</th>
                            <th class="py-2 px-4 border-b text-left text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-gray-600">{{ $post->id }}</td>
                                <td class="py-2 px-4 border-b text-gray-600">{{ $post->title }}</td>
                                <td class="py-2 px-4 border-b text-gray-600">{{ $post->content }}</td>
                                <td class="py-2 px-4 border-b text-gray-600">
                                    {{ $post->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <!-- Botón de Editar -->
                                    <a href="{{ route('posts.edit', $post->id) }}"
                                        class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Editar</a>

                                    <!-- Botón de Eliminar -->
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>

</html>
