<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Post</h1>
        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Contenido</label>
                <textarea class="form-control" id="content" name="content" rows="5" required>{{ $post->content }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
