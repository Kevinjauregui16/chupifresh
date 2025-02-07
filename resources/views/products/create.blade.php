<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Crear Producto</h1>

        <!-- Mostrar mensaje de éxito -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form action="{{ route('products.store') }}" method="POST">
            @csrf <!-- Token de seguridad -->

            <div class="mb-3">
                <label for="product_name" class="form-label">Nombre del Producto</label>
                <input type="text" name="product_name" id="product_name" class="form-control"
                    value="{{ old('product_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredientes</label>
                <textarea name="ingredients" id="ingredients" class="form-control" rows="5" required>{{ old('ingredients') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="production_cost" class="form-label">Precio de Producción</label>
                <input type="number" step="0.01" name="production_cost" id="production_cost" class="form-control"
                    value="{{ old('production_cost') }}" required>
            </div>

            <div class="mb-3">
                <label for="sale_price" class="form-label">Precio de Venta</label>
                <input type="number" step="0.01" name="sale_price" id="sale_price" class="form-control"
                    value="{{ old('sale_price') }}" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('products.index') }}" class="btn btn-success">Volver</a>
        </form>
    </div>
</body>

</html>
