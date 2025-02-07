<!-- filepath: /Ubuntu/home/kevinrjg16/sideProjects/laravel/blog/resources/views/posts/edit.blade.php -->
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
        <h1>Editar Producto</h1>
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="product_name" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                    value="{{ $product->product_name }}" required>
            </div>
            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredientes</label>
                <textarea class="form-control" id="ingredients" name="ingredients" rows="5" required>{{ $product->ingredients }}</textarea>
            </div>
            <div class="mb-3">
                <label for="production_cost" class="form-label">Precio de Producción</label>
                <input type="number" step="0.01" class="form-control" id="production_cost" name="production_cost"
                    value="{{ $product->production_cost }}" required>
            </div>
            <div class="mb-3">
                <label for="sale_price" class="form-label">Precio de Venta</label>
                <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price"
                    value="{{ $product->sale_price }}" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}"
                    required>
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>
