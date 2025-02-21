<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="flex justify-center items-center" style="background-color: #0D0D11;">
    <div class="w-full px-6">
        <!-- Sección donde se inyectará el contenido de otras vistas -->
        @yield('contenido')
    </div>
    <footer
        class="bg-[#141318] flex justify-evenly items-center w-[95%] h-20 bottom-4 fixed text-center m-auto rounded-full gap-2">
        <x-button-link route="products.index" icon="chart-pie" />
        <x-button-link route="products.listProducts" icon="bars-staggered" />
        <x-button-link route="products.listProducts" icon="basket-shopping" />
        <x-button-link route="products.listProducts" icon="user-group" />
    </footer>
</body>

</html>
