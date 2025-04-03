<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3049D0',
                    },
                },
            },
        };
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <title>@yield('title', 'Dashboard')</title>
</head>

<body class="flex h-screen">
    <!-- Header en la parte izquierda -->
    <header class="bg-primary w-1/5 h-full flex flex-col items-center justify-center">
        <div class="h-1/3">
            <img src="{{ asset('storage/llama.png') }}" alt="logo" class="w-32 h-32 bg-white p-2 rounded-full mt-4">
            <h1 class="text-xl text-white text-center font-black mt-2">LlamBoard</h1>
        </div>
        <div class="h-2/3 w-full flex flex-col items-center justify-start gap-1">
            <x-linkNavbar href="{{ route('home.index') }}"> Home </x-linkNavbar>
            <x-linkNavbar href="{{ route('customers.index') }}"> Customers </x-linkNavbar>
            <x-linkNavbar href="{{ route('products.index') }}"> Products </x-linkNavbar>
            <x-linkNavbar href="{{ route('sales.index') }}"> Sales </x-linkNavbar>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-red-500 bg-white px-4 rounded mb-2">
                Logout
            </button>
        </form>
    </header>

    <!-- Contenido principal -->
    <div class="flex flex-col w-full">

        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer siempre al final -->
        {{-- <footer class="">
            <h2>footer</h2>
        </footer> --}}
    </div>
</body>

</html>
