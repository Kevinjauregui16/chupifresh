<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body class="px-6 bg-[#0D0D11]">
    <div>

        <x-tittle-component tittle="CREAR/EDITAR" />
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
        <form action="{{ route('products.store') }}" method="POST"
            class="mt-8 bg-[#141318] rounded-xl p-6 text-gray-200">
            @csrf <!-- Token de seguridad -->

            <div class="mb-3">
                <label for="product_name" class="form-label">Nombre del Producto</label>
                <input type="text" name="product_name" id="product_name" class="form-control bg-gray-200"
                    value="{{ old('product_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredientes</label>
                <textarea name="ingredients" id="ingredients" class="form-control bg-gray-200" rows="5" required>{{ old('ingredients') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="production_cost" class="form-label">Precio de Producción</label>
                <input type="number" step="0.01" name="production_cost" id="production_cost"
                    class="form-control bg-gray-200" value="{{ old('production_cost') }}" required>
            </div>

            <div class="mb-3">
                <label for="sale_price" class="form-label">Precio de Venta</label>
                <input type="number" step="0.01" name="sale_price" id="sale_price" class="form-control bg-gray-200"
                    value="{{ old('sale_price') }}" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control bg-gray-200"
                    value="{{ old('stock') }}" required>
            </div>

            <div class="flex items-center justify-between gap-2 mt-4">
                <a href="{{ route('products.listProducts') }}" class="btn btn-danger w-1/2">Volver</a>
                <button type="submit" class="btn btn-success w-1/2">Guardar</button>
            </div>
        </form>
    </div>
</body>

</html>
