<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3049D0',
                        secondary: '#FF2D75',
                        utils: '#22c55e'
                    },
                },
            },
        };
    </script>
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <form action="{{ route('register.post') }}" method="POST"
            class="bg-white p-6 rounded-xl shadow-md w-full max-w-sm">
            @csrf
            <h1
                class="text-3xl font-black text-center bg-gradient-to-r from-secondary to-primary bg-clip-text text-transparent">
                PanelFresh
            </h1>
            <h2 class="text-2xl font-bold text-center text-gray-600 my-2">Crear una cuenta</h2>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" id="name" name="name" placeholder="Nombre completo"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="Correo electrónico"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Contraseña"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar
                    contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="Confirmar contraseña"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit"
                class="w-full bg-gradient-to-r from-secondary to-primary text-white py-2 px-4 rounded-xl hover:scale-105 transition-transform duration-300">
                Registrarse
            </button>
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
                    ¿Ya tienes una cuenta? Inicia sesión
                </a>
            </div>
        </form>
    </div>
</body>

</html>
