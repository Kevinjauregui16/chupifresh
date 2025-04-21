<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name"theme-color" content="#3049D0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <header class=" w-72 h-full flex flex-col items-center justify-center">
        <div class="h-1/5 flex justify-center items-center">
            <img src="{{ asset('llama.png') }}" alt="logo" class="w-16 h-16 bg-white rounded-full">
            <h1 class="text-2xl text-primary text-center font-black">LlamBoard</h1>
        </div>
        <div class="h-4/5 w-full flex flex-col justify-start gap-1 bg-primary pt-10 rounded-tr-[110px]">
            <x-linkNavbar href="{{ route('home.index') }}" icon="{{ 'house' }}"> Home </x-linkNavbar>
            <x-linkNavbar href="{{ route('customers.index') }}" icon="{{ 'users' }}"> Customers </x-linkNavbar>
            <x-linkNavbar href="{{ route('products.index') }}" icon="{{ 'tag' }}"> Products </x-linkNavbar>
            <x-linkNavbar href="{{ route('sales.index') }}" icon="{{ 'cart-shopping' }}"> Sales </x-linkNavbar>
        </div>
        {{-- <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-black bg-opacity-40 text-red-500 mb-4 text-lg font-semibold px-2 py-1 rounded-lg">
                Logout
                <i class="fa-solid fa-right-from-bracket"></i>
            </button>
        </form> --}}
    </header>

    <!-- Contenido principal -->
    <div class="flex flex-col w-full">
        <main class="flex-grow">
            @yield('content')
        </main>
    </div>
</body>

</html>
