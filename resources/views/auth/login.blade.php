<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <form action="{{ route('login.post') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm">
            @csrf
            <h2 class="text-2xl font-bold text-center mb-6">Iniciar sesión</h2>
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
            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Iniciar sesión
            </button>
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">
                    ¿No tienes una cuenta? Regístrate
                </a>
            </div>
        </form>
    </div>
</body>

</html>
